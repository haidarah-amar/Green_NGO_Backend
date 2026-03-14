<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Employee;

class StoreProgramRequest extends FormRequest
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

            'type' => 'required|in:economic_empowerment,vocational_training,psychosocial_support,agricultural_development,community_leadership,entrepreneurship',

            'target_age_min' => 'required|integer|min:0|max:100',

            'target_age_max' => 'required|integer|gte:target_age_min|max:100',

            'target_gender' => 'required|in:male,female,all',

            'location' => 'required|in:دمشق,ريف دمشق,حلب,حمص,حماة,اللاذقية,طرطوس,درعا,السويداء,القنيطرة,دير الزور,الرقة,الحسكة,إدلب',

            'total_budget_usd' => 'required|numeric|min:0',

            'spent_budget_usd' => 'nullable|numeric|min:0',

            'status' => 'in:active,expired,draft,approved,suspended,cancelled',

            'start_date' => 'required|date',

            'end_date' => 'required|date|after_or_equal:start_date',

            'project_id' => 'required|exists:projects,id',

            'program_manager_id' => [
                'required',
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
