<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\View\View;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * @covers \App\Http\Controllers\HomeController::home
     */
    public function testHomePage()
    {
        $homeController = new HomeController();
        $result = $homeController->home();
        $this->assertEquals("home", $result->name());
        $this->assertInstanceOf(View::class, $result);
    }
}
