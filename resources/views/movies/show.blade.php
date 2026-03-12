@extends('layouts.app')

@section('title', $movie->title)

@section('content')
    <div class="mb-6">
        <a href="{{ route('movies.index') }}" class="text-sm text-zinc-400 hover:text-white">
            ← {{ __('messages.back_to_catalog') }}
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-[320px_minmax(0,1fr)]">
        <div>
            <div class="overflow-hidden rounded-2xl border border-white/10 bg-zinc-900">
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
            </div>
        </div>

        <div>
            <div class="mb-4 flex flex-wrap items-center gap-3">
                <h1 class="text-3xl font-bold">{{ $movie->title }}</h1>

                @if($movie->release_year)
                    <span class="rounded-full bg-white/5 px-3 py-1 text-sm text-zinc-300">
                        {{ $movie->release_year }}
                    </span>
                @endif
            </div>

            @if($movie->description)
                <div class="movie-description mt-4 text-zinc-300">
                    {!! $movie->description !!}
                </div>
            @endif

            @if($movie->persons->count())
                <section class="mt-8">
                    <h2 class="mb-4 text-xl font-semibold">{{ __('messages.cast') }}</h2>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($movie->persons as $person)
                            <div class="flex items-center gap-4 rounded-xl border border-white/10 bg-zinc-900 p-4">
                                <div class="h-14 w-14 overflow-hidden rounded-full bg-zinc-800">
                                    @if($person->photo)
                                        <img
                                            src="{{ asset($person->photo) }}"
                                            alt="{{ $person->full_name }}"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-xs text-zinc-500">
                                            {{ __('messages.photo') }}
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <div class="font-medium">
                                        {{ $person->full_name }}
                                    </div>
                                    @if($person->type)
                                        <div class="text-sm text-zinc-400">
                                            {{ $person->type->label() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($movie->tags->count())
                <section class="mt-8">
                    <h2 class="mb-4 text-xl font-semibold">{{ __('messages.tags') }}</h2>

                    <div class="flex flex-wrap gap-2">
                        @foreach($movie->tags as $tag)
                            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-sm text-zinc-300">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>

    @if(!empty($movie->screenshots))
        <section class="mt-12">
            <h2 class="mb-4 text-xl font-semibold">{{ __('messages.screenshots') }}</h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach($movie->screenshots as $screenshot)
                    <div class="overflow-hidden rounded-2xl border border-white/10 bg-zinc-900">
                        <div class="aspect-video bg-zinc-800">
                            <img
                                src="{{ asset($screenshot) }}"
                                alt="{{ $movie->title }}"
                                class="h-full w-full object-cover"
                            >
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if($showTrailer && $movie->youtube_trailer_id)
        <section class="mt-12">
            <h2 class="mb-4 text-xl font-semibold">{{ __('messages.trailer') }}</h2>

            <div class="overflow-hidden rounded-2xl border border-white/10 bg-zinc-900">
                <div class="aspect-video">
                    <iframe
                        class="h-full w-full"
                        src="https://www.youtube.com/embed/{{ $movie->youtube_trailer_id }}"
                        title="{{ $movie->title }}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </section>
    @endif
@endsection
