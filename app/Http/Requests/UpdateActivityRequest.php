<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|regex:/^[\pL\s]+$/u|max:255',
            'description' => 'sometimes|string',

            'type' => 'sometimes|in:workshop,meeting,training,support_session,field_activity',

            'location' => 'sometimes|in:
                دمشق,ريف دمشق,حلب,حمص,حماة,اللاذقية,طرطوس,درعا,السويداء,
                القنيطرة,دير الزور,الرقة,الحسكة,إدلب',

            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',

            'planned_attendees' => 'sometimes|integer|min:1',
            'actual_attendees' => 'sometimes|integer|min:0',

            'duration_hours' => 'sometimes|integer|min:1',

            'planned_budget_usd' => 'sometimes|numeric|min:0',
            'actual_budget_usd' => 'sometimes|numeric|min:0',

            'responsible_mel_officer_id' => ['required',
            Rule::exists('employees','id')->where(function ($query) {
            $query->where('position','mel_officer');
            })
            ],
        ];
    }
}
