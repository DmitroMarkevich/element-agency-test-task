<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieService
{
    private const DEFAULT_PER_PAGE = 12;

    public function getActivePaginated(int $perPage = self::DEFAULT_PER_PAGE): LengthAwarePaginator
    {
        return Movie::query()
            ->active()
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function getActiveDetailsById(int $id): Movie
    {
        return Movie::query()
            ->active()
            ->withDetails()
            ->findOrFail($id);
    }
}
