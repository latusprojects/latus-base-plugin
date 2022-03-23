<?php

namespace Latus\BasePlugin\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Latus\BasePlugin\Policies\RolePolicy;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Services\RoleService;

class UserCanAddChildRole implements Rule, DataAwareRule
{

    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected int|null $parentRoleLevel;

    public function __construct(
        protected Role|null $role = null
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value): bool
    {
        /** @var Role $childRole */
        if (!$value || !($childRole = app(RoleService::class)->find($value))) {
            return false;
        }

        if ($this->role) {
            return $this->role->children()->where('roles.id', $value)->count() === 1 || app(RolePolicy::class)->addChildRole(auth()->user(), $childRole, $this->role);
        }

        return app(RolePolicy::class)->addChildRole(auth()->user(), $childRole, $this->role) && (!$this->parentRoleLevel || $this->parentRoleLevel > $this->parentRoleLevel);
    }

    /**
     * @inheritDoc
     */
    public function message(): array|string
    {
        return 'validation.role_not_settable';
    }

    /**
     * Set the data under validation.
     *
     * @param array $data
     * @return $this
     */
    public function setData($data): static
    {
        $this->parentRoleLevel = $data['level'] ?? null;

        return $this;
    }
}