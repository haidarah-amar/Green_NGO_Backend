<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'title' => 'required|string|max:255',
        'date' => 'required|date',
        'type' => 'required|in:in,out',

        'general_rating' => 'required|in:1,2,3,4,5',
        'traing_rating' => 'required|in:1,2,3,4,5',
        'content_rating' => 'required|in:1,2,3,4,5',

        'top_benefits' => 'nullable|string',
        'improvement_suggestions' => 'nullable|string',

        'beneficiary_id' => 'required|exists:beneficiaries,id',

        'activity_id' => 'nullable|exists:activities,id',
        'program_id' => 'nullable|exists:programs,id',
    ];
}

public function withValidator($validator)
{
    $validator->after(function ($validator) {
        if ($this->activity_id && $this->program_id) {
            $validator->errors()->add('activity_id', 'لا يمكن ربط الاستبيان مع برنامج ونشاط بنفس الوقت');
        }

        if (!$this->activity_id && !$this->program_id) {
            $validator->errors()->add('activity_id', 'يجب اختيار برنامج أو نشاط');
        }
    });
}

}
