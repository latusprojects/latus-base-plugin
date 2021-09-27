<?php

namespace Latus\BasePlugin\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Latus\BasePluginDatabase\Seeders\DatabaseSeeder;
use Latus\Installer\Providers\Traits\RegistersSeeders;
use Latus\Laravel\Http\Middleware\BuildPackageDependencies;
use Latus\BasePlugin\Http\Controllers\AdminController;
use Latus\BasePlugin\Http\Controllers\AuthController;
use Latus\BasePlugin\Http\Controllers\WebController;
use Latus\BasePlugin\Modules\Contracts\AdminModule;
use Latus\BasePlugin\Modules\Contracts\AuthModule;
use Latus\BasePlugin\Modules\Contracts\WebModule;
use Latus\UI\Events\AdminNavDefined;
use Latus\UI\Providers\Traits\DefinesModules;
use Latus\UI\Widgets\AdminNav;

class LatusServiceProvider extends ServiceProvider
{
    use RegistersSeeders, DefinesModules;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSeeders([
            DatabaseSeeder::class
        ]);

        $this->defineModules([
            AdminModule::class => [
                'alias' => 'admin',
                'controller' => [AdminController::class, 'showPage'],
            ],
            AuthModule::class => [
                'alias' => 'auth',
                'controller' => AuthController::class,
            ],
            WebModule::class => [
                'alias' => 'web',
                'controller' => WebController::class,
            ],
        ]);

        BuildPackageDependencies::addDependencyClosure(function () {

            app()->singleton(AdminNav::class, AdminNav::class);

            AdminNavDefined::dispatch(app(AdminNav::class));
        });

        $this->mergeConfigFrom(__DIR__ . '/../../config/routes.php', 'latus-routes');
    }

    protected function buildAdminNav()
    {

        Event::listen(function (AdminNavDefined $event) {

            $navBuilder = $event->adminNav->builder();

            /* Group: Dashboards */
            $navBuilder->group('dashboard', 'nav.dashboard')
                /* dashboard/overview */
                ->item('dashboard.overview')
                ->setUrl(route('dashboard/overview'))
                ->setIcon('app')
                ->requireAuthorization('dashboard.overview')
                /* dashboard/statistics */
                ->parent()->item('dashboard.statistics')
                ->setUrl(route('dashboard/statistics'))
                ->setIcon('bar-chart-line')
                ->requireAuthorization('dashboard.statistics');


            /* Group: Content */
            /* pages */
            $navBuilder->group('content', 'nav.content')
                ->append('dashboard')
                ->item('content.pages')
                ->setIcon('files')
                ->requireAuthorization('content.page.index')
                /* page/index */
                ->subItem('content.page.index')
                ->setUrl(route('pages.index'))
                ->setIcon('card-list')
                ->requireAuthorization('content.page.index')
                /* page/create */
                ->parent()->subItem('content.page.create')
                ->setUrl(route('pages.create'))
                ->setIcon('plus-circle')
                ->requireAuthorization('content.page.create');

            /* posts */
            $navBuilder->group('content')
                ->item('content.posts')
                ->setIcon('newspaper')
                ->requireAuthorization('content.post.index')
                /* post/index */
                ->subItem('content.post.index')
                ->setUrl('')
                ->setIcon('card-list')
                ->requireAuthorization('content.post.index')
                /* post/create */
                ->parent()->subItem('content.post.create')
                ->setUrl('')
                ->setIcon('plus-circle')
                ->requireAuthorization('content.post.create');

            /* events */
            $navBuilder->group('content')
                ->item('content.events')
                ->setIcon('calendar-event')
                ->requireAuthorization('content.event.index')
                /* event/index */
                ->subItem('content.event.index')
                ->setUrl('')
                ->setIcon('card-list')
                ->requireAuthorization('content.event.index')
                /* event/create */
                ->parent()->subItem('content.event.create')
                ->setUrl('')
                ->setIcon('plus-circle')
                ->requireAuthorization('content.event.create');

            /* settings */
            $navBuilder->group('content')
                ->item('content.settings')
                ->setUrl('')
                ->setIcon('sliders')
                ->requireAuthorization('content.setting.index');

            /* Group: Administration */
            /* rolesAndUsers */
            $navBuilder->group('administration', 'nav.administration')
                ->append('content')
                ->item('admin.rolesAndUsers')
                ->setIcon('people')
                ->requireAuthorization(['user.index', 'role.index'])
                /* role/index */
                ->subItem('role.index')
                ->setUrl('')
                ->setIcon('card-list')
                ->requireAuthorization('role.index')
                /* role/create */
                ->parent()->subItem('role.create')
                ->setUrl('')
                ->setIcon('plus-circle')
                ->requireAuthorization('role.create')
                /* user/index */
                ->parent()->subItem('user.index')
                ->setUrl('')
                ->setIcon('card-list')
                ->requireAuthorization('user.index')
                /* user/create */
                ->parent()->subItem('user.create')
                ->setUrl('')
                ->setIcon('plus-circle')
                ->requireAuthorization('user.create');

            /* settingsAndPackages */
            $navBuilder->group('administration')
                ->item('admin.settingsAndPackages')
                ->setIcon('gear')
                ->requireAuthorization(['theme.index', 'plugin.index'])
                /* plugin/index */
                ->subItem('plugin.index')
                ->setUrl('')
                ->setIcon('card-list')
                ->requireAuthorization('plugin.index')
                /* theme/index */
                ->parent()->subItem('theme.index')
                ->setUrl('')
                ->setIcon('card-list')
                ->requireAuthorization('theme.index')
                /* theme/index */
                ->parent()->subItem('setting.index')
                ->setUrl('')
                ->setIcon('card-list')
                ->requireAuthorization('setting.index');
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'latus');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'latus');

        $this->buildAdminNav();
    }
}
