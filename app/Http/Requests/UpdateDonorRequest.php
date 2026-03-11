<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'donor_type' => 'sometimes|in:un_agency,government,private_sector,international_organization,ingo',
            'country' => 'sometimes|string|max:255',
            'contact_person' => 'sometimes|string|max:255',
            'contact_email' => 'sometimes|email|max:255',
            'contact_phone' => 'sometimes|string|max:50',
            'image_url' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048|url',
            'total_grants_usd' => 'sometimes|numeric|min:0'
        ];
    }
}
