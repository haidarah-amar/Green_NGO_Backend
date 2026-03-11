<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(10);
        return response()->json($projects);
    }
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }
    
    public function store(StoreProjectRequest $request)
    {

        $user = Auth::user();

        $employee = Employee::where('user_id',$user->id)->first();

        if(!$employee || !in_array($employee->position,['system_admin','project_manager'])){
            return response()->json([
                'message' => 'Unauthorized'
            ],403);
        }

        $project = Project::create($request->validated());

        return response()->json([
            'message' => 'تمت اضافة مشروع بنجاح',
            'data' => $project
        ],201);
    }



    public function update(UpdateProjectRequest $request , $id)
    {

        $user = Auth::user();

        $employee = Employee::where('user_id',$user->id)->first();

        if(!$employee || !in_array($employee->position,['system_admin','project_manager'])){
            return response()->json([
                'message' => 'Unauthorized'
            ],403);
        }

        $project = Project::findOrFail($id);

        $project->update($request->validated());

        return response()->json([
            'message' => 'تم تعديل ملعومات المشروع بنجاح',
            'data' => $project
        ]);
    }

    public function destroy($id)
{
    $user = Auth::user();

    $employee = Employee::where('user_id', $user->id)->first();

    if (!$employee || !in_array($employee->position, ['system_admin','project_manager'])) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 403);
    }

    $project = Project::findOrFail($id);

    $project->delete();

    return response()->json([
        'message' => 'تم حذف المشروع بنجاح'
    ]);
}



}
