<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'title' => 'sometimes|string|max:255',
        'content' => 'nullable|string',
        'type' => 'sometimes|in:donor,internal,progress,final',
        'report_date' => 'sometimes|date',
        'period_start' => 'sometimes|date',
        'period_end' => 'sometimes|date|after_or_equal:period_start',

        'file_url' => 'nullable|required_without:file|url',
        'file' => 'nullable|required_without:file_url|file|mimes:pdf,xlsx,xls|max:10240',

        'status' => 'sometimes|in:active,expired,draft,approved,suspended,cancelled',
        'notes' => 'nullable|string',
        'project_id' => 'sometimes|exists:projects,id',
        'grant_id' => 'sometimes|exists:grants,id',
    ];
    }
}
