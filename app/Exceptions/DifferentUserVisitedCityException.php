<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class DifferentUserVisitedCityException extends BaseException
{
    /** @var int */
    protected int $httpStatusCode = Response::HTTP_FORBIDDEN;

    /** @var string */
    protected string $title = 'Different user from visited city';

    public static function becauseDifferentUserVisitedCity() : DifferentUserVisitedCityException
    {
        $differentUserException = new  DifferentUserVisitedCityException();
        $differentUserException->setDetail("Invalid user which visited the city");
        return $differentUserException;
    }
}
