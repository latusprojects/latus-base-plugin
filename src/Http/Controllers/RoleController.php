<?php

namespace Latus\BasePlugin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Latus\BasePlugin\Exceptions\ModelHasHardRelationshipsException;
use Latus\BasePlugin\Http\Requests\Role\StoreRoleRequest;
use Latus\BasePlugin\Http\Requests\Role\UpdateRoleRequest;
use Latus\BasePlugin\Policies\RolePolicy;
use Latus\BasePlugin\Services\RoleIndexService;
use Latus\BasePlugin\Services\RoleValidationService;
use Latus\BasePlugin\Services\SharedLockService;
use Latus\BasePlugin\UI\Widgets\AdminNav;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Services\RoleService;
use Latus\UI\Services\ComponentService;

class RoleController extends AdminController
{
    protected string $modelName = 'role';
    protected string $routeParameterName = 'role';
    protected string $modelClass = Role::class;
    protected string $modelForRelationsName = 'role';

    public function __construct(ComponentService $componentService, AdminNav $adminNav)
    {
        parent::__construct($componentService, $adminNav);

        $this->authorizeResource(Role::class, 'role');
    }

    public function index(RoleIndexService $roleService): View|JsonResponse
    {
        $paginator = $roleService->paginateAndFilter();

        if (\request()->wantsJson()) {
            return response()->json([
                'items' => $paginator->items(),
                'total' => $paginator->total(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ]);
        }

        return $this->returnView(view('latus::admin.role.index')->with(['paginator' => $paginator]), 'role.index');
    }

    public function addableChildren(RoleService $roleService, Role|null $role = null): JsonResponse
    {
        $this->authorize('viewAny', Role::class);

        $allRoles = $roleService->all();

        $roles = $allRoles->filter(function (Role $childRole) use ($role) {
            return (!$role || !$role->is($childRole)) && app(RolePolicy::class)->addChildRole(auth()->user(), $childRole, $role);
        });

        return response()->json([
            'roles' => $roles->map(function (Role $role) {
                return collect($role)->only(['id', 'level', 'name']);
            }),
            'addedRoles' => $role?->children()->get(['roles.id', 'roles.name', 'roles.level'])
        ]);
    }

    public function create()
    {
        return $this->returnView(view('latus::admin.role.create'), 'role.create');
    }

    public function store(StoreRoleRequest $request, RoleService $roleService)
    {
        $validatedInput = $request->validated();

        try {
            /** @var Role $role */
            $role = $roleService->createRole($validatedInput);

            if (!empty($validatedInput['roles'])) {
                foreach ($validatedInput['roles'] as $childRole) {
                    $role->children()->attach($childRole);
                }
            }

        } catch (\InvalidArgumentException $exception) {
            return response()->latusFailed(status: 422, message: 'role-service attribute validation failed');
        }

        return response()->latusSuccess(message: 'role created', data: [
            'created_at' => $role->getCreatedAtColumn(),
            'id' => $role->id,
        ]);
    }

    public function show(Role $role)
    {
        //
    }

    public function edit(Role $role, SharedLockService $lockService)
    {
        if ($lockService->hasLock($role) && ($blockingUserId = $lockService->getBlockingUser($role)) !== auth()->user()->id) {
            return $this->returnView(view('latus::admin.role.edit')->with(['role' => $role, 'is_locked' => true, 'blocking_user' => $blockingUserId]), 'role.edit');
        }
        
        $lockService->lock($role);

        return $this->returnView(view('latus::admin.role.edit')->with(['role' => $role, 'is_locked' => false]), 'role.edit');
    }

    public function update(UpdateRoleRequest $request, Role $role, RoleService $roleService, RoleValidationService $roleValidationService, SharedLockService $lockService)
    {
        if ($lockService->hasLock($role) && ($blockingUserId = $lockService->getBlockingUser($role)) !== auth()->user()->id) {
            return response()->latusFailed(status: 423, message: 'could not update role: model is block by user', data: ['blocking_user_id' => $blockingUserId]);
        }

        $validatedInput = $request->validated();

        $userCanUpdatePermissions = Gate::allows('updatePermissions', $role);

        if ($userCanUpdatePermissions && !$roleValidationService->childRolesCanBeSet($role, $validatedInput['roles'])) {
            return response()->latusFailed(status: 422, message: 'could not set child-roles: insufficient permissions');
        }

        try {
            $roleService->updateRole($role, $validatedInput);

            if ($userCanUpdatePermissions) {

                foreach ($role->children()->get() as $childRole) {
                    if (!in_array($childRole->id, $validatedInput['roles'])) {
                        $role->children()->detach($childRole->id);
                    }
                }

                if (!empty($validatedInput['roles'])) {
                    foreach ($validatedInput['roles'] as $childRole) {
                        if (!$role->children()->find($childRole)) {
                            $role->children()->attach($childRole);
                        }
                    }
                }
            }

        } catch (\InvalidArgumentException $exception) {
            return response()->latusFailed(status: 422, message: 'role-service attribute validation failed');
        }

        return response()->latusSuccess(message: 'role updated', data: [
            'updated_at' => $role->getUpdatedAtColumn(),
            'id' => $role->id,
        ]);
    }

    public function destroy(Role $role, RoleService $roleService)
    {
        try {
            $roleService->deleteRole($role);
        } catch (ModelHasHardRelationshipsException $e) {
            $relations = [];
            $searchQuery = [
                'w' => [
                    $this->modelForRelationsName => [
                        'where' => [
                            'id' => [
                                'value' => $role->id
                            ]
                        ]
                    ]
                ]
            ];

            foreach ($e->relationships->keys()->toArray() as $relationName) {
                $relations[] = [
                    'label' => __('lh::models.' . $relationName),
                    'search_url' => route($relationName . '.index') . '/?search=' . json_encode($searchQuery),
                ];
            }

            return response()->latusFailed(status: 423, data: ['gated_by' =>
                [
                    'type' => 'relations',
                    'relations' => $relations
                ]
            ]);
        }

        return response()->latusSuccess(message: $this->modelName . ' deleted');
    }
}