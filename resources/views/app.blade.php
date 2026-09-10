@php
    $isOptimizerPage = request()->routeIs('images.optimizer');
    $isConverterPage = request()->routeIs('images.converter');
    $isThumbnailsPage = request()->routeIs('images.thumbnails');
@endphp

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {!! config('yandex.metrika') !!}

        @yield('head')

        @if ($isOptimizerPage)
            <title inertia>Оптимизация изображений для сайта онлайн | Isibia</title>
            <meta name="description" content="Оптимизируйте изображения для сайта онлайн: уменьшайте вес файлов без заметной потери качества и ограничивайте разрешение до 1920×1080 пикселей.">
            <meta name="robots" content="index,follow">
            <link rel="canonical" href="{{ route('images.optimizer') }}">
            <meta property="og:type" content="website">
            <meta property="og:locale" content="ru_RU">
            <meta property="og:title" content="Оптимизация изображений для сайта онлайн | Isibia">
            <meta property="og:description" content="Подготовьте изображения для веба: оптимальное сжатие и максимальное разрешение 1920×1080 пикселей.">
            <meta property="og:url" content="{{ route('images.optimizer') }}">
        @elseif ($isConverterPage)
            <title inertia>Конвертер изображений онлайн — JPG, PNG и WebP | Isibia</title>
            <meta name="description" content="Изменяйте формат изображений онлайн пакетно. Конвертируйте несколько файлов в JPEG, PNG или WebP без установки программ.">
            <meta name="robots" content="index,follow">
            <link rel="canonical" href="{{ route('images.converter') }}">
            <meta property="og:type" content="website">
            <meta property="og:locale" content="ru_RU">
            <meta property="og:title" content="Конвертер изображений онлайн — JPG, PNG и WebP | Isibia">
            <meta property="og:description" content="Выберите целевой формат и конвертируйте несколько изображений за один запуск.">
            <meta property="og:url" content="{{ route('images.converter') }}">
        @elseif ($isThumbnailsPage)
            <title inertia>Создать миниатюры изображений онлайн | Isibia</title>
            <meta name="description" content="Создавайте миниатюры изображений онлайн пакетно. Укажите до пяти вариантов ширины и высоты и получите готовые уменьшенные копии JPG, PNG или WebP.">
            <meta name="robots" content="index,follow">
            <link rel="canonical" href="{{ route('images.thumbnails') }}">
            <meta property="og:type" content="website">
            <meta property="og:locale" content="ru_RU">
            <meta property="og:title" content="Создать миниатюры изображений онлайн | Isibia">
            <meta property="og:description" content="Создайте несколько размеров миниатюр сразу для целого набора изображений.">
            <meta property="og:url" content="{{ route('images.thumbnails') }}">
        @endif

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        <div class="relative z-10 w-full text-slate-900" data-public-home>
            @include('template-parts.header')

            <main>
                @yield('content')
            </main>

            @include('template-parts.footer')
        </div>

        @if ($isOptimizerPage)
            @include('pages.partials.image-optimizer-seo-shell')
        @elseif ($isConverterPage)
            @include('pages.partials.convert-images-seo-shell')
        @elseif ($isThumbnailsPage)
            @include('pages.partials.create-thumbnails-seo-shell')
        @endif
    </body>
</html>
