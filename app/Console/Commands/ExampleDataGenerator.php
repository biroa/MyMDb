<?php

namespace App\Console\Commands;

use App\Models\ApiEndPoints;
use App\Models\Image;
use App\Models\Movie;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ExampleDataGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-example-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $userRelations = User::factory()->admin()
            ->has(Movie::factory()
                ->count(3))
            ->has(Provider::factory()
                ->count(2))
            ->has(ApiEndPoints::factory()
                ->count(2))
            ->create();

        $userRelations->each(function ($user) {
            $user->movies->each(function ($movie) {
                $movie->images()->saveMany(Image::factory()->count(5)->make());
            });
        });

        $this->info('Example data generated successfully!');

        return CommandAlias::SUCCESS;
    }
}
