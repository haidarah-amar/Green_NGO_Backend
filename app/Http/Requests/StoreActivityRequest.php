<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|regex:/^[\pL\s]+$/u|max:255',
            'description' => 'required|string',

            'type' => 'required|in:workshop,meeting,training,support_session,field_activity',

            'location' => 'required|in:
                دمشق,ريف دمشق,حلب,حمص,حماة,اللاذقية,طرطوس,درعا,السويداء,
                القنيطرة,دير الزور,الرقة,الحسكة,إدلب',

            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',

            'planned_attendees' => 'required|integer|min:1',
            'duration_hours' => 'required|integer|min:1',

            'planned_budget_usd' => 'required|numeric|min:0',

            'responsible_mel_officer_id' => ['required',
            Rule::exists('employees','id')->where(function ($query) {
            $query->where('position','mel_officer');
            })
            ],
            'program_id' => 'required|exists:programs,id'
        ];
    }
}
