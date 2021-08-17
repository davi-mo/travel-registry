<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * @covers \App\Http\Controllers\UserController::getUser
     */
    public function testGetUser()
    {
        $userMock = \Mockery::mock(User::class);

        $this->be($userMock);

        $userController = \Mockery::mock(UserController::class)->makePartial();
        $response = $userController->getUser();
        $this->assertInstanceOf(View::class, $response);
        $this->assertContains($userMock, $response->getData());
    }

    /**
     * @covers \App\Http\Controllers\UserController::updateUser
     */
    public function testUpdateUser()
    {
        $userId = "1";
        $name = "name";
        $userServiceMock = \Mockery::mock(UserService::class);
        $requestMock = \Mockery::mock(Request::class);
        $userMock = \Mockery::mock(User::class);

        $userServiceMock->shouldReceive('getById')
            ->once()
            ->with($userId)
            ->andReturn($userMock);

        $requestMock->shouldReceive('get')
            ->once()
            ->with('name')
            ->andReturn($name);
        $userServiceMock->shouldReceive('updateUser')
            ->once()
            ->with($userMock, $name)
            ->andReturnNull();

        $userController = \Mockery::mock(UserController::class)->makePartial();
        $response = $userController->updateUser(
            $userId,
            $requestMock,
            $userServiceMock
        );

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
