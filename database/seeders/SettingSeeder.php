<?php


namespace Latus\BasePluginDatabase\Seeders;


use Illuminate\Database\Seeder;
use Latus\BasePlugin\Modules\Contracts\AuthModule;
use Latus\BasePlugin\Modules\Contracts\WebModule;
use Latus\Settings\Services\SettingService;
use Latus\BasePlugin\Modules\Contracts\AdminModule;

class SettingSeeder extends Seeder
{
    public function __construct(
        protected SettingService $settingService
    )
    {
    }

    public const SETTINGS = [
        ['key' => 'active_themes', 'value' => []],
        ['key' => 'active_modules', 'value' => []],
        ['key' => 'disabled_modules', 'value' => []],
        ['key' => 'main_repository_name', 'value' => 'latusprojects.repo.repman.io']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::SETTINGS as $setting) {
            if (is_array($setting['value'])) {
                $setting['value'] = json_encode($setting['value']);
            }
            $this->settingService->createSetting($setting);
        }
    }

}