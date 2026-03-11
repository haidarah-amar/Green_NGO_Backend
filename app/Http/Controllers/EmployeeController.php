<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{

    private function isAdmin($user)
    {
        return $user->employee && $user->employee->position === 'system_admin';
    }


    public function index(Request $request)
    {
        if (!$this->isAdmin($request->user())) {
            return response()->json(['message'=>'Forbidden'],403);
        }

        return Employee::with('user')->get();
    }


    public function show(Request $request, $id)
    {
        if (!$this->isAdmin($request->user())) {
            return response()->json(['message'=>'Forbidden'],403);
        }

        $employee = Employee::with('user')->findOrFail($id);

        return response()->json($employee);
    }


    public function store(StoreEmployeeRequest $request)
    {
        if (!$this->isAdmin($request->user())) {
            return response()->json(['message'=>'Forbidden'],403);
        }

        $employee = Employee::create($request->validated());

        return response()->json($employee,201);
    }


    public function update(UpdateEmployeeRequest $request, $id)
    {
        if (!$this->isAdmin($request->user())) {
            return response()->json(['message'=>'Forbidden'],403);
        }

        $employee = Employee::findOrFail($id);

        $employee->update($request->validated());

        return response()->json($employee);
    }


    public function destroy(Request $request, $id)
    {
        if (!$this->isAdmin($request->user())) {
            return response()->json(['message'=>'Forbidden'],403);
        }

        $employee = Employee::findOrFail($id);

        $employee->delete();

        return response()->json([
            'message'=>'Employee deleted'
        ]);
    }
}
