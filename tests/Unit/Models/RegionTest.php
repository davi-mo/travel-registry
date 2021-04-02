<?php

namespace Tests\Unit\Models;

use App\Models\Region;
use Tests\TestCase;

class RegionTest extends TestCase
{
    /**
     * @param int $active
     * @param string $activeCustomized
     *
     * @dataProvider regionsDataProvider
     */
    public function testInactiveRegion(int $active, string $activeCustomized)
    {
        $region = new Region();
        $region->name = "fake-region";
        $region->active = $active;

        $this->assertEquals($activeCustomized, $region->activeCustomized());
    }

    /**
     * @return array[]
     */
    public function regionsDataProvider() : array
    {
        return [
            [0, 'No'],
            [1, 'Yes'],
        ];
    }
}
