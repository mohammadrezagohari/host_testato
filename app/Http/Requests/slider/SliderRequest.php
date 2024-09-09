<?php

namespace App\Http\Requests\slider;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;

/**
 * @property string $title
 * @property mixed $priority_order
 * @property mixed $file_url
 * @property mixed $mime_type
 * @property mixed $file_size
 */
class SliderRequest extends FormRequest
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
            'title'=>'required|string',
            'priority_order'=>'required|numeric',
            'file_url' => [
                'nullable',
                File::image()
                    ->min(5)
                    ->max(8 * 1024)
            ],
            'mime_type'=>"required|in:image/jpg,image/jpeg,image/png,image/bmp,image/tiff,image/webp",
            'file_size'=>'required|max:4048',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'   => false,
            'success' => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }


}
