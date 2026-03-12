<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Movie extends Model
{
    use CrudTrait, HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'active',
        'title_uk',
        'title_en',
        'description_uk',
        'description_en',
        'poster',
        'screenshots',
        'youtube_trailer_id',
        'release_year',
        'view_start_at',
        'view_end_at',
    ];

    /**
     * @return array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'screenshots' => 'array',
        'view_start_at' => 'datetime',
        'view_end_at' => 'datetime',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'movie_tag');
    }

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'movie_person');
    }

    public function getTitleAttribute(): string
    {
        return $this->{'title_' . app()->getLocale()};
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->{'description_' . app()->getLocale()};
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeWithDetails(Builder $query): Builder
    {
        return $query->with(['persons', 'tags']);
    }

    public function hasTrailer(): bool
    {
        return filled($this->youtube_trailer_id);
    }
    public function isAvailableForViewing(): bool
    {
        $now = now();

        $hasStarted = is_null($this->view_start_at) || $now->greaterThanOrEqualTo($this->view_start_at);
        $hasNotEnded = is_null($this->view_end_at) || $now->lessThanOrEqualTo($this->view_end_at);

        return $hasStarted && $hasNotEnded;
    }

    public function canShowTrailer(): bool
    {
        return $this->hasTrailer() && $this->isAvailableForViewing();
    }
}
