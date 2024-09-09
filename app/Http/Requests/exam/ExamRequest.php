<?php

namespace App\Http\Requests\exam;

use App\Enums\ExamType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * @property mixed $question_quantity
 * @property mixed $level_id
 * @property mixed $course_id
 * @property mixed $score
 * @property mixed $answer_quantity
 * @property mixed $status
 */
class ExamRequest extends FormRequest
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
            'level_id' => 'required|exists:levels,id',
            'course_id' => 'required|exists:courses,id',
            'question_quantity' => 'required|numeric',
            'answer_quantity' => 'required|numeric',
            'time_exam' => 'required|numeric',
            'status' => Rule::in(ExamType::ALL),
            'score' => 'nullable|numeric',

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
