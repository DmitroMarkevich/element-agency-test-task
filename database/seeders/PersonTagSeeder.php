<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::query()->pluck('id');

        Person::query()->each(function (Person $person) use ($tags) {
            $person->tags()->syncWithoutDetaching(
                $tags->random(rand(1, 3))->all()
            );
        });
    }
}
