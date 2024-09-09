<?php

namespace App\Http\Requests\unit;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

/**
 * @property string $title
 * @property int $course_id
 * @property int $grade_id
 * @property mixed $image
 * @property mixed $field_ids
 */
class UnitRequest extends FormRequest
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
            'title'         => 'required|string|min:2|max:100',
            'course_id'     => 'required|exists:courses,id',
            'grade_id'      => 'required|exists:grades,id',
            'field_ids'     => 'required|array',
            'field_ids.*'   => 'required|exists:fields,id',
            'image'         => Rule::file()->image()
                                ->min(5)
                                ->max(2 * 1024)
                                ->rules("nullable")
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
