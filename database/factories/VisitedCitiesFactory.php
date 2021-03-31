<?php

namespace Database\Factories;

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
        return [
            'user_id' => rand(1, 3),
            'city_id' => rand(1, 10),
            'visited_at' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
