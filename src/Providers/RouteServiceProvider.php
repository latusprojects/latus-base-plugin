<?php

namespace Latus\BasePlugin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Latus\Content\Services\ContentService;
use Latus\BasePlugin\Models\Page;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        Route::bind('page', function (int|string $pageId) {
            /**
             * @var ContentService $contentService
             */
            $contentService = app(ContentService::class, ['relatedModel' => new Page()]);
            $page = $contentService->find($pageId);

            if (!$page || $page->type !== 'page') {
                abort(404);
            }
            return $page;
        });
    }
}
