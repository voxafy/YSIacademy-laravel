@php
    $pageTitle = $title ?? config('app.name');
    $flashSuccess = session('success');
    $flashError = session('error');
    $theme = request()->cookie('ysi_theme', 'light');
    $cssVersion = @filemtime(public_path('build/css/app.css')) ?: time();
    $jsVersion = @filemtime(public_path('build/js/app.js')) ?: time();
@endphp
<!DOCTYPE html>
<html lang="ru" data-theme="{{ $theme === 'dark' ? 'dark' : 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset_url('css/app.css') }}?v={{ $cssVersion }}">
</head>
<body>
    @include('partials.header')

    <main class="page-shell">
        <div class="container">
            @if ($flashSuccess || $flashError)
                <div class="flash-stack">
                    @if ($flashSuccess)
                        <div class="flash flash-success">{{ $flashSuccess }}</div>
                    @endif
                    @if ($flashError)
                        <div class="flash flash-error">{{ $flashError }}</div>
                    @endif
                </div>
            @endif

            @include($pageView)
        </div>
    </main>

    <script src="{{ asset_url('js/app.js') }}?v={{ $jsVersion }}"></script>
</body>
</html>
