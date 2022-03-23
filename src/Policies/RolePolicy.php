<?php

namespace Latus\BasePlugin\Policies;

use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Permissions\Services\UserService;

class RolePolicy
{
    protected function getUserService(): UserService
    {
        return app(UserService::class);
    }

    public function viewAny(User $user): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'role.index');
    }

    public function view(User $user, Role $role): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'role.show') &&
            $user->primaryRole()->level >= $role->level;
    }

    public function create(User $user): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'role.create');
    }

    public function update(User $user, Role $role): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'role.edit') &&
            $user->primaryRole()->level > $role->level;
    }

    public function delete(User $user, Role $role): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'role.destroy') &&
            $user->primaryRole()->level > $role->level;
    }

    public function addChildRole(User $user, Role $childRole, Role|null $role = null): bool
    {
        if (!$role) {
            return !$user->primaryRole()->is($childRole) && $user->primaryRole()->level > $childRole->level;
        }

        return $this->update($user, $role) && $user->primaryRole()->level > $childRole->level && (int)$childRole->level < (int)$role->level;
    }

    public function removeChildRole(User $user, Role $childRole, Role|null $role = null): bool
    {
        return $this->addChildRole($user, $childRole, $role);
    }

    public function updatePermissions(User $user, Role $role): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'role.permission.edit') &&
            $user->primaryRole()->level >= $role->level;
    }

    public function addPermissions(User $user): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'role.permission.add');
    }
}