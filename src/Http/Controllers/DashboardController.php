<?php

namespace Latus\BasePlugin\Http\Controllers;


use Illuminate\Auth\Access\AuthorizationException;
use Latus\BasePlugin\Contracts\Dashboard;
use Illuminate\View\View;

class DashboardController extends AdminController
{

    /**
     * Show the overview dashboard.
     *
     * @return View
     *
     * @throws AuthorizationException
     */
    public function showOverview(): View
    {
        $this->authorize('view', [Dashboard::class, 'overview']);

        return $this->returnView(\view('latus::admin.dashboard.overview'), 'dashboard.overview');
    }

    /**
     * Show the statistics dashboard.
     *
     * @return View
     *
     * @throws AuthorizationException
     */
    public function showStatistics(): View
    {
        $this->authorize('view', [Dashboard::class, 'statistics']);

        return $this->returnView(\view('latus::admin.dashboard.statistics'), 'dashboard.statistics');
    }
}