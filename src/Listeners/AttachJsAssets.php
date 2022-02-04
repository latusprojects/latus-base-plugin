<?php

namespace Latus\BasePlugin\Listeners;

use Latus\BasePlugin\Modules\Contracts\AdminModule;
use Latus\BasePlugin\Modules\Contracts\WebModule;
use Latus\PluginAPI\Events\IncludesJsAssets;

class AttachJsAssets
{
    public function handle(IncludesJsAssets $event)
    {
        $event->assetService()->attachJs(url: asset('assets/vendor/latusprojects/latus-base-plugin/admin.js'), defer: true, shouldShow: function () {
            return CURRENT_MODULE === AdminModule::class;
        });

        $event->assetService()->attachJs(url: asset('vendor/laraberg/js/laraberg.js'), defer: true, shouldShow: function () {
            return CURRENT_MODULE === AdminModule::class;
        });

        $event->assetService()->attachJs(url: 'https://unpkg.com/react@16.8.6/umd/react.production.min.js', shouldShow: function () {
            return CURRENT_MODULE === AdminModule::class;
        });

        $event->assetService()->attachJs(url: 'https://unpkg.com/react-dom@16.8.6/umd/react-dom.production.min.js', shouldShow: function () {
            return CURRENT_MODULE === AdminModule::class;
        });
    }
}