<?php

namespace Latus\BasePlugin\Policies;


use Latus\BasePlugin\Services\UserService;
use Latus\Permissions\Models\User;

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
            $user->primaryRole()->level >= $targetUser->primaryRole()->level;
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
}