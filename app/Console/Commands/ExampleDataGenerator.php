<?php

namespace App\Console\Commands;

use App\Models\ApiEndPoints;
use App\Models\Image;
use App\Models\Movie;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ExampleDataGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-example-data {withSuperUser}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @return int
     */
    public function withSuperUser(): int
    {

        User::factory()->create([
            'name' => config('app.user.super.name'),
            'email' => config('app.user.super.email'),
            'role' => config('app.user.super.role'),
            'email_verified_at' => now(),
            'password' => Hash::make(config('app.user.super.password')),
            'remember_token' => Str::random(10),
        ]);

        return CommandAlias::SUCCESS;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $withSuperUser = (int) $this->argument('withSuperUser');
        if ($withSuperUser === 1) {
            $this->withSuperUser();
        }
        $userRelations = User::factory()
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
