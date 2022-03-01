<?php

namespace Latus\BasePlugin\Listeners;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Latus\BasePlugin\Database\Seeders\PageSeeder;
use Latus\ComposerPlugins\Events\PackageInstalled;
use Latus\ComposerPlugins\Events\PackageUpdated;

class InstallPlugin
{
    public function handle(PackageInstalled|PackageUpdated $event)
    {
        app(PageSeeder::class)->run();

        Artisan::call('storage:link');

        File::copyDirectory(__DIR__ . '../../resources/assets/dist', public_path('assets'));
    }
}