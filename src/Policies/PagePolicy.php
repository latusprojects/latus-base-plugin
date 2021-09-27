<?php

namespace Latus\BasePlugin\Policies;

use Latus\BasePlugin\Models\Page;
use Latus\Permissions\Models\User;
use Latus\Permissions\Services\UserService;

class PagePolicy
{

    public function __construct(
        protected UserService $userService,
    )
    {
    }

    public function viewAny(User $user): bool
    {
        return $this->userService->userHasPermissionByString($user, 'content.page.index');
    }

    public function view(User $user, Page $page): bool
    {
        return ($page->owner_model_class === get_class($user) && $page->owner_model_id === $user->id)
            || ($this->userService->userHasPermissionByString($user, 'content.page.view') && $this->userService->userHasPermissionByString($user, 'content.page.index'));
    }

    public function create(User $user): bool
    {
        return $this->userService->userHasPermissionByString($user, 'content.page.create');
    }

    public function update(User $user, Page $page): bool
    {
        return ($page->owner_model_class === get_class($user) && $page->owner_model_id === $user->id)
            || ($this->userService->userHasPermissionByString($user, 'content.page.edit') && $this->userService->userHasPermissionByString($user, 'content.page.index'));
    }
}