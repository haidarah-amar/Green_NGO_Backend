<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:donor,internal,progress,final',
            'report_date' => 'required|date',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
            'file_url' => 'nullable|required_without:file|url',
            'file' => 'nullable|required_without:file_url|file|mimes:pdf,xlsx,xls|max:10240',
            'status' => 'nullable|in:active,expired,draft,approved,suspended,cancelled',
            'notes' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'grant_id' => 'required|exists:grants,id',
        ];
    }
}
