<?php

namespace Latus\BasePlugin\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Latus\BasePlugin\Http\Controllers\AdminController;
use Latus\BasePlugin\Http\Controllers\AuthController;
use Latus\BasePlugin\Http\Controllers\WebController;
use Latus\BasePlugin\Modules\Contracts\AdminModule;
use Latus\BasePlugin\Modules\Contracts\AuthModule;
use Latus\BasePlugin\Modules\Contracts\WebModule;
use Latus\Content\Services\ContentService;
use Latus\Installer\Providers\Traits\RegistersSeeders;
use Latus\Laravel\Http\Middleware\BuildPackageDependencies;
use Latus\BasePlugin\Events\AdminNavDefined;
use Latus\Permalink\Services\GeneratedPermalinkService;
use Latus\PluginAPI\Latus;
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

            if (!file_exists(base_path('bootstrap/cache/permalinks.php'))) {
                /**
                 * @var GeneratedPermalinkService $generatedPermalinkService
                 */
                $generatedPermalinkService = $this->app->make(GeneratedPermalinkService::class);

                $generatedPermalinkService->generatePermalinks();
            }
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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/components', 'latus-comp');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'latus');

        $this->publishes([
            __DIR__ . '/../../resources/assets/dist' => public_path('assets')
        ], 'latus-plugin-assets');

        $this->createMacros();

        $this->app->register(RouteServiceProvider::class);

        Blade::component('latus-comp::viewModal', 'latus.viewModal');
        Blade::component('latus-comp::multiStepCarousel', 'latus.multiStepCarousel');

        Blade::component('latus-comp::crud.createPage', 'latus.createPage');
        Blade::component('latus-comp::crud.editPage', 'latus.editPage');
        Blade::component('latus-comp::crud.indexPage', 'latus.indexPage');

        URL::forceRootUrl(Config::get('app.url'));

        if (Str::contains(Config::get('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }

    protected function createMacros()
    {
        Latus::macro('pages', function (array $pageNames, string $prefix = 'page--') {
            $pageNames = preg_filter('/^/', $prefix, $pageNames);
            $contentService = app(ContentService::class);

            return $contentService->getByNames($pageNames);
        });

        Latus::macro('page', function (string $pageName) {
            $pageName = 'page--' . $pageName;
            $contentService = app(ContentService::class);

            return $contentService->findByName($pageName);
        });

        Latus::macro('posts', function (array $postNames, string $prefix = 'post--') {
            $postNames = preg_filter('/^/', $prefix, $postNames);
            $contentService = app(ContentService::class);

            return $contentService->getByNames($postNames);
        });

        Latus::macro('post', function (string $postName) {
            $postName = 'post--' . $postName;
            $contentService = app(ContentService::class);

            return $contentService->findByName($postName);
        });

        Response::macro('latusSuccess', function (int $status = 200, string $message = 'action successful', array $data = null) {

            $responsePayload = [
                'message' => $message
            ];

            if ($data) {
                $responsePayload['data'] = $data;
            }

            return \response()->json($responsePayload, $status);
        });

        Response::macro('latusFailed', function (int $status, string $message = 'action failed', array $data = null) {

            $responsePayload = [
                'message' => $message
            ];

            if ($data) {
                $responsePayload['data'] = $data;
            }

            return \response()->json($responsePayload, $status);
        });
    }
}