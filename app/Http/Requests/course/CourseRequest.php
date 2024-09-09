<?php

namespace App\Http\Requests\course;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;

/**
 * @property string $title
 * @property mixed $background
 * @property mixed $icon
 * @property string $description
 * @property int $field_id
 * @property int $grade_id
 */
class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string',
            'icon' =>
                File::image()
                    ->min(2)
                    ->max(2 * 1024)->rules("nullable"),
            'background' => "required|string",
            'description' => "nullable|string",
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
