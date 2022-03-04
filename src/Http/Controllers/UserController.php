<?php

namespace Latus\BasePlugin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Latus\BasePlugin\Paginators\FilterablePaginator;
use Latus\BasePlugin\Services\UserService;
use Latus\BasePlugin\UI\Widgets\AdminNav;
use Latus\Permissions\Models\User;
use Latus\UI\Services\ComponentService;

class UserController extends AdminController
{
    public function __construct(ComponentService $componentService, AdminNav $adminNav)
    {
        parent::__construct($componentService, $adminNav);

        $this->authorizeResource(User::class, 'targetUser');
    }

    protected function getFilteredPaginator(UserService $userService): FilterablePaginator
    {
        $paginator = $userService->paginate(15,
            function ($user) {
                return auth()->user()->can('view', $user);
            },
            function ($targetUser) {

                /** @var User $targetUser */
                $targetUser->can_be_updated = Gate::allows('update', $targetUser);
                $targetUser->can_be_deleted = Gate::allows('delete', $targetUser);
                $targetUser->can_be_viewed = Gate::allows('view', $targetUser);
                $targetUser->roles = $targetUser->roles()->pluck('name')->implode(',');

                return $targetUser;
            }
        );

        if (($sortBy = \request()->query('sort')) && in_array($sortBy, ['id', 'email', 'created_at'])) {
            $sortDescending = (bool)\request()->query('sortDesc', false);

            $paginator->setCollection($paginator->sortBy(callback: function ($user, $key) use ($sortBy) {
                return match ($sortBy) {
                    'id' => $user->id,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                };
            }, descending: $sortDescending)->values());
        }

        if (!($textFilter = \request()->query('search'))) {
            return $paginator;
        }

        return $paginator->filterItems(function ($item) use ($textFilter) {
            if (str_starts_with($textFilter, '#')) {
                return str_contains($item->id, str_replace('#', '', $textFilter));
            }

            return str_contains($item->email, $textFilter);
        });
    }

    public function index(UserService $userService): View|JsonResponse
    {
        $paginator = $this->getFilteredPaginator($userService);

        if (\request()->wantsJson()) {
            return response()->json([
                'items' => $paginator->items(),
                'total' => $paginator->total(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ]);
        }

        return $this->returnView(view('latus::admin.user.index')->with(['paginator' => $paginator]), 'page.index');
    }

    public function create()
    {
        return $this->returnView(view('latus::admin.user.create'), 'user.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}