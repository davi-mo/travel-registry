<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use App\Models\VisitedCities;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitedCitiesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VisitedCities::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $city = City::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'city_id' => $city->id,
            'visited_at' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
