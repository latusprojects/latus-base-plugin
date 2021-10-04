<?php

namespace Latus\BasePlugin\Providers;

use Latus\BasePlugin\Listeners\AddItemsToAdminNav;
use Latus\BasePlugin\Events\AdminNavDefined;

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    protected $listen = [
        AdminNavDefined::class => [
            AddItemsToAdminNav::class
        ]
    ];
}