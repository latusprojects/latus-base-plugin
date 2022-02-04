<?php

use Illuminate\Support\Facades\Route;
use Latus\BasePlugin\Http\Controllers\AuthController;
use Latus\BasePlugin\Http\Controllers\DashboardController;
use Latus\BasePlugin\Http\Controllers\PageController;
use Latus\BasePlugin\Http\Controllers\WebController;
use Latus\BasePlugin\Http\Middleware\VerifyUserCanViewAdminModule;
use Latus\BasePlugin\Modules\Contracts\AdminModule;
use Latus\BasePlugin\Modules\Contracts\AuthModule;
use Latus\BasePlugin\Modules\Contracts\WebModule;

/*
 * Module: Web
 * Routes for basic functionality
 */
Route::middleware(['web', 'resolve-module:' . WebModule::class])->group(function () {

    $webRoutes = function () {
        Route::get('/page/{page_id}', [WebController::class, 'showPage']);
        Route::get('/', ['uses' => implode('@', [WebController::class, 'showPage']), 'as' => '/page/home'])->defaults('page_id', 'home');
    };

    $webRoutesPrefix = config('latus-routes.web_routes_prefix');
    if ($webRoutesPrefix && $webRoutesPrefix !== '') {
        Route::prefix($webRoutesPrefix)->group($webRoutes);
    } else {
        $webRoutes();
    }
});

/*
 * Module: Admin
 * Routes for basic functionality
 */
Route::middleware(['web', 'auth', VerifyUserCanViewAdminModule::class, 'resolve-module:' . AdminModule::class])->group(function () {

    $adminRoutesPrefix = config('latus-routes.admin_routes_prefix');

    Route::prefix($adminRoutesPrefix)->group(function () {
        Route::get('/dashboard/overview', [DashboardController::class, 'showOverview'])->name('dashboard/overview');
        Route::get('/dashboard/statistics', [DashboardController::class, 'showStatistics'])->name('dashboard/statistics');

        Route::resource('pages', PageController::class);

        Route::get('', [DashboardController::class, 'showOverview'])->name('admin');

        /*
         * Laravel-FileManager
         */

        Route::prefix('files')->group(function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });
    });
});

/*
 * Module: Auth
 * Routes for basic functionality
 */
Route::middleware(['web', 'resolve-module:' . AuthModule::class])->group(function () {

    $authRoutesPrefix = config('latus-routes.auth_routes_prefix');

    Route::prefix($authRoutesPrefix)->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('auth/login');
        Route::post('/submit', [AuthController::class, 'authenticate'])->name('auth/submit');
        Route::get('/register', [AuthController::class, 'showRegister'])->name('auth/register');
        Route::get('/multiFactorLogin', [AuthController::class, 'showMultiFactorLogin'])->name('auth/factor-login');
    });
});