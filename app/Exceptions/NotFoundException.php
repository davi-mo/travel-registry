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

    public static function becauseCountryIsInvalid() : NotFoundException
    {
        $invalidCountry = new NotFoundException();
        $invalidCountry->setDetail("The country is invalid");
        return $invalidCountry;
    }

    public static function becauseCityIsInvalid() : NotFoundException
    {
        $invalidCity = new NotFoundException();
        $invalidCity->setDetail("The city is invalid");
        return $invalidCity;
    }

    public static function becauseVisitedCityIsInvalid() : NotFoundException
    {
        $invalidVisitedCity = new NotFoundException();
        $invalidVisitedCity->setDetail("The visited city is invalid");
        return $invalidVisitedCity;
    }

    public static function becauseUserIsInvalid() : NotFoundException
    {
        $invalidUser = new NotFoundException();
        $invalidUser->setDetail("The user is invalid");
        return $invalidUser;
    }
}
