<?php

namespace App\Http\Requests\level;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @property string $title
 * @property int $quantity_questions
 * @property int $section_id
 * @property int $answer_quantity
 * @property int $order
 */
class LevelRequest extends FormRequest
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
            'order' => 'nullable|numeric',
            'answer_quantity' => 'nullable|numeric',
            'quantity_questions' => 'nullable|numeric',
            'section_id' => 'required|exists:sections,id',
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
