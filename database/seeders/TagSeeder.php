<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Action',
            'Drama',
            'Comedy',
            'Thriller',
            'Sci-Fi',
            'Fantasy',
            'Adventure',
            'Crime',
            'Romance',
            'Mystery',
            'Historical',
            'Family',
            'Horror',
            'Biography',
        ];

        foreach ($tags as $tagName) {
            Tag::query()->firstOrCreate(
                ['slug' => Str::slug($tagName)],
                ['name' => $tagName]
            );
        }
    }
}
