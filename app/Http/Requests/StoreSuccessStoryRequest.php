<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuccessStoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'title' => 'required|string|max:255',

            'story_content' => 'required|text',

            'income_before' => 'required|integer|min:0',

            'income_after' => 'required|integer|min:0',

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

            'video_url' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (request()->hasFile($attribute)) {
                        $file = request()->file($attribute);
                        if (!$file->isValid() || !in_array($file->extension(), ['mp4', 'mov', 'avi'])) {
                            $fail('The ' . $attribute . ' must be a valid video file.');
                        }
                    } elseif (!filter_var($value, FILTER_VALIDATE_URL)) {
                        $fail('The ' . $attribute . ' must be a valid URL.');
                    }
                }
            ],

            'status' => 'nullable|in:active,expired,draft,approved,suspended,cancelled',

            'published_date' => 'nullable|date',

            'consent_given' => 'required|boolean',

            'program_id' => 'required|exists:programs,id'

        ];
    }
}
