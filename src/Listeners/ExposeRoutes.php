<?php

namespace Latus\BasePlugin\Listeners;

use Latus\PluginAPI\Events\ExposesData;

class ExposeRoutes
{
    public function handle(ExposesData $event)
    {
        $event->exposedDataService()->expose('routes', [
            'users.edit' => route('users.edit', ['targetUser' => ':user']),
            'users.store' => route('users.store'),
            'users.update' => route('users.update', ['targetUser' => ':user']),
            'users.show' => route('users.show', ['targetUser' => ':user']),

            'roles.edit' => route('roles.edit', ['role' => ':role']),
            'roles.store' => route('roles.store'),
            'roles.update' => route('roles.update', ['role' => ':role']),
            'roles.show' => route('roles.show', ['role' => ':role']),
            'roles.destroy' => route('roles.destroy', ['role' => ':role']),
        ]);
    }
}