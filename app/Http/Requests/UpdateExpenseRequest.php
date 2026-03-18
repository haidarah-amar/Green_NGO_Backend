<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateExpenseRequest extends FormRequest
{
    public function authorize(): bool{
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
        $expense = $this->route('expense');

        return [
            'invoice_number' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('expenses', 'invoice_number')->ignore($expense->id),
            ],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string'],
            'category' => ['sometimes', 'required', 'in:salaries_wages,supplies_materials,equipment,administrative_expenses,transportation,hospitality,services'],
            'amount_usd' => ['sometimes', 'required', 'integer', 'min:1'],
            'date' => ['sometimes', 'required', 'date'],
            'payment_method' => ['sometimes', 'required', 'in:bank_transfer,cash,check,bank_card,e-wallet'],
            'program_id' => ['sometimes', 'required', 'exists:programs,id'],
            'grant_id' => ['sometimes', 'required', 'exists:grants,id'],
            'employee_id' => ['sometimes', 'required', 'exists:employees,id'],
        ];
    }
}