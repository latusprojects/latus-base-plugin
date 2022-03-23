<?php

namespace Latus\BasePlugin\Listeners;

use Illuminate\Support\Facades\Lang;
use Latus\PluginAPI\Events\ExposesData;

class ExposeTranslations
{
    protected string $lhPrefix = 'latus::';

    public function handle(ExposesData $event)
    {
        $navTranslations = $this->prefixArrayKeys($this->lhPrefix . 'nav.', Lang::get('latus::nav'));
        $roleTranslations = $this->prefixArrayKeys($this->lhPrefix . 'role.', Lang::get('latus::role'));
        $userTranslations = $this->prefixArrayKeys($this->lhPrefix . 'user.', Lang::get('latus::user'));

        $event->exposedDataService()->expose('trans', $navTranslations + $roleTranslations + $userTranslations);
    }

    protected function prefixArrayKeys(string $prefix, array $array): array
    {
        return array_combine(array_map(function ($key) use ($prefix) {
            return $prefix . $key;
        }, array_keys($array)), $array);
    }

}