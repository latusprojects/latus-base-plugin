<?php

namespace Latus\BasePlugin\Providers;

use Latus\BasePlugin\Listeners\AddItemsToAdminNav;
use Latus\BasePlugin\Events\AdminNavDefined;

class EventServiceProvider extends \Illuminate\Events\EventServiceProvider
{
    protected array $listen = [
        AdminNavDefined::class => [
            AddItemsToAdminNav::class
        ]
    ];
}