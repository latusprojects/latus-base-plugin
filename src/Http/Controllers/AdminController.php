<?php


namespace Latus\BasePlugin\Http\Controllers;


use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\View\View;
use Latus\UI\Components\Contracts\ModuleComponent;
use Latus\BasePlugin\Modules\Contracts\AdminModule;
use Latus\UI\Services\ComponentService;
use Latus\BasePlugin\UI\Widgets\AdminNav;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{
    public function __construct(
        protected ComponentService $componentService,
        protected AdminNav         $adminNav
    )
    {
    }

    protected function returnView(\Illuminate\Contracts\View\View $viewTarget, string $reference = null): View
    {
        try {
            /**
             * @var ModuleComponent $module
             */
            $module = $this->componentService->getActiveModule(AdminModule::class);
        } catch (BindingResolutionException $e) {
            abort(503);
        } catch (NotFoundHttpException $e) {
            abort(404);
        }


        $pageView = null;
        try {
            if ($reference) {
                $this->adminNav->setReference($reference);
            }

            $pageView = $module->getPage('page')->resolvesView()->with(['adminNav' => app()->make(AdminNav::class), 'content' => $viewTarget->render()]);
        } catch (\Throwable $e) {
            abort(503);
        }

        return $pageView;

    }
}