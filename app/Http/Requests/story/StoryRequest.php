<?php

namespace App\Http\Requests\story;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;

/**
 * @property string $title
 * @property string $link
 * @property int $priority_order
 * @property mixed $file_url
 * @property mixed $image_preview
 * @property mixed $expire_at
 */
class StoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'             => 'required|string|min:3|max:150',
            'expire_at'         => 'required|string',
            'link'              => 'nullable|string|url',
            'priority_order'    => 'required|numeric|min:0|max:50',
            'file_url'          =>
                File::types("video/mp4")
                    ->min(10)
                    ->max(12 * 1024)->rules('nullable')
            ,
            'image_preview'     => 'nullable|mimes:jpeg,jpg,webp,png:2048', // The `max` value can be adjusted to your requirements
//
//                File::types("image/jpg,image/webp,image/png")->min(10)
//                    ->max(12 * 1024)->rules('required')
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
