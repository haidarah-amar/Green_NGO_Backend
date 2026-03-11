<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => 'sometimes|string|max:255',

            'description' => 'sometimes|string',

            'location' => 'sometimes|in:دمشق,ريف دمشق,حلب,حمص,حماة,اللاذقية,طرطوس,درعا,السويداء,القنيطرة,دير الزور,الرقة,الحسكة,إدلب',

            'total_budget_usd' => 'sometimes|numeric|min:0',

            'status' => 'sometimes|in:active,expired,draft,approved,suspended,cancelled',

            'start_date' => 'sometimes|date',

            'end_date' => 'sometimes|date|after_or_equal:start_date',

            'project_manager_id' => 'sometimes|exists:employees,id'
        ];
    }
}
