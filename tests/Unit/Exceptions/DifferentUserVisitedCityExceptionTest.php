<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\DifferentUserVisitedCityException;
use Illuminate\Http\Response;
use Tests\TestCase;

class DifferentUserVisitedCityExceptionTest extends TestCase
{
    /**
     * @covers \App\Exceptions\DifferentUserVisitedCityException::becauseDifferentUserVisitedCity
     */
    public function testBecauseDifferentUserVisitedCity()
    {
        $differentUserException = DifferentUserVisitedCityException::becauseDifferentUserVisitedCity();

        $this->assertEquals(Response::HTTP_FORBIDDEN, $differentUserException->getHttpStatusCode());
        $this->assertEquals('Different user from visited city', $differentUserException->getTitle());
        $this->assertEquals('Invalid user which visited the city', $differentUserException->getDetail());
    }
}
