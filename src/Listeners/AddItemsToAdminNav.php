<?php

namespace Latus\BasePlugin\Listeners;

use Latus\BasePlugin\Events\AdminNavDefined;
use Latus\UI\Exceptions\BuilderNotDefinedException;
use Latus\UI\Exceptions\ParentNotDefinedException;
use Latus\UI\Navigation\Builder;

class AddItemsToAdminNav
{

    protected Builder $builder;

    /**
     * Handle the AdminNavDefined event
     *
     * @param AdminNavDefined $event
     * @throws BuilderNotDefinedException
     * @throws ParentNotDefinedException
     */
    public function handle(AdminNavDefined $event)
    {

        $this->builder = &$event->adminNav->builder();

        $this->addGroups();

        $this->fillDashboardGroup();
        $this->fillContentGroup();
        $this->fillAdministrationGroup();

    }

    /**
     * @throws ParentNotDefinedException
     * @throws BuilderNotDefinedException
     */
    protected function addGroups()
    {
        $this->builder->group('dashboard', 'nav.dashboard');

        $this->builder->group('content', 'nav.content')
            ->append('dashboard');

        $this->builder->group('administration', 'nav.administration')
            ->append('content');


    }

    /**
     * @throws BuilderNotDefinedException
     * @throws ParentNotDefinedException
     */
    protected function fillDashboardGroup()
    {
        $this->builder->group('dashboard')
            /* dashboard/overview */
            ->item('dashboard.overview')
            ->setUrl(route('dashboard/overview'))
            ->setIcon('app')
            ->requireAuthorization('dashboard.overview');
//            /* dashboard/statistics */
//            ->parent()->item('dashboard.statistics')
//            ->setUrl(route('dashboard/statistics'))
//            ->setIcon('bar-chart-line')
//            ->requireAuthorization('dashboard.statistics');
    }


    /**
     * @throws ParentNotDefinedException
     * @throws BuilderNotDefinedException
     */
    protected function fillContentGroup()
    {
        /* pages */
        $this->builder->group('content')
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

//        /* posts */
//        $this->builder->group('content')
//            ->item('content.posts')
//            ->setIcon('newspaper')
//            ->requireAuthorization('content.post.index')
//            /* post/index */
//            ->subItem('content.post.index')
//            ->setUrl('')
//            ->setIcon('card-list')
//            ->requireAuthorization('content.post.index')
//            /* post/create */
//            ->parent()->subItem('content.post.create')
//            ->setUrl('')
//            ->setIcon('plus-circle')
//            ->requireAuthorization('content.post.create');

//        /* events */
//        $this->builder->group('content')
//            ->item('content.events')
//            ->setIcon('calendar-event')
//            ->requireAuthorization('content.event.index')
//            /* event/index */
//            ->subItem('content.event.index')
//            ->setUrl('')
//            ->setIcon('card-list')
//            ->requireAuthorization('content.event.index')
//            /* event/create */
//            ->parent()->subItem('content.event.create')
//            ->setUrl('')
//            ->setIcon('plus-circle')
//            ->requireAuthorization('content.event.create');
//
//        /* settings */
//        $this->builder->group('content')
//            ->item('content.settings')
//            ->setUrl('')
//            ->setIcon('sliders')
//            ->requireAuthorization('content.setting.index');
    }

    /**
     * @throws ParentNotDefinedException
     * @throws BuilderNotDefinedException
     */
    protected function fillAdministrationGroup()
    {
        /* usersAndRoles */
        $this->builder->group('administration')
            ->item('admin.rolesAndUsers')
            ->setIcon('people')
            ->requireAuthorization(['user.index', 'role.index'])
            /* role/index */
            ->subItem('role.index')
            ->setUrl(route('roles.index'))
            ->setIcon('card-list')
            ->requireAuthorization('role.index')
            /* role/create */
            ->parent()->subItem('role.create')
            ->setUrl(route('roles.create'))
            ->setIcon('plus-circle')
            ->requireAuthorization('role.create')
            /* user/index */
            ->parent()->subItem('user.index')
            ->setUrl(route('users.index'))
            ->setIcon('card-list')
            ->requireAuthorization('user.index')
            /* user/create */
            ->parent()->subItem('user.create')
            ->setUrl(route('users.create'))
            ->setIcon('plus-circle')
            ->requireAuthorization('user.create');

//        /* settingsAndPackages */
//        $this->builder->group('administration')
//            ->item('admin.settingsAndPackages')
//            ->setIcon('gear')
//            ->requireAuthorization(['theme.index', 'plugin.index'])
//            /* plugin/index */
//            ->subItem('plugin.index')
//            ->setUrl('')
//            ->setIcon('card-list')
//            ->requireAuthorization('plugin.index')
//            /* theme/index */
//            ->parent()->subItem('theme.index')
//            ->setUrl('')
//            ->setIcon('card-list')
//            ->requireAuthorization('theme.index')
//            /* theme/index */
//            ->parent()->subItem('setting.index')
//            ->setUrl('')
//            ->setIcon('card-list')
//            ->requireAuthorization('setting.index');
    }
}