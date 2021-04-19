<?php

namespace Tests\Unit\Models;

use App\Models\VisitedCities;
use Tests\TestCase;

class VisitedCityTest extends TestCase
{
    /**
     * @param string $expectedResult
     * @param string|null $visitedAt
     * @dataProvider visitedAtDataProvider
     * @covers \App\Models\VisitedCities::formattedVisitedAt
     */
    public function testFormattedVisitedAt(string $expectedResult, ?string $visitedAt = null)
    {
        $visitedCity = new VisitedCities();
        $visitedCity->visited_at = $visitedAt;

        $this->assertEquals($expectedResult, $visitedCity->formattedVisitedAt());
    }

    /**
     * @return array[]
     */
    public function visitedAtDataProvider() : array
    {
        return [
            [""],
            ['30-01-2020', "2020-01-30"],
        ];
    }
}
