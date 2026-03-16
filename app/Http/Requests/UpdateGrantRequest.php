<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'number' => 'sometimes|string|unique:grants,number,' . $this->route('id'),

            'name' => 'sometimes|string|max:255',

            'total_amount_usd' => 'sometimes|integer|min:0',

            'received_amount_usd' => 'sometimes|integer|min:0',

            'spent_amount_usd' => 'sometimes|integer|min:0',

            'start_date' => 'sometimes|date',

            'end_date' => 'sometimes|date|after:start_date',

            'status' => 'sometimes|in:active,expired,draft,approved,suspended,cancelled',

            'projects' => 'nullable|array',

            'projects.*' => 'exists:projects,id'

        ];
    }
}
