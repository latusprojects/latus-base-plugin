<?php

namespace Latus\BasePlugin\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Latus\BasePlugin\Http\Controllers\AdminController;
use Latus\BasePlugin\Http\Controllers\AuthController;
use Latus\BasePlugin\Http\Controllers\WebController;
use Latus\BasePlugin\Modules\Contracts\AdminModule;
use Latus\BasePlugin\Modules\Contracts\AuthModule;
use Latus\BasePlugin\Modules\Contracts\WebModule;
use Latus\BasePluginDatabase\Seeders\DatabaseSeeder;
use Latus\Installer\Providers\Traits\RegistersSeeders;
use Latus\Laravel\Http\Middleware\BuildPackageDependencies;
use Latus\UI\Events\AdminNavDefined;
use Latus\UI\Providers\Traits\DefinesModules;
use Latus\UI\Widgets\AdminNav;

class PluginServiceProvider extends ServiceProvider
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

        $this->registerServiceProviders();
    }

    /**
     * Register additional service-providers
     */
    protected function registerServiceProviders()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
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
    }
}