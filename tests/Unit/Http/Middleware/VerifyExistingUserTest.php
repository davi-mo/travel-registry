<?php

namespace Tests\Unit\Http\Middleware;

use App\Exceptions\NotFoundException;
use App\Http\Middleware\VerifyExistingUser;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Tests\TestCase;

class VerifyExistingUserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Http\Middleware\VerifyExistingUser::__construct
     * @covers \App\Http\Middleware\VerifyExistingUser::handle
     */
    public function testVerifyExistingUserNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $requestMock = \Mockery::mock(Request::class);
        $userServiceMock = \Mockery::mock(UserService::class);
        $routeMock = \Mockery::mock(Route::class);
        $userId = "9999";

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('userId')
            ->andReturn($userId);
        $userServiceMock->shouldReceive('getById')
            ->once()
            ->with($userId)
            ->andReturnNull();
        $next = function () {
        };

        $verifyExistingUser = new VerifyExistingUser($userServiceMock);
        $verifyExistingUser->handle($requestMock, $next);
    }

    /**
     * @covers \App\Http\Middleware\VerifyExistingUser::__construct
     * @covers \App\Http\Middleware\VerifyExistingUser::handle
     */
    public function testVerifyExistingUserDifferentFromLoggedUser()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $user = User::all()->first();
        $this->be($user);

        $requestMock = \Mockery::mock(Request::class);
        $userServiceMock = \Mockery::mock(UserService::class);
        $routeMock = \Mockery::mock(Route::class);
        $userMock = \Mockery::mock(User::class);
        $userId = "1";

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('userId')
            ->andReturn($userId);
        $userServiceMock->shouldReceive('getById')
            ->once()
            ->with($userId)
            ->andReturn($userMock);
        $userMock->shouldReceive('getAttribute')
            ->once()
            ->with('id')
            ->andReturn(9999);
        $next = function () {
        };

        $verifyExistingUser = new VerifyExistingUser($userServiceMock);
        $verifyExistingUser->handle($requestMock, $next);
    }

    /**
     * @covers \App\Http\Middleware\VerifyExistingUser::__construct
     * @covers \App\Http\Middleware\VerifyExistingUser::handle
     */
    public function testVerifyExistingUser()
    {
        $user = User::all()->first();
        $this->be($user);

        $requestMock = \Mockery::mock(Request::class);
        $userServiceMock = \Mockery::mock(UserService::class);
        $routeMock = \Mockery::mock(Route::class);

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('userId')
            ->andReturn($user->id);
        $userServiceMock->shouldReceive('getById')
            ->once()
            ->with($user->id)
            ->andReturn($user);
        $next = function () {
        };

        $verifyExistingUser = new VerifyExistingUser($userServiceMock);
        $verifyExistingUser->handle($requestMock, $next);
    }
}
