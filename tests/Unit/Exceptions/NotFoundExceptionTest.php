<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\NotFoundException;
use Illuminate\Http\Response;
use Tests\TestCase;

class NotFoundExceptionTest extends TestCase
{
    /**
     * @covers \App\Exceptions\NotFoundException::becauseRegionWasNotFound
     */
    public function testBecauseRegionWasNotFound()
    {
        $regionNotFoundException = NotFoundException::becauseRegionWasNotFound("region-fake");

        $this->assertEquals(Response::HTTP_NOT_FOUND,  $regionNotFoundException->getHttpStatusCode());
        $this->assertEquals('Not Found', $regionNotFoundException->getTitle());
        $this->assertEquals('region-fake was not found.', $regionNotFoundException->getDetail());
    }

    /**
     * @covers \App\Exceptions\NotFoundException::becauseRegionIsInvalid
     */
    public function testBecauseRegionIsInvalid()
    {
        $invalidRegionException = NotFoundException::becauseRegionIsInvalid();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $invalidRegionException->getHttpStatusCode());
        $this->assertEquals('Not Found', $invalidRegionException->getTitle());
        $this->assertEquals('The region is invalid', $invalidRegionException->getDetail());
    }

    /**
     * @covers \App\Exceptions\NotFoundException::becauseCountryIsInvalid
     */
    public function testBecauseCountryIsInvalid()
    {
        $invalidCountryException = NotFoundException::becauseCountryIsInvalid();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $invalidCountryException->getHttpStatusCode());
        $this->assertEquals('Not Found', $invalidCountryException->getTitle());
        $this->assertEquals('The country is invalid', $invalidCountryException->getDetail());
    }
}
