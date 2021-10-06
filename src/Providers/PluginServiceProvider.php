<?php

namespace Latus\BasePlugin\Providers;

use Illuminate\Support\ServiceProvider;
use Latus\BasePlugin\Http\Controllers\AdminController;
use Latus\BasePlugin\Http\Controllers\AuthController;
use Latus\BasePlugin\Http\Controllers\WebController;
use Latus\BasePlugin\Modules\Contracts\AdminModule;
use Latus\BasePlugin\Modules\Contracts\AuthModule;
use Latus\BasePlugin\Modules\Contracts\WebModule;
use Latus\Installer\Providers\Traits\RegistersSeeders;
use Latus\Laravel\Http\Middleware\BuildPackageDependencies;
use Latus\BasePlugin\Events\AdminNavDefined;
use Latus\UI\Providers\Traits\DefinesModules;
use Latus\BasePlugin\UI\Widgets\AdminNav;
use Latus\UI\Providers\Traits\ProvidesWidgets;

class PluginServiceProvider extends ServiceProvider
{
    use RegistersSeeders, DefinesModules, ProvidesWidgets;

    public const PLUGIN_NAME = 'latusprojects/latus-base-plugin';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
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

        $this->provideWidgets([
            'admin-nav' => AdminNav::class
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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'latus');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'latus');
    }
}