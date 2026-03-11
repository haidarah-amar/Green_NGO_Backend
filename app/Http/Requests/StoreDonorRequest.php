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

        'image_url' => 'nullable|string',

        'total_grants_usd' => 'nullable|numeric|min:0'
    ];
}

}
