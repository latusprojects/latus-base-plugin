<?php

namespace Latus\BasePlugin\Listeners;

use Latus\BasePlugin\Modules\Contracts\WebModule;
use Latus\PluginAPI\Events\IncludesJsAssets;

class AttachJsAssets
{
    public function handle(IncludesJsAssets $event)
    {
        $event->assetService()->attachJs(url: asset('assets/vendor/latusprojects/latus-base-plugin/ContentTools/content-tools.js'), shouldShow: function () {
            return CURRENT_MODULE === WebModule::class;
        });
    }
}