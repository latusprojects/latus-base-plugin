<?php

namespace Latus\BasePlugin\Services;

use Latus\BasePlugin\Models\Page;
use Latus\Content\Models\Content;
use Latus\Permalink\Models\Permalink;
use Latus\Permalink\Services\GeneratedPermalinkService;
use Latus\Permalink\Services\PermalinkService;

class PagePermalinkService
{
    public function generatePermalink(Content $page, string $permalink)
    {
        /**
         * @var PermalinkService $permalinkService
         */
        $permalinkService = app(PermalinkService::class);

        /**
         * @var GeneratedPermalinkService $generatedPermalinkService
         */
        $generatedPermalinkService = app(GeneratedPermalinkService::class);

        if (($permalinkModel = $permalinkService->getAllByModel($page)->first())) {
            $permalinkService->setUrlOfPermalink($permalinkModel, $permalink);
        } else {
            $permalinkService->createPermalink([
                'url' => $permalink,
                'target_url' => 'page/' . $page->id,
                'related_model_id' => $page->id,
                'related_model_class' => Page::class,
            ]);
        }

        $generatedPermalinkService->generatePermalinks();
    }

    public function deletePermalinks(Page $page)
    {
        /** @var PermalinkService $permalinkService */
        $permalinkService = app(PermalinkService::class);
        $permalinks = $permalinkService->getAllByModel($page);

        /** @var Permalink $permalink */
        foreach ($permalinks as $permalink) {
            $permalinkService->deletePermalink($permalink);
        }

        /**
         * @var GeneratedPermalinkService $generatedPermalinkService
         */
        $generatedPermalinkService = app(GeneratedPermalinkService::class);

        $generatedPermalinkService->generatePermalinks();
    }
}