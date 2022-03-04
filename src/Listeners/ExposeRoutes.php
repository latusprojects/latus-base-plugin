<?php

namespace Latus\BasePlugin\Listeners;

use Latus\PluginAPI\Events\ExposesData;

class ExposeRoutes
{
    public function handle(ExposesData $event)
    {
        $event->exposedDataService()->expose('routes', [
            'users.edit' => route('users.edit', ['user' => ':user']),
            'users.show' => route('users.show', ['user' => ':user']),
        ]);
    }
}