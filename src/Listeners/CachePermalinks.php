<?php

namespace Latus\BasePlugin\Listeners;

use Latus\BasePlugin\Models\Page;
use Latus\Permalink\Events\GeneratesPermalinks;
use Latus\Permalink\Models\Permalink;

class CachePermalinks
{
    public function handle(GeneratesPermalinks $event)
    {
        $pagePermalinks = Permalink::query()->where('related_model_class', Page::class)->get();

        foreach ($pagePermalinks as $pagePermalink) {
            $event->getGeneratedPermalinkService()->attachCachablePermalink(
                $pagePermalink->url, $pagePermalink->related_model_class, $pagePermalink->related_model_id, $pagePermalink->target_url
            );
        }
    }
}