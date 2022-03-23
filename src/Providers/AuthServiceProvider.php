<?php

namespace Latus\BasePlugin\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Latus\BasePlugin\Contracts\Dashboard;
use Latus\BasePlugin\Models\Page;
use Latus\BasePlugin\Policies\DashboardPolicy;
use Latus\BasePlugin\Policies\PagePolicy;
use Latus\BasePlugin\Policies\UserPolicy;
use Latus\Permissions\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Dashboard::class => DashboardPolicy::class,
        Page::class => PagePolicy::class,
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-admin-module', function (User $user) {
            return $user->hasPermission('module.admin');
        });
    }
}