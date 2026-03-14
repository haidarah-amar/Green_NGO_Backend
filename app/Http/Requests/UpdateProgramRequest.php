<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Employee;

class UpdateProgramRequest extends FormRequest
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

            'type' => 'sometimes|in:economic_empowerment,vocational_training,psychosocial_support,agricultural_development,community_leadership,entrepreneurship',

            'target_age_min' => 'sometimes|integer|min:0|max:100',

            'target_age_max' => 'sometimes|integer|gte:target_age_min|max:100',

            'target_gender' => 'sometimes|in:male,female,all',

            'location' => 'sometimes|in:دمشق,ريف دمشق,حلب,حمص,حماة,اللاذقية,طرطوس,درعا,السويداء,القنيطرة,دير الزور,الرقة,الحسكة,إدلب',

            'total_budget_usd' => 'sometimes|numeric|min:0',

            'spent_budget_usd' => 'sometimes|numeric|min:0',

            'status' => 'sometimes|in:active,expired,draft,approved,suspended,cancelled',

            'start_date' => 'sometimes|date',

            'end_date' => 'sometimes|date|after_or_equal:start_date',

            'project_id' => 'sometimes|exists:projects,id',

            'program_manager_id' => [
                'sometimes',
                'exists:employees,id',
                function ($attribute, $value, $fail) {

                    $employee = Employee::find($value);

                    if (!$employee || $employee->position !== 'program_manager') {
                        $fail('الموظف المحدد ليس مدير برنامج.');
                    }

                }
            ]

        ];
    }

}
