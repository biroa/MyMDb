<?php

namespace Database\Factories;

use App\Models\ApiEndPoints;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApiEndPointsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApiEndPoints::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'provider_id' => Provider::factory(),
            'api_end_point' => $this->faker->url(),
            'query_params' => implode(['?param=', $this->faker->word]),
            'status' => $this->faker->randomElement(['called', 'returned', 'processed']),
            'status_msg' => $this->faker->word(),
        ];
    }
}
