<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class NotFoundException extends BaseException
{
    /** @var int */
    protected int $httpStatusCode = Response::HTTP_NOT_FOUND;

    /** @var string */
    protected string $title = 'Not Found';

    public static function becauseRegionWasNotFound(string $regionName) : NotFoundException
    {
        $regionNotFound = new NotFoundException();
        $regionNotFound->setDetail("$regionName was not found.");
        return $regionNotFound;
    }

    public static function becauseRegionIsInvalid() : NotFoundException
    {
        $invalidRegion = new NotFoundException();
        $invalidRegion->setDetail("The region is invalid");
        return $invalidRegion;
    }
}
