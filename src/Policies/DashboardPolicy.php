<?php

namespace Latus\BasePlugin\Policies;

use Latus\Permissions\Models\User;
use Latus\Permissions\Services\UserService;

class DashboardPolicy
{
    public function __construct(
        protected UserService $userService
    )
    {
    }

    public function view(User $user, string $dashboard): bool
    {

        return $this->userService->userHasOnePermissionByStrings($user, [
            'dashboard.*',
            'dashboard.' . $dashboard
        ]);
    }
}