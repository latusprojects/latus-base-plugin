<?php

namespace Latus\BasePlugin\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Latus\Permissions\Models\User;
use Latus\Permissions\Services\UserService;

class UserIndexService extends IndexService
{
    public function __construct(
        protected UserService $baseService
    )
    {
    }

    public function paginateAndFilter(): LengthAwarePaginator
    {
        $users = $this->baseService->all();

        if (($sortBy = \request()->query('sort')) && in_array($sortBy, ['id', 'email', 'created_at'])) {
            $sortDescending = (bool)\request()->query('sortDesc', false);

            $users = $users->sortBy(callback: function ($user, $key) use ($sortBy) {
                return match ($sortBy) {
                    'id' => $user->id,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                };
            }, descending: $sortDescending)->values();
        }

        if (($textFilter = \request()->query('search'))) {
            $users = $users->filter(function ($item) use ($textFilter) {
                if (str_starts_with($textFilter, '##')) {
                    return $item->id === (int)str_replace('##', '', $textFilter);
                } else if (str_starts_with($textFilter, '#')) {
                    return str_contains($item->id, str_replace('#', '', $textFilter));
                }

                return str_contains($item->name, $textFilter);
            });
        }

        return $this->paginate(15,
            function ($targetUser) {
                return auth()->user()->can('view', $targetUser);
            },
            function ($targetUser) {

                /** @var User $targetUser */
                $targetUser->can_be_updated = Gate::allows('update', $targetUser);
                $targetUser->can_be_deleted = Gate::allows('delete', $targetUser);
                $targetUser->can_be_viewed = Gate::allows('view', $targetUser);
                $targetUser->roles = $targetUser->roles()->pluck('name')->implode(',');

                return $targetUser;
            },
            $users
        );
    }

    protected function getBaseService(): UserService
    {
        return $this->baseService;
    }
}