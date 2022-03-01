<?php

namespace Latus\BasePlugin\Listeners;

use Illuminate\Support\Facades\Artisan;
use Latus\BasePlugin\Database\Seeders\PageSeeder;
use Latus\ComposerPlugins\Events\PackageInstalled;
use Latus\ComposerPlugins\Events\PackageUpdated;

class InstallPlugin
{
    public function handle(PackageInstalled|PackageUpdated $event)
    {
        app(PageSeeder::class)->run();

        Artisan::call('storage:link');

        Artisan::call('vendor:publish', ['--tag' => 'latus-plugin-assets', '--force' => true]);
    }
}