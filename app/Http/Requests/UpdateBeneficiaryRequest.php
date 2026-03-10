<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBeneficiaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('beneficiary');

        return [
            'gender' => 'sometimes|in:male,female',
            'date_of_birth' => 'sometimes|date',
            'national_id' => "sometimes|string|unique:beneficiaries,national_id,$id",
            'age' => 'sometimes|integer|min:0',
            'region' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'marital_status' => 'sometimes|in:single,married,divorced,widowed',
            'family_size' => 'sometimes|integer|min:1',
            'education_level' => 'sometimes|in:none,primary,secondary,university,higher',
            'income_before' => 'sometimes|numeric',
            'income_after' => 'sometimes|numeric',
            'employment_status' => 'sometimes|in:employed,unemployed',
        ];
    }
}