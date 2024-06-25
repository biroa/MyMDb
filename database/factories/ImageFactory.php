<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'image' => $this->faker->imageUrl(600, 900, null, true, 'MyMDb'),
            'movie_id' => Movie::factory(),
            'is_gif' => $this->faker->boolean(0),
        ];
    }
}
