<?php

namespace Latus\BasePlugin\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Latus\BasePlugin\UI\Widgets\AdminNav;

class AdminNavDefined
{
    use Dispatchable;

    public function __construct(
        public AdminNav &$adminNav
    )
    {
    }
}