<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\BaseException;
use Illuminate\Http\Response;
use Tests\TestCase;

class BaseExceptionTest extends TestCase
{
    /**
     * @covers \App\Exceptions\BaseException::__construct
     */
    public function testConstruct()
    {
        $baseException = new BaseException('unit-test-exception-message');
        $this->assertInstanceOf(BaseException::class, $baseException);
        $this->assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $baseException->getHttpStatusCode());
    }

    /**
     * @covers \App\Exceptions\BaseException::__construct
     */
    public function testConstructWithDefaultParameters()
    {
        $baseException = new BaseException();
        $this->assertInstanceOf(BaseException::class, $baseException);
        $this->assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $baseException->getHttpStatusCode());
    }

    /**
     * @covers \App\Exceptions\BaseException::getDetail
     * @covers \App\Exceptions\BaseException::setDetail
     */
    public function testGetDetailAndSetDetail()
    {
        $baseException = \Mockery::mock(BaseException::class, [
            'unit-test-exception-message',
        ])->makePartial();

        $baseException->setDetail('unit-test-exception-message');

        $this->assertSame('unit-test-exception-message', $baseException->getDetail());
        $this->assertSame('unit-test-exception-message', $baseException->getMessage());
    }

    /**
     * @covers \App\Exceptions\BaseException::getHttpStatusCode()
     */
    public function testGetHttpStatusCode()
    {
        $baseException = \Mockery::mock(BaseException::class, [
            'Something went wrong',
        ])->makePartial();

        $baseException->setHttpStatusCode(Response::HTTP_ACCEPTED);

        $this->assertSame(Response::HTTP_ACCEPTED, $baseException->getHttpStatusCode());
    }

    /**
     * @covers \App\Exceptions\BaseException::setHttpStatusCode()
     */
    public function testSetHttpStatusCode()
    {
        $baseException = \Mockery::mock(BaseException::class, [
            'Something went wrong',
        ])->makePartial();

        $baseException->setHttpStatusCode(Response::HTTP_BAD_REQUEST);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $baseException->getHttpStatusCode());
        $this->assertSame(Response::HTTP_BAD_REQUEST, $baseException->getCode());
    }

    /**
     * @covers \App\Exceptions\BaseException::getTitle()
     */
    public function testGetTitle()
    {
        $baseException = \Mockery::mock(BaseException::class, [
            'Something went wrong',
        ])->makePartial();

        $this->assertSame('Something went wrong', $baseException->getTitle());
    }
}
