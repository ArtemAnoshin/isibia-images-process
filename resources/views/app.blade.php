@php
    $isPublicHome = request()->routeIs('process-photos.form');
    $isOptimizerPage = request()->routeIs('images.optimizer');
    $isConverterPage = request()->routeIs('images.converter');
    $isThumbnailsPage = request()->routeIs('images.thumbnails');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function(m,e,t,r,i,k,a){
                m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();
                for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
                k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
            })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=110958877', 'ym');

            ym(110958877, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/110958877" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        @if ($isPublicHome)
            <title inertia>Пакетная обработка изображений онлайн — JPG, PNG, WebP | Isibia</title>
            <meta name="description" content="Обрабатывайте изображения онлайн пакетно: изменяйте размер и формат JPG, PNG и WebP, оптимизируйте фотографии для сайта и создавайте миниатюры.">
            <meta name="robots" content="index,follow">
            <link rel="canonical" href="{{ url('/') }}">
            <meta property="og:type" content="website">
            <meta property="og:locale" content="ru_RU">
            <meta property="og:title" content="Пакетная обработка изображений онлайн | Isibia">
            <meta property="og:description" content="Изменяйте размер и формат изображений, оптимизируйте их для сайта и создавайте миниатюры пакетно.">
            <meta property="og:url" content="{{ url('/') }}">
        @elseif ($isOptimizerPage)
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
        @else
            <title inertia>{{ config('app.name', 'Laravel') }}</title>
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
        @if ($isPublicHome)
            @include('pages.partials.process-photos-seo-shell')
        @elseif ($isOptimizerPage)
            @include('pages.partials.image-optimizer-seo-shell')
        @elseif ($isConverterPage)
            @include('pages.partials.convert-images-seo-shell')
        @elseif ($isThumbnailsPage)
            @include('pages.partials.create-thumbnails-seo-shell')
        @else
            @inertia
        @endif
    </body>
</html>
