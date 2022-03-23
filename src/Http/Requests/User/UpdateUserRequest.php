<?php

namespace Latus\BasePlugin\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Latus\BasePlugin\Rules\UserCanAddUserRole;
use Latus\Permissions\Models\User;

class UpdateUserRequest extends FormRequest
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
                Rule::unique('users')->ignore($this->targetUser->id)
            ],
            'email' => [
                'required',
                Rule::unique('users')->ignore($this->targetUser->id)
            ],
            'password' => [
                'nullable', 'confirmed', Password::min(10)->letters()->numbers()->symbols()
            ],
            'password_confirmation' => [
                'nullable', 'same:password', Password::min(10)->letters()->numbers()->symbols()
            ]
        ];

        if (Gate::allows('updatePermissions', $this->targetUser)) {
            $rules += [
                'roles' => 'present|array',
                'roles.*' => [
                    'required',
                    'exists:roles,id',
                    new UserCanAddUserRole($this->targetUser)
                ]
            ];
        }

        return $rules;
    }
}