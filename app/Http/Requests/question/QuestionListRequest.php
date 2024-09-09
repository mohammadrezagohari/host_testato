<?php

namespace App\Http\Requests\question;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;

/**
 * @property int $exam_id
 */
class QuestionListRequest extends FormRequest
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
            'title' => 'required|string',
            'level' => 'required|exists:levels,id',
            'course' => 'required|exists:courses,id',
            'units' => 'required|exists:units,id',
            'section' => 'required|exists:sections,id',
            'grade' => 'required|exists:grades,id',
            'image.*' => File::image()->min(5)->max(2 * 1024)->rules("nullable"),
            'video.*' => File::types('video/mp4,video/3gpp,video/x-msvideo,video/quicktime,video/x-flv')->min(50)->max(25 * 1024)->rules('nullable'),
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
