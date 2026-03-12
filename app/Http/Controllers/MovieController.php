<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function __construct(
        private readonly MovieService $movieService
    ) {}

    public function index(): View
    {
        $movies = $this->movieService->getActivePaginated();

        return view('movies.index', compact('movies'));
    }

    public function show(int $id): View
    {
        $movie = $this->movieService->getActiveDetailsById($id);

        return view('movies.show', [
            'movie' => $movie, 'showTrailer' => $movie->canShowTrailer(),
        ]);
    }
}
