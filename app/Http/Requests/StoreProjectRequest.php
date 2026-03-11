<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => 'required|string|max:255',

            'description' => 'required|string',

            'location' => 'required|in:دمشق,ريف دمشق,حلب,حمص,حماة,اللاذقية,طرطوس,درعا,السويداء,القنيطرة,دير الزور,الرقة,الحسكة,إدلب',

            'total_budget_usd' => 'required|numeric|min:0',

            'status' => 'in:active,expired,draft,approved,suspended,cancelled',

            'start_date' => 'required|date',

            'end_date' => 'required|date|after_or_equal:start_date',

            'project_manager_id' => 'required|exists:employees,id'
        ];
    }
}
