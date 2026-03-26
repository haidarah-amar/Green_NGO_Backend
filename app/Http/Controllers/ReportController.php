<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReportController extends Controller
{

    private function checkEmployee()
    {
        if (Auth::user()->role !== 'employee') {
            abort(response()->json(['message' => 'Unauthorized'], 403));
        }
    }

    public function index()
    {
        $this->checkEmployee();

        $reports = Report::with(['project', 'grant', 'employee'])->latest()->get();

        return response()->json($reports);
    }

    public function store(StoreReportRequest $request)
{
    $this->checkEmployee();

    $employee = Auth::user()->employee;
    $data = $request->validated();

    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('reports', 'public');
        $data['file_url'] = asset('storage/' . $path);
    } elseif (!empty($data['file_url'])) {
        $externalUrl = $data['file_url'];

        $response = Http::timeout(60)->get($externalUrl);

        if (!$response->successful()) {
            return response()->json([
                'message' => 'فشل تحميل الملف من الرابط الخارجي'
            ], 422);
        }

        $pathInfo = pathinfo(parse_url($externalUrl, PHP_URL_PATH));
        $extension = strtolower($pathInfo['extension'] ?? '');

        if (!$extension) {
            $contentType = $response->header('Content-Type');

            $extension = match ($contentType) {
                'application/pdf' => 'pdf',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
                'application/vnd.ms-excel' => 'xls',
                default => '',
            };
        }

        if (!in_array($extension, ['pdf', 'xlsx', 'xls'])) {
            return response()->json([
                'message' => 'نوع الملف غير مسموح'
            ], 422);
        }

        $fileName = 'report_' . time() . '_' . Str::random(10) . '.' . $extension;
        $path = 'reports/' . $fileName;

        Storage::disk('public')->put($path, $response->body());
        $data['file_url'] = asset('storage/' . $path);
    }

    unset($data['file']); // هذا هو الحل المهم

    $data['employee_id'] = $employee->id;

    $report = Report::create($data);

    return response()->json([
        'message' => 'تم إنشاء التقرير بنجاح',
        'data' => $report
    ], 201);
}


    public function show($id)
    {
        $this->checkEmployee();

        $report = Report::with(['project', 'grant', 'employee'])->findOrFail($id);

        return response()->json([
            'data' => $report
        ]); 
    }

public function update(UpdateReportRequest $request, $id)
{
    $this->checkEmployee();

    $report = Report::findOrFail($id);

    $data = $request->safe()->except(['file']);

    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('reports', 'public');
        $data['file_url'] = asset('storage/' . $path);
    }

    elseif (!empty($data['file_url'])) {
        $externalUrl = $data['file_url'];

        $response = Http::timeout(60)->get($externalUrl);

        if (!$response->successful()) {
            return response()->json([
                'message' => 'فشل تحميل الملف من الرابط الخارجي'
            ], 422);
        }

        $pathInfo = pathinfo(parse_url($externalUrl, PHP_URL_PATH));
        $extension = strtolower($pathInfo['extension'] ?? '');

        if (!$extension) {
            $contentType = $response->header('Content-Type');

            $extension = match ($contentType) {
                'application/pdf' => 'pdf',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
                'application/vnd.ms-excel' => 'xls',
                default => '',
            };
        }

        if (!in_array($extension, ['pdf', 'xlsx', 'xls'])) {
            return response()->json([
                'message' => 'نوع الملف غير مسموح، المسموح فقط: pdf, xlsx, xls'
            ], 422);
        }

        $fileName = 'report_' . time() . '_' . Str::random(10) . '.' . $extension;
        $path = 'reports/' . $fileName;

        Storage::disk('public')->put($path, $response->body());

        $data['file_url'] = asset('storage/' . $path);
    }

    $report->update($data);

    return response()->json([
        'message' => 'تم تحديث بيانات التقرير بنجاح',
        'data' => $report->fresh()
    ]);
}

    public function destroy($id)
    {
        $this->checkEmployee();

        $report = Report::findOrFail($id);

        $report->delete();

        return response()->json(['message' => 'تم حذف التقرير بنجاح']);
    }


public function getReportsByEmployee($employeeId)
{
    $this->checkEmployee();

    $reports = Report::with(['project', 'grant', 'employee'])
        ->where('employee_id', $employeeId)
        ->latest()
        ->get();

    return response()->json($reports);
}

    public function getReportsByGrant($grantId)
{
    $this->checkEmployee();

    $reports = Report::with(['project', 'grant', 'employee'])
        ->where('grant_id', $grantId)
        ->latest()
        ->get();

    return response()->json($reports);
}


public function getReportsByProject($projectId)
{
    $this->checkEmployee();

    $reports = Report::with(['project', 'grant', 'employee'])
        ->where('project_id', $projectId)
        ->latest()
        ->get();

    return response()->json($reports);
}

}

