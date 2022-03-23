<?php

namespace Latus\BasePlugin\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Latus\BasePlugin\Rules\UserCanAddUserRole;
use Latus\Permissions\Models\User;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                Rule::unique('users')
            ],
            'email' => [
                'required',
                Rule::unique('users')
            ],
            'password' => [
                'required', 'confirmed', Password::min(10)->letters()->numbers()->symbols()
            ],
            'password_confirmation' => [
                'required', 'same:password', Password::min(10)->letters()->numbers()->symbols()
            ]
        ];

        if (Gate::allows('addPermissions', User::class)) {
            $rules += [
                'roles' => 'present|array',
                'roles.*' => [
                    'required',
                    'exists:roles,id',
                    new UserCanAddUserRole
                ]
            ];
        }

        return $rules;
    }
}