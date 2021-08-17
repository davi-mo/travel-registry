<?php

namespace Tests\Unit\Http;

use App\Http\Kernel;
use Tests\TestCase;

class KernelTest extends TestCase
{
    /**
     * @covers \App\Http\Kernel
     */
    public function testRegisteredMiddleware()
    {
        $kernel = \Mockery::mock(Kernel::class);
        $getMiddleware = \Closure::bind(function (Kernel $kernel) {
            return $kernel->middleware;
        }, null, Kernel::class);
        $middleware = $getMiddleware($kernel);
        $expected = [
            \App\Http\Middleware\TrustProxies::class,
            \Fruitcake\Cors\HandleCors::class,
            \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \App\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ];
        $this->assertEquals($expected, $middleware);
    }
    /**
     * @covers \App\Http\Kernel
     */
    public function testRegisteredMiddlewareGroups()
    {
        $kernel = \Mockery::mock(Kernel::class);
        $getMiddleware = \Closure::bind(function (Kernel $kernel) {
            return $kernel->middlewareGroups;
        }, null, Kernel::class);
        $middleware = $getMiddleware($kernel);
        $expected = [
            'web' => [
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \App\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],

            'api' => [
                'throttle:api',
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],

            'existing-region' => [
                \App\Http\Middleware\VerifyExistingRegion::class,
            ],

            'existing-country' => [
                \App\Http\Middleware\VerifyExistingCountry::class,
            ],

            'existing-city' => [
                \App\Http\Middleware\VerifyExistingCity::class,
            ],

            'existing-user' => [
                \App\Http\Middleware\VerifyExistingUser::class,
            ],

            'validate-visited-city' => [
                \App\Http\Middleware\ValidateVisitedCity::class,
            ],
        ];
        $this->assertEquals($expected, $middleware);
    }
    /**
     * @covers \App\Http\Kernel
     */
    public function testRegisteredRouteMiddleware()
    {
        $kernel = \Mockery::mock(Kernel::class);
        $getMiddleware = \Closure::bind(function (Kernel $kernel) {
            return $kernel->routeMiddleware;
        }, null, Kernel::class);
        $middleware = $getMiddleware($kernel);
        $expected = [
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ];
        $this->assertEquals($expected, $middleware);
    }
}
