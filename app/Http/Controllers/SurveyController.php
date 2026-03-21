<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function store(StoreSurveyRequest $request)
{
    $user = Auth::user();

    $beneficiary = $user->beneficiary;

    if (!$beneficiary) {
        return response()->json([
            'message' => 'هذا المستخدم ليس مستفيد'
        ], 403);
    }

    $data = $request->validated();

    $data['beneficiary_id'] = $beneficiary->id;

    if ($request->activity_id) {
        $data['program_id'] = null;
    } else {
        $data['activity_id'] = null;
    }

    $survey = Survey::create($data);

    $survey->load(['beneficiary', 'activity', 'program']);

    return response()->json([
        'message' => 'تم إنشاء الاستبيان',
        'data' => $survey
    ], 201);
}

    public function update(UpdateSurveyRequest $request, Survey $survey)
{
    $user = Auth::user();
    $beneficiary = $user->beneficiary;

    if (!$beneficiary || $survey->beneficiary_id !== $beneficiary->id) {
        return response()->json([
            'message' => 'غير مصرح'
        ], 403);
    }

    $data = $request->validated();

    if ($request->activity_id) {
        $data['program_id'] = null;
    }

    if ($request->program_id) {
        $data['activity_id'] = null;
    }

    $survey->update($data);

    return response()->json([
        'message' => 'تم التحديث',
        'data' => $survey
    ]);
}
    public function destroy(Survey $survey)
{
    $user = Auth::user();
    $beneficiary = $user->beneficiary;

    if (!$beneficiary || $survey->beneficiary_id !== $beneficiary->id) {
        return response()->json([
            'message' => 'غير مصرح'
        ], 403);
    }

    $survey->delete();

    return response()->json([
        'message' => 'تم الحذف'
    ]);
}

    public function index()
{
    $user = Auth::user();
    $employee = $user->employee;

    if (
        !$employee ||
        !in_array($employee->position, ['system_admin', 'field_coordinator'])
    ) {
        return response()->json([
            'message' => 'غير مصرح'
        ], 403);
    }

    $surveys = Survey::with(['beneficiary', 'activity', 'program'])
        ->latest()
        ->paginate(15);

    return response()->json(['data' => $surveys]);
}

    public function show(Survey $survey)
{
    $user = Auth::user();
    $employee = $user->employee;

    if (
        !$employee ||
        !in_array($employee->position, ['system_admin', 'field_coordinator'])
    ) {
        return response()->json([
            'message' => 'غير مصرح'
        ], 403);
    }

    $survey->load(['beneficiary', 'activity', 'program']);

    return response()->json([
        'data' => $survey
    ]);
}

public function getAvgRating($type, $id)
{
    if (!in_array($type, ['program', 'activity'])) {
        return response()->json([
            'message' => 'type يجب أن يكون program أو activity'
        ], 400);
    }

    $query = Survey::query();

    if ($type === 'program') {
        $query->where('program_id', $id);
    } else {
        $query->where('activity_id', $id);
    }

    $avg = $query
        ->selectRaw('AVG(general_rating + 0) as avg_rating')
        ->value('avg_rating');

    return response()->json([
        'type' => $type,
        'id' => $id,
        'average_general_rating' => $avg ? round($avg, 2) : 0
    ]);
}

public function getAllSurveies($type, $id)
{

        $user = Auth::user();
    $employee = $user->employee;

    if (
        !$employee ||
        !in_array($employee->position, ['system_admin', 'field_coordinator'])
    ) {
        return response()->json([
            'message' => 'غير مصرح'
        ], 403);
    }

    if (!in_array($type, ['program', 'activity'])) {
        return response()->json([
            'message' => 'type يجب أن يكون program أو activity'
        ], 400);
    }

    $query = Survey::query();

    if ($type === 'program') {
        $query->where('program_id', $id)->paginate(15);
    } else {
        $query->where('activity_id', $id)->paginate(15);
    }


    return response()->json([
        'type' => $type,
        'data' => $query 
    ]);
}



}
