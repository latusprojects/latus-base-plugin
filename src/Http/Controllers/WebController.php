<?php

namespace Latus\BasePlugin\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\View\View;
use Latus\BasePlugin\Http\Requests\WebPageRequest;
use Latus\BasePlugin\Modules\Contracts\WebModule;
use Latus\UI\Components\Contracts\ModuleComponent;
use Latus\UI\Services\ComponentService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WebController extends Controller
{

    public function __construct(
        protected ComponentService $componentService
    )
    {
    }
    
    public function showPage(WebPageRequest $request): View
    {
        try {
            /**
             * @var ModuleComponent $module
             */
            $module = $this->componentService->getActiveModule(WebModule::class);
        } catch (BindingResolutionException $e) {
            abort(503);
        } catch (NotFoundHttpException $e) {
            abort(404);
        }

        if (!($content = $request->getPageContent())) {
            abort(404);
        }

        $page = $module->getPage($content->type);
        $page->setContent($content);

        if (!($view = $page->resolvesView())) {
            abort(404);
        }

        return $view;
    }
}