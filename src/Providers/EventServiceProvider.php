<?php

namespace Latus\BasePlugin\Providers;

use Latus\BasePlugin\Listeners\AddItemsToAdminNav;
use Latus\UI\Events\AdminNavDefined;

class EventServiceProvider extends \Illuminate\Events\EventServiceProvider
{
    protected array $listen = [
        AdminNavDefined::class => [
            AddItemsToAdminNav::class
        ]
    ];
}