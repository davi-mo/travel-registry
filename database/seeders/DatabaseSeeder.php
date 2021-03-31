<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(3)->create();
        \App\Models\GoogleAccount::factory(1)->create();
        \App\Models\Country::factory(10)->create();
        \App\Models\City::factory(10)->create();
        \App\Models\VisitedCities::factory(10)->create();
    }
}
