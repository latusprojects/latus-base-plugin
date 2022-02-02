<?php

namespace Latus\BasePlugin\Listeners;

use Latus\BasePlugin\Modules\Contracts\AdminModule;
use Latus\BasePlugin\Modules\Contracts\WebModule;
use Latus\PluginAPI\Events\IncludesCssAssets;

class AttachCssAssets
{
    public function handle(IncludesCssAssets $event)
    {
        $event->assetService()->attachCss(url: asset('assets/vendor/latusprojects/latus-base-plugin/admin.css'), shouldShow: function () {
            return CURRENT_MODULE === AdminModule::class;
        });

        $event->assetService()->attachCss(url: asset('vendor/laraberg/css/laraberg.css'), shouldShow: function () {
            return CURRENT_MODULE === AdminModule::class;
        });
    }
}