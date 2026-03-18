<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = Auth::user();

        return $user
            && $user->role === 'employee'
            && $user->employee
            && in_array($user->employee->position, [
            'finance_officer',
            'system_admin'
        ]);

    }

    public function rules(): array
    {
        return [
            'invoice_number' => ['required', 'string', 'max:255', 'unique:expenses,invoice_number'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'in:salaries_wages,supplies_materials,equipment,administrative_expenses,transportation,hospitality,services'],
            'amount_usd' => ['required', 'integer', 'min:1'],
            'date' => ['required', 'date'],
            'payment_method' => ['required', 'in:bank_transfer,cash,check,bank_card,e-wallet'],
            'program_id' => ['required', 'exists:programs,id'],
            'grant_id' => ['required', 'exists:grants,id'],
            'employee_id' => ['required', 'exists:employees,id'],
        ];
    }
}