<?php

namespace App\Http\Requests\answersheet;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AnswerSheetRequest extends FormRequest
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
            'question_id'=>'required|exists:questions,id',
            'options_question_id'=>'required|in:0,1,2,3,4,5',
            'captions'=>'nullable|string',
            'video_link'=>'required|mimes:mp4,mov,avi,mkv',
            'description'=>'nullable|string',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'   => false,
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }


}
