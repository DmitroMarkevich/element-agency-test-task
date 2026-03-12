<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startAt = fake()->optional(0.7)->dateTimeBetween('-1 month', '+1 month');
        $endAt = $startAt
            ? fake()->optional(0.7)->dateTimeBetween($startAt, '+2 months')
            : fake()->optional(0.5)->dateTimeBetween('now', '+2 months');

        return [
            'active' => fake()->boolean(85),
            'title_uk' => Str::limit(fake()->unique()->sentence(2), 255, ''),
            'title_en' => Str::limit(fake()->unique()->sentence(2), 255, ''),
            'description_uk' => fake()->optional(0.9)->paragraphs(3, true),
            'description_en' => fake()->optional(0.9)->paragraphs(3, true),
            'poster' => null,
            'screenshots' => [],
            'youtube_trailer_id' => 'S5KiC0GgED0',
            'release_year' => fake()->optional(0.9)->numberBetween(1980, now()->year + 1),
            'view_start_at' => $startAt,
            'view_end_at' => $endAt,
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'active' => false,
        ]);
    }

    public function withTrailer(): static
    {
        return $this->state(fn () => [
            'youtube_trailer_id' => fake()->regexify('[A-Za-z0-9_-]{11}'),
        ]);
    }

    public function withoutTrailer(): static
    {
        return $this->state(fn () => [
            'youtube_trailer_id' => null,
        ]);
    }
}
