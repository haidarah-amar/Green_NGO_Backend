<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcceptGrantRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'grant_id'   => 'required|exists:grants,id',
            'new_amount' => 'required|numeric|min:0.01'
        ];
    }
}
