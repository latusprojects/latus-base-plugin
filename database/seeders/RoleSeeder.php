<?php

namespace Latus\BasePluginDatabase\Seeders;

use Illuminate\Database\Seeder;
use Latus\Permissions\Services\RoleService;

class RoleSeeder extends Seeder
{

    public function __construct(
        protected RoleService $roleService
    )
    {
    }

    public const ROLES = [
        ['name' => 'admin', 'level' => 65535],
        ['name' => 'user', 'level' => 50]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::ROLES as $role) {
            $this->roleService->createRole($role);
        }
    }
}
