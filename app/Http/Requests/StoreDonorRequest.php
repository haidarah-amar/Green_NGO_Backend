<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'donor_type' => 'required|in:un_agency,government,private_sector,international_organization,ingo',
            'country' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:50',
            'image_url' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (request()->hasFile($attribute)) {
                        $file = request()->file($attribute);
                        if (!$file->isValid() || !in_array($file->extension(), ['jpeg', 'png', 'jpg', 'gif', 'svg'])) {
                            $fail('The ' . $attribute . ' must be a valid image file.');
                        }
                    } elseif (!filter_var($value, FILTER_VALIDATE_URL)) {
                        $fail('The ' . $attribute . ' must be a valid URL.');
                    }
                }
            ],
            'total_grants_usd' => 'nullable|numeric|min:0'
        ];
    }
}
