<?php

namespace Latus\BasePlugin\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
     * @return View
     */
    protected function getPageViewOrAbort(string $page): View
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
     * @return View
     */
    public function showLogin(): View
    {
        return $this->getPageViewOrAbort('login');
    }

    /**
     * Returns the login-view with support for multi-factor-authentication or an error-response
     *
     * @Route("/auth/mfa-login", methods={"GET"})
     * @return View
     */
    public function showMultiFactorLogin(): View
    {
        return $this->getPageViewOrAbort('multiFactorLogin');
    }

    /**
     * Attempts to authenticate a user and returns a json-response containing the status and additional messages
     * This route also handles multi-factor login-submit requests
     *
     * @Route("/auth/submit", methods={"POST"})
     * @param AuthenticateUserRequest $request
     * @return JsonResponse
     */
    public function authenticate(AuthenticateUserRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return response()->json([
                'message' => 'user authenticated',
                'data' => [
                    'prefer_target' => false
                ]
            ]);
        }

        return response()->json([
            'message' => 'user not found'
        ], 404);
    }

    /**
     * Returns the login-view or an error-response
     *
     * @Route("/auth/register", methods={"GET"})
     * @return View
     */
    public function showRegister(): View
    {
        return $this->getPageViewOrAbort('register');
    }

    /**
     * Attempts to store a new user and returns a json-response containing the status and additional messages
     *
     * @Route("/auth/store", methods={"PUT"})
     * @param StoreUserRequest $request
     * @param UserService $userService
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request, UserService $userService): JsonResponse
    {
        $validatedInput = $request->validated();

        try {
            $user = $userService->createUser($validatedInput);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'message' => 'user-service attribute validation failed'
            ], 400);
        }

        return response()->json([
            'message' => 'user created',
            'data' => [
                'created_at' => $user->getCreatedAtColumn()
            ]
        ]);

    }

    /**
     * Flushes the current session and logs out user
     *
     * @Route("/auth/logout", methods={"GET"})
     * @return RedirectResponse
     */
    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('auth/login');
    }
}