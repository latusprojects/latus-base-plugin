<?php

namespace Latus\BasePlugin\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Services\RoleService;

class RoleIndexService extends IndexService
{
    public function __construct(
        protected RoleService $baseService
    )
    {
    }

    public function paginateAndFilter(): LengthAwarePaginator
    {
        $roles = $this->baseService->all();

        if (($sortBy = \request()->query('sort')) && in_array($sortBy, ['id', 'name', 'created_at'])) {
            $sortDescending = (bool)\request()->query('sortDesc', false);

            $roles = $roles->sortBy(callback: function ($role, $key) use ($sortBy) {
                return match ($sortBy) {
                    'id' => $role->id,
                    'name' => $role->name,
                    'created_at' => $role->created_at,
                };
            }, descending: $sortDescending)->values();
        }

        if (($textFilter = \request()->query('search'))) {
            $roles = $roles->filter(function ($item) use ($textFilter) {
                if (str_starts_with($textFilter, '##')) {
                    return $item->id === (int)str_replace('##', '', $textFilter);
                } else if (str_starts_with($textFilter, '#')) {
                    return str_contains($item->id, str_replace('#', '', $textFilter));
                }

                return str_contains($item->name, $textFilter);
            });
        }

        return $this->paginate(15,
            function ($role) {
                return auth()->user()->can('view', $role);
            },
            function ($role) {

                /** @var Role $role */
                $role->can_be_updated = Gate::allows('update', $role);
                $role->can_be_deleted = Gate::allows('delete', $role);
                $role->can_be_viewed = Gate::allows('view', $role);
                $role->child_roles = $role->children()->pluck('name')->implode(',');

                return $role;
            },
            $roles
        );
    }

    protected function getBaseService(): RoleService
    {
        return $this->baseService;
    }
}