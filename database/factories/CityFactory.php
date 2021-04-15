<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = City::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $country = Country::inRandomOrder()->first();
        return [
            'name' => $this->faker->city,
            'state' => $this->faker->state,
            'country_id' => $country->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
