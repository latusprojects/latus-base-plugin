<?php

namespace Latus\BasePlugin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Latus\BasePlugin\Services\PagePermalinkService;
use Latus\Content\Services\ContentService;
use Latus\BasePlugin\Http\Requests\Page\StorePageRequest;
use Latus\BasePlugin\Http\Requests\Page\UpdatePageRequest;
use Latus\BasePlugin\Models\Page;
use Latus\Permalink\Services\PermalinkService;
use Latus\UI\Services\ComponentService;
use Latus\BasePlugin\UI\Widgets\AdminNav;

class PageController extends AdminController
{

    public function __construct(ComponentService $componentService, AdminNav $adminNav)
    {
        parent::__construct($componentService, $adminNav);

        $this->authorizeResource(Page::class, 'page');
    }

    public function index(ContentService $contentService): View
    {
        return $this->returnView(view('latus::admin.content.page.index')->with(['paginator' => $contentService->paginateContent('page', 15,
            function ($page) {
                return auth()->user()->can('view', $page);
            }
        )]), 'content.page.index');
    }

    public function create(): View
    {
        return $this->returnView(view('latus::admin.content.page.create'), 'content.page.create');
    }

    public function store(StorePageRequest $request, ContentService $contentService, PagePermalinkService $pagePermalinkService): JsonResponse
    {
        $validatedInput = $request->validated();

        try {
            /** @var Page $page */
            $page = $contentService->createContent([
                'type' => 'page',
                'name' => 'page--' . microtime(),
                'owner_model_class' => get_class(auth()->user()),
                'owner_model_id' => auth()->user()->id,
                'title' => $validatedInput['title'] ?? '',
                'text' => (string)$validatedInput['text'] ?? '',
            ]);

            $pagePermalinkService->generatePermalink($page, $validatedInput['permalink']);

        } catch (\InvalidArgumentException $exception) {
            return response()->latusFailed(status: 422, message: 'content-service attribute validation failed');
        }

        return response()->latusSuccess(message: 'page created', data: [
            'created_at' => $page->getCreatedAtColumn(),
            'id' => $page->id,
        ]);
    }

    public function edit(Page $page, PermalinkService $permalinkService): View
    {
        return $this->returnView(view('latus::admin.content.page.edit')->with(['page' => $page, 'permalink' => $permalinkService->getAllByModel($page)->first()]), 'content.page.edit');
    }

    public function update(Page $page, UpdatePageRequest $request, ContentService $contentService, PagePermalinkService $pagePermalinkService): JsonResponse
    {
        $validatedInput = $request->validated();

        $contentService->setTitleOfContent($page, $validatedInput['title'] ?? '');
        $contentService->setTextOfContent($page, $validatedInput['text'] ?? '');

        $pagePermalinkService->generatePermalink($page, $validatedInput['permalink']);

        return response()->latusSuccess(message: 'page updated', data: [
            'updated_at' => $page->updated_at,
            'id' => $page->id,
        ]);
    }

    public function destroy(Page $page, ContentService $contentService, PagePermalinkService $pagePermalinkService): JsonResponse
    {
        $pagePermalinkService->deletePermalinks($page);

        $contentService->deleteContent($page);

        return response()->latusSuccess(message: 'page deleted');
    }

    public function show(Page $page): View
    {
        return $this->returnView(view('latus::admin.content.page.show')->with(['page' => $page]), 'content.page.show');
    }
}