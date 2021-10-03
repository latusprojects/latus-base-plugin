<?php

namespace Latus\BasePlugin\Listeners;

use Latus\BasePlugin\Database\Seeders\PageSeeder;
use Latus\ComposerPlugins\Events\PackageInstalled;

class InstallPlugin
{
    public function handle(PackageInstalled $event)
    {
        app(PageSeeder::class)->run();
    }
}