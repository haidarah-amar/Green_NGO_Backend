<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Jobs\ApplyToProgramJob;
use App\Models\Employee;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::paginate(10);
        return response()->json($programs);
    }
    public function show($id)
    {
        $program = Program::findOrFail($id);
        return response()->json($program);
    }

     private function authorizeEmployee()
    {
        $user = Auth::user();

        $employee = Employee::where('user_id',$user->id)->first();

        if(!$employee || !in_array($employee->position,['system_admin','program_manager'])){
            abort(response()->json([
                'message' => 'Unauthorized'
            ],403));
        }
    }


    // public function index()
    // {
    //     return response()->json(
    //         Program::with(['project','manager'])->paginate(10)
    //     );
    // }


    // public function show($id)
    // {
    //     $program = Program::with(['project','manager'])->findOrFail($id);

    //     return response()->json($program);
    // }


    public function store(StoreProgramRequest $request)
    {

        $this->authorizeEmployee();

        $program = Program::create($request->validated());

        return response()->json([
            'message' => 'تمت إضافة البرنامج بنجاح',
            'data' => $program
        ],201);

    }


    public function update(UpdateProgramRequest $request,$id)
    {

        $this->authorizeEmployee();

        $program = Program::findOrFail($id);

        $program->update($request->validated());

        return response()->json([
            'message' => 'تم تعديل البرنامج بنجاح',
            'data' => $program
        ]);

    }


    public function destroy($id)
    {

        $this->authorizeEmployee();

        $program = Program::findOrFail($id);

        $program->delete();

        return response()->json([
            'message' => 'تم حذف البرنامج بنجاح'
        ]);

    }

    public function apply($programId)
{
    $beneficiary = Auth::user()->beneficiary;

    ApplyToProgramJob::dispatch($beneficiary->id, $programId);

    return response()->json([
        'message' => 'تم استلام طلب التقديم'
    ]);
}


    
}
