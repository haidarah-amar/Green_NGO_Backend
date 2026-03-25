<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Illuminate\Support\Facades\Auth;

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
    }

    $data['employee_id'] = $employee->id;

    $report = Report::create($data);

    return response()->json($report, 201);
}


    public function show($id)
    {
        $this->checkEmployee();

        $report = Report::with(['project', 'grant', 'employee'])->findOrFail($id);

        return response()->json([
            'message' => 'Updated successfully',
            'data' => $report
        ]); 
    }

    public function update(UpdateReportRequest $request, $id)
    {
        $this->checkEmployee();

        $report = Report::findOrFail($id);

        if ($request->hasFile('file')) {
        $path = $request->file('file')->store('reports', 'public');
        $data['file_url'] = asset('storage/' . $path);
    }

        $report->update($request->validated());

        return response()->json([
            'message' => 'Updated successfully',
            'data' => $report
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

