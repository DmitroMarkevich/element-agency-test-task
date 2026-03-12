@extends('layouts.app')

@section('title', __('messages.movies'))

@section('content')
    <div class="mb-8 flex items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">{{ __('messages.movies') }}</h1>
            <p class="mt-2 text-sm text-zinc-400">{{ __('messages.movies_catalog') }}</p>
        </div>
    </div>

    @if($movies->count())
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($movies as $movie)
                <article class="overflow-hidden rounded-2xl border border-white/10 bg-zinc-900 shadow-lg shadow-black/20">
                    <a href="{{ route('movies.show', $movie->id) }}" class="block">
                        <div class="aspect-[2/3] bg-zinc-800">
                            @if($movie->poster)
                                <img
                                    src="{{ asset($movie->poster) }}"
                                    alt="{{ $movie->title }}"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full items-center justify-center text-sm text-zinc-500">
                                    {{ __('messages.no_poster') }}
                                </div>
                            @endif
                        </div>
                    </a>

                    <div class="p-4">
                        <div class="mb-3 flex items-start justify-between gap-3">
                            <h2 class="line-clamp-2 text-lg font-semibold">
                                <a href="{{ route('movies.show', $movie->id) }}" class="hover:text-red-400">
                                    {{ $movie->title }}
                                </a>
                            </h2>

                            @if($movie->release_year)
                                <span class="shrink-0 rounded-full bg-white/5 px-2.5 py-1 text-xs text-zinc-300">
                                    {{ $movie->release_year }}
                                </span>
                            @endif
                        </div>

                        @if($movie->description)
                            <div class="mb-4 line-clamp-3 text-sm text-zinc-400">
                                {!! strip_tags($movie->description) !!}
                            </div>
                        @endif

                        <a
                            href="{{ route('movies.show', $movie->id) }}"
                            class="inline-flex rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-500"
                        >
                            {{ __('messages.more') }}
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $movies->links() }}
        </div>
    @else
        <div class="rounded-2xl border border-dashed border-white/10 bg-zinc-900 p-10 text-center text-zinc-400">
            {{ __('messages.no_movies') }}
        </div>
    @endif
@endsection
