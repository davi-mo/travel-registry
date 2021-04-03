<?php

namespace Tests\Unit\Services;

use App\Services\RestCityService;
use Tests\TestCase;

class RestCityServiceTest extends TestCase
{
    /**
     * @covers \App\Services\RestCityService::getCities
     */
    public function testGetCountries()
    {
        $restCityService = new RestCityService();
        $data = $restCityService->getCities();
        $this->assertNotNull($data);
        $this->assertFalse($data['error']);
    }
}
