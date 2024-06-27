<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    public function exampleJsonResponse(): ?string
    {
        return Storage::disk('example_api_responses')->get('/the_movie_db/movie_details.json');

    }

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            //'original_title' => $this->faker->regexify('[A-Za-z0-9]{150}'),
            'original_title' => $this->faker->sentence(6),
            'original:language' => $this->faker->randomLetter(),
            'overview' => $this->faker->text(),
            'popularity' => $this->faker->randomFloat(3, 0, 99999999999999999.999),
            'release_date' => $this->faker->date(),
            'revenue' => $this->faker->randomFloat(3, 0, 99999999999999999.999),
            'runtime' => $this->faker->numberBetween(-10000, 10000),
            'budget' => $this->faker->numberBetween(-10000, 10000),
            'vote_average' => $this->faker->randomFloat(3, 0, 99999999999999999.999),
            'vote_count' => $this->faker->numberBetween(-10000, 10000),
            'json_response' => $this->exampleJsonResponse(),
            'external_id' => $this->faker->numberBetween(-100000, 100000),
        ];
    }
}
