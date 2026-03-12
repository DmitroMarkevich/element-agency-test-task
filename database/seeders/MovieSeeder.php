<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Movie;
use App\Models\Person;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $persons = Person::query()->pluck('id');
        $tags = Tag::query()->pluck('id');

        Movie::factory()->count(24)->active()->create()
            ->each(function (Movie $movie) use ($persons, $tags) {
                $movie->persons()->attach(
                    $persons->random(rand(2, 5))->all()
                );
                $movie->tags()->attach(
                    $tags->random(rand(1, 4))->all()
                );
            });

        Movie::factory()->count(6)->inactive()->create()
            ->each(function (Movie $movie) use ($persons, $tags) {
                $movie->persons()->attach(
                    $persons->random(rand(1, 3))->all()
                );
                $movie->tags()->attach(
                    $tags->random(rand(1, 3))->all()
                );
            });
    }
}
