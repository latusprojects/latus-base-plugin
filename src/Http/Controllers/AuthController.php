<?php

namespace Latus\BasePlugin\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Latus\BasePlugin\Http\Requests\AuthenticateUserRequest;
use Latus\BasePlugin\Http\Requests\StoreUserRequest;
use Latus\BasePlugin\Modules\Contracts\AuthModule;
use Latus\Permissions\Services\UserService;
use Latus\UI\Components\Contracts\ModuleComponent;
use Latus\UI\Services\ComponentService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{

    protected ModuleComponent $authModule;

    public function __construct(
        protected ComponentService $componentService
    )
    {
    }

    /**
     * Returns the auth-module or null if no binding for it exists in the app-container
     *
     * @return ModuleComponent
     */
    protected function getAuthModuleOrAbort(): ModuleComponent
    {
        if (!isset($this->{'authModule'})) {
            try {
                $this->authModule = $this->componentService->getActiveModule(AuthModule::class);
            } catch (BindingResolutionException $e) {
                abort(503);
            } catch (NotFoundHttpException $e) {
                abort(404);
            }
        }

        return $this->authModule;
    }

    /**
     * Returns the page-view or an error-response
     *
     * @param string $page
     * @return Response|View
     */
    protected function getPageViewOrAbort(string $page): Response|View
    {
        $pageView = null;

        try {
            $pageView = $this->getAuthModuleOrAbort()->getPage($page)->resolvesView();
        } catch (\Throwable $e) {
            abort(503);
        }

        return $pageView;
    }

    /**
     * Returns the login-view or an error-response
     *
     * @Route("/auth/login", methods={"GET"})
     * @return Response|View
     */
    public function showLogin(): Response|View
    {
        return $this->getPageViewOrAbort('login');
    }

    /**
     * Returns the login-view with support for multi-factor-authentication or an error-response
     *
     * @Route("/auth/mfa-login", methods={"GET"})
     * @return Response|View
     */
    public function showMultiFactorLogin(): Response|View
    {
        return $this->getPageViewOrAbort('multiFactorLogin');
    }

    /**
     * Attempts to authenticate a user and returns a json-response containing the status and additional messages
     * This route also handles multi-factor login-submit requests
     *
     * @Route("/auth/submit", methods={"POST"})
     * @param AuthenticateUserRequest $request
     * @return Response|JsonResponse
     */
    public function authenticate(AuthenticateUserRequest $request): Response|JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return \response()->json([
                'message' => 'user authenticated',
                'data' => [
                    'prefer_target' => false
                ]
            ]);
        }

        return \response('Not Found', 404)->json([
            'message' => 'user not found'
        ]);
    }

    /**
     * Returns the login-view or an error-response
     *
     * @Route("/auth/register", methods={"GET"})
     * @return Response|View
     */
    public function showRegister(): Response|View
    {
        return $this->getPageViewOrAbort('register');
    }

    /**
     * Attempts to store a new user and returns a json-response containing the status and additional messages
     *
     * @Route("/auth/store", methods={"PUT"})
     * @param StoreUserRequest $request
     * @param UserService $userService
     * @return Response|JsonResponse
     */
    public function store(StoreUserRequest $request, UserService $userService): Response|JsonResponse
    {
        $validatedInput = $request->validated();

        try {
            $user = $userService->createUser($validatedInput);
        } catch (\InvalidArgumentException $e) {
            return \response('Bad Request', 400)->json([
                'message' => 'user-service attribute validation failed'
            ]);
        }

        return \response()->json([
            'message' => 'user created',
            'data' => [
                'created_at' => $user->getCreatedAtColumn()
            ]
        ]);

    }
}