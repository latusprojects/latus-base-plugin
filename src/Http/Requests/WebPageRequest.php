<?php

namespace Latus\BasePlugin\Http\Requests;

use Illuminate\Http\Request;
use Latus\Content\Models\Content;
use Latus\Content\Services\ContentService;

class WebPageRequest extends Request
{

    public static string $pagePrefix = 'page--';

    protected ContentService $contentService;

    protected function getContentService(): ContentService
    {
        if (!isset($this->{'contentService'})) {
            $this->contentService = app(ContentService::class);
        }

        return $this->contentService;
    }

    public function getPageContent(): Content|null
    {
        $pageId = request()->route()->parameter('page_id');

        /**
         * @var Content $content
         */
        $content = $this->getContentService()->find($pageId);

        if (!$content || !str_starts_with($content->name, self::$pagePrefix)) {
            return null;
        }

        return $content;
    }
}