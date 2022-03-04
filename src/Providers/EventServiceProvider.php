<?php

namespace Latus\BasePlugin\Providers;

use Latus\BasePlugin\Listeners\AddItemsToAdminNav;
use Latus\BasePlugin\Events\AdminNavDefined;
use Latus\BasePlugin\Listeners\AttachCssAssets;
use Latus\BasePlugin\Listeners\AttachJsAssets;
use Latus\BasePlugin\Listeners\ExposeRoutes;
use Latus\BasePlugin\Listeners\ExposeTranslations;
use Latus\PluginAPI\Events\ExposesData;
use Latus\PluginAPI\Events\IncludesCssAssets;
use Latus\PluginAPI\Events\IncludesJsAssets;

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    protected $listen = [
        AdminNavDefined::class => [
            AddItemsToAdminNav::class
        ],
        IncludesJsAssets::class => [
            AttachJsAssets::class
        ],
        IncludesCssAssets::class => [
            AttachCssAssets::class
        ],
        ExposesData::class => [
            ExposeTranslations::class,
            ExposeRoutes::class,
        ],
    ];
}