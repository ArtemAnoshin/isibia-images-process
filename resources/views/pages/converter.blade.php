@extends('app')

@section('head')
    <title>Конвертер изображений онлайн — JPG, PNG, WebP | Isibia</title>
    <meta name="description" content="Изменяйте формат сразу нескольких изображений бесплатно. Самые популярные форматы для веба: JPG, PNG и WebP.">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="{{ route('images.converter') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:title" content="Конвертер изображений онлайн бесплатно — JPG, PNG, WebP | Isibia">
    <meta property="og:description" content="Изменяйте формат сразу нескольких изображений бесплатно. Самые популярные форматы для веба: JPG, PNG и WebP.">
    <meta property="og:url" content="{{ route('images.converter') }}">
@endsection

@section('content')
    <section class="bg-slate-950 px-4 py-14 text-center text-white sm:py-20">
        <div class="mx-auto max-w-4xl">
            <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-violet-300">
                Бесплатная конвертация в JPG, PNG и WebP
            </p>
            <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
                Изменить формат изображений онлайн
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                Загрузите изображения и выберите формат результата.
                Сервис конвертирует сразу несколько файлов, сохраняя
                исходную ширину и высоту в пикселях.
            </p>
            <a href="#processor"
                class="mt-8 inline-flex rounded-xl bg-violet-500 px-6 py-3 font-semibold text-white transition hover:bg-violet-400">
                Выбрать изображения
            </a>
        </div>
    </section>

    <section id="processor" aria-label="Конвертер форматов изображений">
        @inertia
    </section>

    <section id="features" class="bg-white px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-6xl">
            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
                Какой формат изображения выбрать
            </h2>
            <div class="mt-8 grid gap-5 md:grid-cols-3">
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold">JPG / JPEG — для фотографий</h3>
                    <p class="mt-2 leading-7 text-slate-600">
                        Подходит для фотографий, изображений товаров и иллюстраций
                        с плавными переходами цвета. Позволяет уменьшить вес файла,
                        но может снижать детализацию.
                        Не поддерживает прозрачность. JPG и JPEG — два расширения
                        одного формата.
                    </p>
                </article>
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold">PNG — для графики и прозрачного фона</h3>
                    <p class="mt-2 leading-7 text-slate-600">
                        Подходит для скриншотов, схем и графики с текстом
                        и чёткими границами. Поддерживает прозрачность и сжатие
                        без потерь. Фотографии в PNG часто весят больше,
                        чем в JPG. При этом перевод в PNG не восстанавливает
                        детали, утраченные при предыдущем сжатии.
                    </p>
                </article>
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold">WebP — для изображений на сайте</h3>
                    <p class="mt-2 leading-7 text-slate-600">
                        Подходит для фотографий и графики, в том числе
                        с прозрачным фоном. Поддерживает сжатие с потерями
                        и без потерь. Может уменьшить вес изображений
                        по сравнению с JPG или PNG, но итоговый размер
                        зависит от содержимого файла и параметров конвертации.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="bg-slate-100 px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Нужно подготовить изображения для сайта?</h2>
            <p class="mx-auto mt-4 max-w-2xl leading-7 text-slate-600">
                Конвертер изменяет только формат. Чтобы дополнительно уменьшить вес и ограничить разрешение
                до 1920×1080, а также настроить миниатюры, используйте полный инструмент.
            </p>
            <div class="mt-7 flex flex-wrap justify-center gap-3">
                <a href="{{ route('process-photos.form') }}"
                    class="rounded-xl border border-slate-300 bg-white px-5 py-3 font-semibold hover:border-violet-400">Открыть
                    полный инструмент</a>
            </div>
        </div>
    </section>

    <section id="faq" class="bg-white px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-4xl">
            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
                Вопросы об изменении формата
            </h2>
            <div class="mt-8 space-y-4">
                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">
                        Можно ли изменить формат нескольких изображений сразу?
                    </summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Да. Загрузите изображения и выберите формат результата —
                        JPG, PNG или WebP. Он будет применён ко всей группе.
                        Если нужны файлы в разных форматах, запустите конвертацию
                        отдельно для каждого формата.
                    </p>
                </details>

                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">
                        Изменятся ли размеры изображения в пикселях?
                    </summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Нет, исходная ширина и высота сохраняются.
                        Чтобы одновременно изменить формат и уменьшить
                        изображение, воспользуйтесь
                        <a href="/" class="text-violet-700 underline">полным инструментом обработки</a>.
                    </p>
                </details>

                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">
                        Станет ли файл меньше после конвертации?
                    </summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Не обязательно. Вес файла зависит от исходного изображения,
                        выбранного формата и параметров кодирования.
                        После конвертации он может как уменьшиться, так и увеличиться.
                        Если нужно сжать фото и ограничить его размеры для публикации,
                        используйте
                        <a href="/image-optimizer" class="text-violet-700 underline">оптимизатор изображений для сайта</a>.
                    </p>
                </details>

                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">
                        Может ли измениться качество изображения?
                    </summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Да. При сохранении в JPG или WebP со сжатием с потерями
                        часть деталей может быть утрачена. PNG использует сжатие
                        без потерь, но перевод в этот формат не восстанавливает
                        качество, потерянное ранее. Сохранение размеров в пикселях
                        не гарантирует, что изображение останется полностью неизменным.
                    </p>
                </details>

                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">
                        Что произойдёт с прозрачным фоном при переводе в JPG?
                    </summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        JPG не поддерживает прозрачность, поэтому прозрачные
                        участки перестанут быть прозрачными. Если она нужна
                        для размещения изображения на цветном фоне сайта,
                        выбирайте формат с поддержкой прозрачности — PNG или WebP.
                    </p>
                </details>
            </div>
        </div>
    </section>
@endsection
