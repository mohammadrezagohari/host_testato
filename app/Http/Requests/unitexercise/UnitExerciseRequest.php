<?php

namespace App\Http\Requests\unitexercise;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @property int $unit_id
 * @property mixed $image
 */
class UnitExerciseRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'unit_id'=>'required|exists:units,id',
//            'user_id'=>'required|exists:users,id',
            'image' => 'required|image|max:4048',
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
