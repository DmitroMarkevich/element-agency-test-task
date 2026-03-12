@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Movies')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-[Montserrat] min-h-screen bg-zinc-950 text-white">
<header class="border-b border-white/10 bg-zinc-900/80 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-2">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                       class="rounded-md border px-3 py-1.5 text-sm transition
                       {{ app()->getLocale() === $localeCode
                            ? 'border-red-500 bg-red-600 text-white'
                            : 'border-white/10 hover:bg-white/5' }}">
                        {{ strtoupper($localeCode) }}
                    </a>

                @endforeach
            </div>
        </div>
    </div>
</header>

<main class="mx-auto max-w-7xl px-6 py-8">
    @yield('content')
</main>
</body>
</html>
