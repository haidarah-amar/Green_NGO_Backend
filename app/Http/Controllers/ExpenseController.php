<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Http\Requests\Expense\UpdateExpenseRequest;

class ExpenseController extends Controller
{
    private function authorizePositions(array $positions)
    {
        $user = Auth::user();

        if (
            !$user ||
            $user->role !== 'employee' ||
            !$user->employee ||
            !in_array($user->employee->position, $positions)
        ) {
            abort(403, 'Unauthorized');
        }
    }

    public function index(): JsonResponse
    {
        $this->authorizePositions([
            'system_admin',
            'finance_officer',
            'program_manager'
        ]);

        $expenses = Expenses::with(['program', 'grant', 'employee'])->latest()->paginate(10);

        return response()->json($expenses);
    }

    public function show(Expenses $expense): JsonResponse
    {
        $this->authorizePositions([
            'system_admin',
            'finance_officer',
            'program_manager'
        ]);

        $expense->load(['program', 'grant', 'employee']);

        return response()->json($expense);
    }

    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $expense = Expenses::create($request->validated());

        return response()->json([
            'message' => 'تم انشاء المصروف بنجاح.',
            'data' => $expense
        ], 201);
    }

    public function update(UpdateExpenseRequest $request, Expenses $expense): JsonResponse
    {
        $expense->update($request->validated());

        return response()->json([
            'message' => 'تم تحديث المصروف بنجاح.',
            'data' => $expense
        ], 200);
    }

    public function destroy(Expenses $expense): JsonResponse
    {
        $this->authorizePositions(['finance_officer', 'system_admin']);

        $expense->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function getExpensesByProgram($programId): JsonResponse
    {
        $this->authorizePositions([
            'system_admin',
            'finance_officer',
            'program_manager'
        ]);

        $expenses = Expenses::where('program_id', $programId)->get();

        return response()->json($expenses);
    }

    public function getExpensesByGrant($grantId): JsonResponse
    {
        $this->authorizePositions([
            'system_admin',
            'finance_officer'
        ]);

        $expenses = Expenses::where('grant_id', $grantId)->get();

        return response()->json($expenses);
    }

    public function getExpensesByEmployee($employeeId): JsonResponse
    {
        $this->authorizePositions([
            'system_admin',
            'finance_officer'
        ]);

        $expenses = Expenses::where('employee_id', $employeeId)->get();

        return response()->json($expenses);
    }
}