<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ApplyToActivityJob;

class ActivityController extends Controller
{
    private function authorizeRoles()
{
    $user = Auth::user();

    if (!in_array($user->employee->position, [
        'mel_officer',
        'system_admin',
        'program_manager'
    ])) {

        abort(403, 'Unauthorized');
    }
}


    public function index()
    {
        $activities = Activity::with(['program','melOfficer'])->latest()->paginate(10);

        return response()->json($activities);
    }


    public function show($id)
    {
        $activity = Activity::with(['program','melOfficer'])->findOrFail($id);

        return response()->json($activity);
    }


    public function store(StoreActivityRequest $request)
    {
        $this->authorizeRoles();

        $activity = Activity::create($request->validated());

        return response()->json([
        'message' => 'تمت إضافة النشاط بنجاح',
        'data' => $activity
            ],201);
    }


    public function update(UpdateActivityRequest $request,$id)
    {
        $this->authorizeRoles();

        $activity = Activity::findOrFail($id);

        $activity->update($request->validated());

        return response()->json([
            'message' => 'تم تحديث معلومات النشاط بنجاح',
            'data' => $activity
        ]);
    }


    public function destroy($id)
    {
        $this->authorizeRoles();

        $activity = Activity::findOrFail($id);

        $activity->delete();

        return response()->json([
            'message' => 'تم حذف النشاط بنجاح'
        ]);
    }

    public function programActivities($programId)
{
    return Activity::where('program_id',$programId)->get();
}

public function apply($activityId)
    {
        $beneficiary = Auth::user()->beneficiary;

        ApplyToActivityJob::dispatch($beneficiary->id, $activityId);

        return response()->json([
            'message' => 'تم استلام طلب التقديم'
        ]);
    }
}
