<?php

use Illuminate\Support\Facades\Route;
use Latus\BasePlugin\Http\Controllers\AuthController;
use Latus\BasePlugin\Http\Controllers\DashboardController;
use Latus\BasePlugin\Http\Controllers\PageController;
use Latus\BasePlugin\Http\Controllers\RoleController;
use Latus\BasePlugin\Http\Controllers\UserController;
use Latus\BasePlugin\Http\Controllers\WebController;
use Latus\BasePlugin\Http\Middleware\Cors;
use Latus\BasePlugin\Http\Middleware\VerifyUserCanViewAdminModule;
use Latus\BasePlugin\Modules\Contracts\AdminModule;
use Latus\BasePlugin\Modules\Contracts\AuthModule;
use Latus\BasePlugin\Modules\Contracts\WebModule;
use UniSharp\LaravelFilemanager\Lfm;

$webMiddleware = ['web', 'resolve-module:' . WebModule::class, Cors::class];

if (env('MAINTENANCE') === true) {
    $webMiddleware[] = 'auth';
}

/*
 * Module: Web
 * Routes for basic functionality
 */
Route::middleware($webMiddleware)->group(function () {

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
Route::middleware(['web', 'auth', VerifyUserCanViewAdminModule::class, 'resolve-module:' . AdminModule::class, Cors::class])->group(function () {

    $adminRoutesPrefix = config('latus-routes.admin_routes_prefix');

    Route::prefix($adminRoutesPrefix)->group(function () {
        Route::get('/dashboard/overview', [DashboardController::class, 'showOverview'])->name('dashboard/overview');
        Route::get('/dashboard/statistics', [DashboardController::class, 'showStatistics'])->name('dashboard/statistics');

        Route::resource('pages', PageController::class);

        Route::get('users/addableRoles/{targetUser?}', [UserController::class, 'addableRoles'])->name('users.addableRoles');
        Route::resource('users', UserController::class)->parameters(['users' => 'targetUser']);

        Route::get('roles/addableChildren/{role?}', [RoleController::class, 'addableChildren'])->name('roles.addableChildren');
        Route::resource('roles', RoleController::class);

        Route::get('', [DashboardController::class, 'showOverview'])->name('admin');

        /*
         * Laravel-FileManager
         */
        Route::prefix('files')->group(function () {
            Lfm::routes();
        });
    });
});

/*
 * Module: Auth
 * Routes for basic functionality
 */
Route::middleware(['web', 'resolve-module:' . AuthModule::class, Cors::class])->group(function () {

    $authRoutesPrefix = config('latus-routes.auth_routes_prefix');

    Route::prefix($authRoutesPrefix)->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('auth/login');
        Route::post('/submit', [AuthController::class, 'authenticate'])->name('auth/submit');
        Route::get('/register', [AuthController::class, 'showRegister'])->name('auth/register');
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth/logout');
        Route::get('/multiFactorLogin', [AuthController::class, 'showMultiFactorLogin'])->name('auth/factor-login');
    });
});