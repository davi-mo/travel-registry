<?php

namespace Database\Factories;

use App\Models\GoogleAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoogleAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GoogleAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 3),
            'provider_user_id' => '123456789',
            'provider' => 'google',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
