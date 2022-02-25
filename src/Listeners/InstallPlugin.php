<?php

namespace Latus\BasePlugin\Listeners;

use Illuminate\Support\Facades\Artisan;
use Latus\BasePlugin\Database\Seeders\PageSeeder;
use Latus\ComposerPlugins\Events\PackageInstalled;

class InstallPlugin
{
    public function handle(PackageInstalled $event)
    {
        app(PageSeeder::class)->run();

        Artisan::call('storage:link');
    }
}