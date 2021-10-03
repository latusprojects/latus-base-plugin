<?php

namespace Latus\BasePlugin\Providers;

use Latus\BasePlugin\Listeners\AddItemsToAdminNav;
use Latus\BasePlugin\Events\AdminNavDefined;
use Latus\BasePlugin\Listeners\InstallPlugin;

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    protected $listen = [
        AdminNavDefined::class => [
            AddItemsToAdminNav::class
        ],
        'latus.package.installed.' . PluginServiceProvider::PLUGIN_NAME => [
            InstallPlugin::class,
        ],
        'latus.package.updated.' . PluginServiceProvider::PLUGIN_NAME => [
            InstallPlugin::class,
        ],
    ];
}