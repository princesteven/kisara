<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Modules\Users\Rules\RolesExists;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = request()->route()->parameter('user');

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
            'roles' => ['required', 'array', new RolesExists],
            'addedImages' => 'sometimes|nullable',
            'addedImages.sometimes' => 'array',
            'addedImages.sometimes.*.file' => 'required',
            'removedImages' => 'sometimes|nullable',
            'removedImages.sometimes' => 'array'
        ];
    }

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
     * @param Validator $validator
     * @return void
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        $response = new JsonResponse([
            'success' => false,
            'message' => 'The given data is invalid',
            'errors' => $validator->errors()],
            422);

        throw new ValidationException($validator, $response);
    }
}
