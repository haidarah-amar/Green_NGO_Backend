<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeneficiaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'national_id' => 'required|string|unique:beneficiaries,national_id',
            'age' => 'required|integer|min:0',
            'region' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'family_size' => 'nullable|integer|min:1',
            'education_level' => 'nullable|in:none,primary,secondary,university,higher',
            'income_before' => 'nullable|numeric',
            'income_after' => 'nullable|numeric',
            'employment_status' => 'nullable|in:employed,unemployed',
        ];
    }
}