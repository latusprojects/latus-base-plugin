<?php

namespace Latus\BasePlugin\Services;

use Illuminate\Support\Facades\Gate;
use Latus\BasePlugin\Policies\RolePolicy;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;

class RoleValidationService
{
    public function childRolesCanBeSet(Role $role, array $childRoles, User $user = null): bool
    {
        $user = $user ?? auth()->user();

        $persistedChildRoleIds = $role->children()->pluck('roles.id')->toArray();

        foreach ($childRoles as $childRole) {
            if (!($childRoleModel = Role::find($childRole))) {
                return false;
            }

            if (!in_array($childRole, $persistedChildRoleIds)) {
                if (!app(RolePolicy::class)->addChildRole(auth()->user(), $childRoleModel, $role)) {
                    return false;
                }
            }
        }

        foreach ($persistedChildRoleIds as $persistedChildRoleId) {
            if (!($childRoleModel = Role::find($persistedChildRoleId))) {
                return false;
            }
            
            if (!in_array($persistedChildRoleId, $childRoles) && !app(RolePolicy::class)->addChildRole(auth()->user(), $childRoleModel, $role)) {
                return false;
            }
        }

        return true;
    }
}