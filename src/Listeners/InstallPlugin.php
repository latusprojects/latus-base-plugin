<?php

namespace Latus\BasePlugin\Listeners;

use Latus\BasePlugin\Database\Seeders\DatabaseSeeder;
use Latus\ComposerPlugins\Events\PackageInstalled;

class InstallPlugin
{
    public function handle(PackageInstalled $event)
    {
        $this->seed();
    }

    protected function seed()
    {
        /**
         * @var DatabaseSeeder $seeder
         */
        $seeder = app(DatabaseSeeder::class);

        $seeder->run();
    }
}