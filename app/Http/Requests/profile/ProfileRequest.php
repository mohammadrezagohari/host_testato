<?php

namespace App\Http\Requests\profile;

use App\Enums\Sex;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @property int $avatar
 * @property string $name
 * @property string $mobile
 * @property mixed $is_student
 * @property int $field_id
 * @property int $grade_id
 * @property int $school_id
 * @property int $city_id
 * @property int $province_id
 * @property mixed $sex
 * @property int $familiar_id
 * @property string $password
 * @property mixed $roles
 */
class ProfileRequest extends FormRequest
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
        $userId = \Auth::id();
        return [
            'avatar'                => 'nullable|numeric|min:1|max:3',
            'name' => [
                'nullable', 'string'
            ],
            'mobile'                => [
                'nullable', 'string', Rule::unique('users')->ignore($userId)
            ],
            'is_student'            => 'nullable|boolean',
            'field_id'              => 'nullable|exists:fields,id',
            'grade_id'              => 'nullable|exists:grades,id',
            'school_id'             => 'nullable|exists:schools,id',
            'familiar_id'           => 'nullable|exists:familiars,id',
            'city_id'               => 'nullable|exists:cities,id',
            'province_id'           => 'nullable|exists:provinces,id',
            'password'              => 'nullable|string|min:4|max:20',
            'roles'                 => 'nullable|array',
            'roles.*'               => 'nullable|exists:roles,id',
            'sex'                   => [ 'nullable', Rule::in(Sex::ALL) ]
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
