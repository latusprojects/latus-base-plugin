<?php

namespace Latus\BasePlugin\Listeners;

use Latus\BasePlugin\Modules\Contracts\WebModule;
use Latus\PluginAPI\Events\IncludesCssAssets;

class AttachCssAssets
{
    public function handle(IncludesCssAssets $event)
    {
        $event->assetService()->attachCss(url: asset('assets/vendor/latusprojects/latus-base-plugin/ContentTools/content-tools.css'), shouldShow: function () {
            return CURRENT_MODULE === WebModule::class;
        });
    }
}