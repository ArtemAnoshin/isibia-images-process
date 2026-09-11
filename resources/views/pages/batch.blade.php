@extends('app')

@section('head')
    <title>Пакетная обработка фото онлайн бесплатно | Isibia</title>
    <meta name="description" content="Бесплатная пакетная обработка фото онлайн. Изменяйте размер, конвертируйте в JPG, PNG и WebP, создавайте миниатюры за один запуск в Isibia.">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="{{ url('/') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:title" content="Пакетная обработка фото онлайн бесплатно | Isibia">
    <meta property="og:description" content="Бесплатная пакетная обработка фото онлайн. Изменяйте размер, конвертируйте в JPG, PNG и WebP, создавайте миниатюры за один запуск в Isibia.">
    <meta property="og:url" content="{{ url('/') }}">
@endsection

@section('content')
    <section class="bg-slate-950 px-4 py-14 text-center text-white sm:py-20">
        <div class="mx-auto max-w-4xl">
            <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-violet-300">
                Онлайн-инструмент для сайтов и контентных проектов
            </p>
            <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
                Пакетная обработка фото онлайн
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                Изменяйте размер и формат, создавайте миниатюры за один запуск. Применяйте выбранные настройки сразу к 10 фотографиям JPG, PNG или WebP — бесплатно.
            </p>
            <a href="#processor"
                class="mt-8 inline-flex rounded-xl bg-violet-500 px-6 py-3 font-semibold text-white transition hover:bg-violet-400">
                Обработать фотографии
            </a>
        </div>
    </section>

    <section id="processor" aria-label="Инструмент обработки изображений">
        @inertia
    </section>

    <section id="features" class="bg-white px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-6xl">
            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl mb-4">Инструменты для обработки фото</h2>
            <p class="text-gray-600">Выберите отдельный инструмент или измените размер и формат, а также создайте миниатюры сразу нескольких фото за один запуск.</p>
            <div class="mt-8 grid gap-5 md:grid-cols-3">
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold">
                        <a
                            href="{{ route('images.optimizer') }}"
                            class="hover:text-violet-700">
                            Оптимизировать фото для сайта
                        </a>
                    </h3>
                    <p class="mt-2 leading-7 text-slate-600">Уменьшайте вес и разрешение фотографий перед публикацией на сайте.
                        Применяйте одинаковые настройки сразу к нескольким изображениям, чтобы подготовить их для статей,
                        карточек товаров и галерей. Пакетная обработка избавляет от необходимости настраивать каждый файл вручную.</p>
                    <a href="{{ route('images.optimizer') }}" class="mt-4 inline-flex font-semibold text-violet-700">
                        Открыть инструмент →
                    </a>
                </article>
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold">
                        <a href="{{ route('images.converter') }}"
                            class="hover:text-violet-700">
                            Изменить формат фото
                        </a>
                    </h3>
                    <p class="mt-2 leading-7 text-slate-600">Конвертируйте изображения в JPEG, PNG или WebP онлайн.
                        Выберите формат результата и примените его ко всей группе файлов за один запуск. Это удобно,
                        когда фотографии для публикации приходят из разных источников и их нужно привести к единому формату.</p>
                    <a href="{{ route('images.converter') }}" class="mt-4 inline-flex font-semibold text-violet-700">
                        Открыть инструмент →
                    </a>
                </article>
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold">
                        <a href="{{ route('images.thumbnails') }}"
                            class="hover:text-violet-700">
                            Создать миниатюры изображений
                        </a>
                    </h3>
                    <p class="mt-2 leading-7 text-slate-600">Создавайте уменьшенные версии фотографий для превью статей,
                        карточек и списков на сайте. Задайте несколько размеров миниатюр и получите нужные варианты
                        для каждого загруженного изображения за одну обработку. Не придётся повторять операцию отдельно для каждого размера.</p>
                    <a href="{{ route('images.thumbnails') }}"
                        class="mt-4 inline-flex font-semibold text-violet-700">
                        Открыть инструмент →
                    </a>
                </article>
            </div>
        </div>
    </section>

    <section id="faq" class="bg-white px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-4xl">
            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Частые вопросы</h2>
            <div class="mt-8 space-y-4">
                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">Можно ли одновременно изменить размер, формат и создать миниатюры?</summary>
                    <p class="mt-3 leading-7 text-slate-600">Да. Вы можете совместить эти операции за один запуск. Например, уменьшить фотографии,
                        перевести их в WebP и подготовить миниатюры нужных размеров для каждого файла.</p>
                </details>
                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">Ко всем фотографиям применяются одинаковые настройки?</summary>
                    <p class="mt-3 leading-7 text-slate-600">Да, выбранные параметры применяются ко всей загруженной группе.
                        Если для части фотографий нужны другие настройки, обработайте их отдельно.</p>
                </details>
                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">Сохраняются ли пропорции фотографий при уменьшении?</summary>
                    <p class="mt-3 leading-7 text-slate-600">Да. При ограничении максимального разрешения фотографии уменьшаются с сохранением пропорций.
                        Итоговые ширина и высота зависят от исходного изображения и заданных ограничений.</p>
                </details>
                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">Можно ли создать несколько миниатюр для каждой фотографии?</summary>
                    <p class="mt-3 leading-7 text-slate-600">Да. Укажите несколько размеров миниатюр — сервис подготовит
                        соответствующие версии для каждого загруженного изображения за одну обработку.</p>
                </details>
                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">Обработка фотографий бесплатная?</summary>
                    <p class="mt-3 leading-7 text-slate-600">Да, сервис бесплатный. За один запуск можно обработать до 10 фотографий.</p>
                </details>
            </div>
        </div>
    </section>
@endsection
