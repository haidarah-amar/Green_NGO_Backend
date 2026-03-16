<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'number' => 'required|string|unique:grants,number',

            'name' => 'required|string|max:255',

            'total_amount_usd' => 'required|integer|min:0',

            'received_amount_usd' => 'required|integer|min:0',

            'spent_amount_usd' => 'required|integer|min:0',

            'start_date' => 'required|date',

            'end_date' => 'required|date|after:start_date',

            'status' => 'nullable|in:active,expired,draft,approved,suspended,cancelled',

            'projects' => 'nullable|array',

            'projects.*' => 'exists:projects,id'

        ];
    }
}
