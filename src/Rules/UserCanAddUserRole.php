<?php

namespace Latus\BasePlugin\Rules;

use Illuminate\Contracts\Validation\Rule;
use Latus\BasePlugin\Policies\UserPolicy;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Permissions\Services\RoleService;

class UserCanAddUserRole implements Rule
{

    public function __construct(
        protected User|null $targetUser = null
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        /** @var Role $childRole */
        if (!$value || !($role = app(RoleService::class)->find($value))) {
            return false;
        }

        if ($this->targetUser) {
            return $this->targetUser->roles()->where('roles.id', $value)->count() === 1 || app(UserPolicy::class)->addRole(auth()->user(), $role, $this->targetUser);
        }

        return app(UserPolicy::class)->addRole(auth()->user(), $role, $this->targetUser);
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'validation.role_not_settable';
    }
}