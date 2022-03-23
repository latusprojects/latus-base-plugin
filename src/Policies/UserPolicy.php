<?php

namespace Latus\BasePlugin\Policies;

use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Permissions\Services\UserService;

class UserPolicy
{
    protected function getUserService(): UserService
    {
        return app(UserService::class);
    }

    public function viewAny(User $user): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'user.index');
    }

    public function view(User $user, User $targetUser): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'user.show') &&
            ($user->is($targetUser) ||
                ($user->primaryRole()->level >= $targetUser->primaryRole()->level));
    }

    public function create(User $user): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'user.create');
    }

    public function update(User $user, User $targetUser): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'user.edit') &&
            $user->primaryRole()->level > $targetUser->primaryRole()->level;
    }

    public function delete(User $user, User $targetUser): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'user.destroy') &&
            $user->primaryRole()->level > $targetUser->primaryRole()->level;
    }

    public function addRole(User $user, Role $role, User|null $targetUser = null): bool
    {
        if (!$targetUser) {
            return !$user->primaryRole()->is($role) && $user->primaryRole()->level > $role->level;
        }

        return $this->update($user, $targetUser) && $user->primaryRole()->level > $role->level;
    }

    public function removeRole(User $user, Role $role, User|null $targetUser = null): bool
    {
        return $this->addRole($user, $role, $targetUser);
    }

    public function updatePermissions(User $user, User $targetUser): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'user.permission.edit') &&
            $user->primaryRole()->level >= $targetUser->primaryRole()->level;
    }

    public function addPermissions(User $user): bool
    {
        return $this->getUserService()->userHasPermissionByString($user, 'user.permission.add');
    }
}