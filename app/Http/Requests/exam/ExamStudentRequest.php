<?php

namespace App\Http\Requests\exam;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @property mixed $question_quantity
 * @property mixed $silver_coin
 * @property mixed $gold_coin
 * @property mixed $level_id
 * @property mixed $course_id
 */
class ExamStudentRequest extends FormRequest
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
            'level_id'          => 'required|exists:levels,id',
            'course_id'         => 'required|exists:courses,id',
            'question_quantity' => 'required|numeric',
            'silver_coin'       => 'required|numeric',
            'gold_coin'         => 'required|numeric',
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
