<?php

namespace App\Http\Requests\profile;

use App\Enums\Sex;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
//        $userId = \Auth::id();
        return [
            'avatar'                => 'nullable|numeric|min:1|max:3',
            'name' => [
                'nullable', 'string'
            ],
            'mobile'                => [
                'nullable', 'string'
            ],
            'is_student'            => 'nullable|boolean',
            'field_id'              => 'nullable|exists:fields,id',
            'grade_id'              => 'nullable|exists:grades,id',
            'school_id'             => 'nullable|exists:schools,id',
            'familiar_id'           => 'nullable|exists:familiars,id',
            'city_id'               => 'nullable|exists:cities,id',
            'province_id'           => 'nullable|exists:provinces,id',
            'roles.*'                 => 'nullable|exists:roles,name',
            'sex'                   => [
                'nullable',
                Rule::in(Sex::ALL)
            ],
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
