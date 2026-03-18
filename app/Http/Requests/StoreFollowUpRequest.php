<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFollowUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if (! $user) {
            return false;
        }

        if ($user->role !== 'employee') {
            return false;
        }

        if (! $user->employee) {
            return false;
        }

        return in_array($user->employee->position, ['mel_officer', 'system_admin']);
    }

    public function rules(): array
    {
        return [
            'beneficiary_id' => ['required', 'exists:beneficiaries,id'],
            'program_id' => ['required', 'exists:programs,id'],
            'mel_officer_id' => [
                'required',
                Rule::exists('employees', 'id')->where(function ($query) {
                    $query->where('position', 'mel_officer');
                }),
            ],
            'follow_up_date' => ['required', 'date'],
            'type' => ['required', Rule::in(['week', 'month', '3 month', '6 month', 'year'])],
            'income_at_follow_up' => ['nullable', 'integer', 'min:0'],
            'sustained_improvement' => ['required', 'boolean'],
            'employment_status' => [
                'nullable',
                Rule::in(['unemployeed', 'entrepreneur', 'seeker', 'part_time', 'full_time', 'retired']),
            ],
            'notes' => ['nullable', 'string'],
        ];
    }
}