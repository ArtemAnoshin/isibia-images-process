@extends('app')

@section('head')
    <title>Сжатие фото для сайта онлайн бесплатно | Isibia</title>
    <meta name="description" content="Уменьшайте вес фотографий для сайта онлайн бесплатно. Автоматическое сжатие и ограничение максимального размера до 1920×1080 пикселей с сохранением пропорций.">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="{{ route('images.optimizer') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:title" content="Сжатие фото для сайта онлайн бесплатно | Isibia">
    <meta property="og:description" content="Уменьшайте вес фотографий для сайта онлайн бесплатно. Автоматическое сжатие и ограничение максимального размера до 1920×1080 пикселей с сохранением пропорций.">
    <meta property="og:url" content="{{ route('images.optimizer') }}">
@endsection

@section('content')
    <section class="bg-slate-950 px-4 py-14 text-center text-white sm:py-20">
        <div class="mx-auto max-w-4xl">
            <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-violet-300">Для статей, карточек товаров и галерей</p>
            <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">Сжатие фото для сайта бесплатно</h1>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                Уменьшайте вес сразу нескольких фотографий онлайн.
                Сервис автоматически сожмёт изображения и ограничит их размер
                до 1920×1080 пикселей с сохранением пропорций.
                Просто загрузите файлы — настраивать параметры не нужно.
            </p>
            <a href="#processor"
                class="mt-8 inline-flex rounded-xl bg-violet-500 px-6 py-3 font-semibold text-white transition hover:bg-violet-400">Сжать фото</a>
        </div>
    </section>

    <section id="processor" aria-label="Инструмент оптимизации изображений для сайта">
        @inertia
    </section>

    <section id="features" class="bg-white px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-6xl">
            <h2 class="mt-3 max-w-3xl text-2xl font-bold tracking-tight sm:text-3xl">Почему фото нужно сжимать</h2>
            <div class="mt-8 grid gap-5 md:grid-cols-3">
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="font-semibold">Чтобы страницы загружались быстрее</h3>
                    <p class="mt-2 leading-7 text-slate-600">
                        Фотографии могут составлять значительную часть веса страницы.
                        Чем меньше весят файлы, тем меньше данных нужно загрузить посетителю. Это особенно
                        полезно для каталогов, галерей и статей с большим количеством изображений.</p>
                </article>
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="font-semibold">Чтобы экономить мобильный трафик</h3>
                    <p class="mt-2 leading-7 text-slate-600">
                        Сжатые фотографии требуют меньше трафика при просмотре сайта со смартфона.
                        При медленном или нестабильном соединении посетителям проще дождаться загрузки изображений
                        и познакомиться с содержимым страницы.</p>
                </article>
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="font-semibold">Чтобы экономить место на сервере</h3>
                    <p class="mt-2 leading-7 text-slate-600">
                        Чем больше фотографий на сайте, тем больше места занимает медиатека. Уменьшение веса
                        файлов помогает сократить объём хранимых изображений и резервных копий. Это
                        полезно для проектов, где регулярно публикуют новые материалы или добавляют товары.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="faq" class="bg-white px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-4xl">
            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Вопросы о сжатии изображений</h2>
            <div class="mt-8 space-y-4">
                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">Изменится ли качество фотографий после сжатия?</summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Если вы будете использовать фотографии на сайте, то изменение качества не будет незаметным.
                        Уменьшение веса происходит за счёт сжатия без потерь и ограничения максимального размера до 1920×1080 пикселей.
                    </p>
                </details>
                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">Почему размеры ограничены 1920 на 1080 пикселов?</summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Это выбранный предел для быстрой подготовки фотографий к публикации.
                        1920 на 1080 пикселей достаточно для многих изображений в статьях,
                        карточках товаров и галереях. Более крупные фотографии могут добавлять
                        лишний вес, если на странице отображаются в меньшем размере. Если ваши фотографии меньшего размера,
                        то они не будут увеличены и останутся без изменений.
                    </p>
                </details>
                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">Можно ли изменить степень сжатия или максимальный размер?</summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        На этой странице параметры заданы автоматически. Чтобы самостоятельно
                        настроить сжатие, указать другой размер или создать миниатюры,
                        откройте
                        <a href="/" class="text-violet-700 underline">
                            полный инструмент обработки изображений</a>.
                    </p>
                </details>
                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">
                        Можно ли сжать несколько фотографий одновременно?
                    </summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Да, загрузите несколько изображений JPG, PNG или WebP и запустите
                        обработку. Сервис применит одинаковые параметры ко всей группе,
                        чтобы вам не пришлось обрабатывать каждый файл отдельно.
                    </p>
                </details>
            </div>
            <p class="mt-8 text-center text-slate-600">
                Хотите выбрать параметры вручную? <a href="{{ route('process-photos.form') }}"
                    class="font-semibold text-violet-700">Откройте полный инструмент</a>.
            </p>
        </div>
    </section>
@endsection
