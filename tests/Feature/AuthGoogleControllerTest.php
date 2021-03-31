<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;

class AuthGoogleControllerTest extends TestCase
{
    /**
     * @covers \App\Http\Controllers\AuthGoogleController::redirectToProvider
     */
    public function testLoginFound()
    {
        $response = $this->get(route('login'));
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    /**
     * @covers \App\Http\Controllers\AuthGoogleController::handleProviderCallback
     */
    public function testCallback()
    {
        $abstractUser = \Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')
            ->andReturn(123456789)
            ->shouldReceive('getEmail')
            ->andReturn('test@test.com')
            ->shouldReceive('getNickname')
            ->andReturn('nickname')
            ->shouldReceive('getName')
            ->andReturn('Test testing');

        $provider = \Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get(route('callback'));
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }
}
