<?php

namespace Latus\BasePlugin\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Latus\BasePlugin\Rules\UserCanAddChildRole;
use Latus\Permissions\Models\Role;

class StoreRoleRequest extends FormRequest
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
                Rule::unique('roles')
            ],
            'level' => 'required|integer|min:50|max:' . (auth()->user()->primaryRole()->level - 1)
        ];

        if (Gate::allows('addPermissions', Role::class)) {
            $rules += [
                'roles' => 'present|array',
                'roles.*' => [
                    'required',
                    'exists:roles,id',
                    new UserCanAddChildRole
                ]
            ];
        }

        return $rules;
    }
}