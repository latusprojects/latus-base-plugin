<?php

namespace Latus\BasePlugin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Latus\Permissions\Services\UserService;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => UserService::$create_validation_rules['name'],
            'email' => UserService::$create_validation_rules['email'],
            'password' => UserService::$create_validation_rules['password'] . '|confirmed'
        ];
    }
}