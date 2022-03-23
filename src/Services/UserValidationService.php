<?php

namespace Latus\BasePlugin\Services;

use Illuminate\Support\Facades\Gate;
use Latus\BasePlugin\Policies\RolePolicy;
use Latus\BasePlugin\Policies\UserPolicy;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;

class UserValidationService
{
    public function rolesCanBeSet(User $targetUser, array $roles, User $user = null): bool
    {
        $user = $user ?? auth()->user();

        $persistedRoleIds = $targetUser->roles()->pluck('roles.id')->toArray();

        foreach ($roles as $roleId) {
            if (!($roleModel = Role::find($roleId))) {
                return false;
            }

            if (!in_array($roleId, $persistedRoleIds)) {
                if (!app(UserPolicy::class)->addRole(auth()->user(), $roleModel, $targetUser)) {
                    return false;
                }
            }
        }

        foreach ($persistedRoleIds as $persistedRoleId) {
            if (!($roleModel = Role::find($persistedRoleId))) {
                return false;
            }

            if (!in_array($persistedRoleId, $roles) && !app(UserPolicy::class)->addRole(auth()->user(), $roleModel, $targetUser)) {
                return false;
            }
        }

        return true;
    }
}