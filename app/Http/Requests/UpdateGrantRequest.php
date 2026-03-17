<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGrantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $grant = $this->route('grant');

        return [
            'number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('grants', 'number')->ignore($grant->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'total_amount_usd' => ['required', 'integer', 'min:0'],
            'received_amount_usd' => ['required', 'integer', 'min:0'],
            'spent_amount_usd' => ['required', 'integer', 'min:0'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:active,expired,draft,approved,suspended,cancelled'],
        ];
    }
}