<?php

namespace Tests\Unit\Services;

use App\Services\RestCountryService;
use Tests\TestCase;

class RestCountryServiceTest extends TestCase
{
    public function testGetCountries()
    {
        $restCountryService = new RestCountryService();
        $data = $restCountryService->getCountries("Oceania");
        $this->assertNotNull($data);
    }
}
