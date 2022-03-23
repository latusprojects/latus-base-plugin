<?php

namespace Latus\BasePlugin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Latus\BasePlugin\Http\Requests\User\StoreUserRequest;
use Latus\BasePlugin\Http\Requests\User\UpdateUserRequest;
use Latus\BasePlugin\Policies\UserPolicy;
use Latus\BasePlugin\Services\UserIndexService;
use Latus\BasePlugin\Services\UserValidationService;
use Latus\BasePlugin\UI\Widgets\AdminNav;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Permissions\Services\RoleService;
use Latus\Permissions\Services\UserService;
use Latus\UI\Services\ComponentService;

class UserController extends AdminController
{
    public function __construct(ComponentService $componentService, AdminNav $adminNav)
    {
        parent::__construct($componentService, $adminNav);

        $this->authorizeResource(User::class, 'targetUser');
    }

    public function index(UserIndexService $userService): View|JsonResponse
    {
        $paginator = $userService->paginateAndFilter();

        if (\request()->wantsJson()) {
            return response()->json([
                'items' => $paginator->items(),
                'total' => $paginator->total(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ]);
        }

        return $this->returnView(view('latus::admin.user.index')->with(['paginator' => $paginator]), 'user.index');
    }

    public function addableRoles(RoleService $roleService, User|null $targetUser = null): JsonResponse
    {
        $this->authorize('viewAny', Role::class);

        $allRoles = $roleService->all();

        $roles = $allRoles->filter(function (Role $role) use ($targetUser) {
            return (!$targetUser || !$targetUser->is($role)) && app(UserPolicy::class)->addRole(auth()->user(), $role, $targetUser);
        });

        return response()->json([
            'roles' => $roles->map(function (Role $role) {
                return collect($role)->only(['id', 'level', 'name']);
            }),
            'addedRoles' => $targetUser?->roles()->get(['roles.id', 'roles.name', 'roles.level'])
        ]);
    }

    public function create(): View
    {
        return $this->returnView(view('latus::admin.user.create'), 'user.create');
    }

    public function store(StoreUserRequest $request, UserService $userService)
    {
        $validatedInput = $request->validated();

        try {
            /** @var User $user */
            $user = $userService->createUser([
                'name' => $validatedInput['name'],
                'email' => $validatedInput['email'],
                'password' => $validatedInput['password']
            ]);

            if (!empty($validatedInput['roles'])) {
                foreach ($validatedInput['roles'] as $role) {
                    $user->roles()->attach($role);
                }
            }

        } catch (\InvalidArgumentException $exception) {
            return response()->latusFailed(status: 422, message: 'user-service attribute validation failed');
        }

        return response()->latusSuccess(message: 'user created', data: [
            'created_at' => $user->getCreatedAtColumn(),
            'id' => $user->id,
        ]);
    }

    public function show(User $targetUser)
    {

    }

    public function edit(User $targetUser): View
    {
        return $this->returnView(view('latus::admin.user.edit', ['user' => $targetUser]), 'user.edit');
    }

    public function update(UpdateUserRequest $request, User $targetUser, UserService $userService, UserValidationService $userValidationService)
    {
        $validatedInput = $request->validated();

        $userCanUpdatePermissions = Gate::allows('updatePermissions', $targetUser);

        if ($userCanUpdatePermissions && !$userValidationService->rolesCanBeSet($targetUser, $validatedInput['roles'])) {
            return response()->latusFailed(status: 422, message: 'could not set roles: insufficient permissions');
        }

        try {
            if (!$validatedInput['password']) {
                unset($validatedInput['password']);
            }

            $userService->updateUser($targetUser, [
                'name' => $validatedInput['name'],
                'email' => $validatedInput['email'],
            ]);

            if ($userCanUpdatePermissions) {

                foreach ($targetUser->roles()->get() as $role) {
                    if (!in_array($role->id, $validatedInput['roles'])) {
                        $targetUser->roles()->detach($role->id);
                    }
                }

                if (!empty($validatedInput['roles'])) {
                    foreach ($validatedInput['roles'] as $role) {
                        if (!$targetUser->roles()->find($role)) {
                            $targetUser->roles()->attach($role);
                        }
                    }
                }
            }

        } catch (\InvalidArgumentException $exception) {
            return response()->latusFailed(status: 422, message: 'user-service attribute validation failed');
        }

        return response()->latusSuccess(message: 'user updated', data: [
            'updated_at' => $targetUser->getUpdatedAtColumn(),
            'id' => $targetUser->id,
        ]);
    }

    public function destroy(User $targetUser)
    {
        //
    }
}