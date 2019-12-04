<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\BeforeMiddleware as BeforeMiddleware;
use App\Http\Middleware\AfterMiddleware as AfterMiddleware;
use App\Http\Middleware\AuthJWT as AuthJWT;

class Kernel extends HttpKernel {

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];
    
    /**
     * Set middlware priority execution order
     * @var type 
     */
    protected $middlewarePriority = [
        'auth' => 'App\Http\Middleware\Authenticate',
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
//        'jwt.auth.connection' => AuthJWT::class,
        
        'jwt.auth' => 'Tymon\JWTAuth\Middleware\GetUserFromToken',
//        'jwt.refresh' => 'Tymon\JWTAuth\Middleware\RefreshToken',
        'before' => BeforeMiddleware::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'acl' => App\Http\Middleware\ControlAccess::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
//             \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
//            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            'throttle:200,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => 'App\Http\Middleware\Authenticate',
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
//        'jwt.auth.connection' => AuthJWT::class,
        'before' => BeforeMiddleware::class,
        'acl' => \App\Http\Middleware\ControlAccess::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'jwt.auth' => 'Tymon\JWTAuth\Middleware\GetUserFromToken',
//        'jwt.refresh' => 'Tymon\JWTAuth\Middleware\RefreshToken',
    ];

}