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
}
