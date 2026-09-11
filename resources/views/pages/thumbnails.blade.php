@extends('app')

@section('head')
    <title>Создать миниатюры изображений онлайн бесплатно | Isibia</title>
    <meta name="description" content="Создавайте миниатюры сразу для нескольких изображений JPG, PNG или WebP бесплатно. Задайте до пяти размеров и получите уменьшенные копии каждого изображения.">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="{{ route('images.thumbnails') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:title" content="Создать миниатюры изображений онлайн бесплатно | Isibia">
    <meta property="og:description" content="Создавайте миниатюры сразу для нескольких изображений JPG, PNG или WebP бесплатно. Задайте до пяти размеров и получите уменьшенные копии каждого изображения.">
    <meta property="og:url" content="{{ route('images.thumbnails') }}">
@endsection

@section('content')
    <section class="bg-slate-950 px-4 py-14 text-center text-white sm:py-20">
        <div class="mx-auto max-w-4xl">
            <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-violet-300">
                До пяти миниатюр для каждого загруженного изображения
            </p>
            <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
                Создать миниатюры изображений онлайн
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                Бесплатно создавайте уменьшенные копии фотографий для карточек,
                галерей и превью статей. Загрузите изображения и задайте нужные
                размеры — сервис подготовит все варианты для каждого файла,
                сохраняя пропорции и исходный формат.
            </p>
            <a href="#processor"
            class="mt-8 inline-flex rounded-xl bg-violet-500 px-6 py-3 font-semibold text-white transition hover:bg-violet-400">
                Создать миниатюры
            </a>
        </div>
    </section>

    <section id="processor" aria-label="Инструмент создания миниатюр">
        @inertia
    </section>

    <section id="features" class="bg-white px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-6xl">
            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
                Изображения для разных частей сайта
            </h2>
            <div class="mt-8 grid gap-5 md:grid-cols-3">
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="font-semibold">Основное фото и превью карточки</h3>
                    <p class="mt-2 leading-7 text-slate-600">
                        Подготовьте крупную версию фотографии для страницы товара
                        и компактную — для карточки в каталоге. Добавьте размер
                        для списка рекомендаций и получите все варианты за один
                        запуск, без повторной загрузки оригинала.
                    </p>
                </article>
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="font-semibold">Версии для десктопа и смартфона</h3>
                    <p class="mt-2 leading-7 text-slate-600">
                        Создайте изображения разной ширины для большого
                        и маленького экрана. Готовые файлы можно использовать
                        в адаптивной вёрстке, чтобы браузер загружал подходящую
                        версию вместо одного большого изображения для всех устройств.
                    </p>
                </article>
                <article class="rounded-2xl border border-slate-200 p-6">
                    <h3 class="font-semibold">Набор размеров для всей подборки</h3>
                    <p class="mt-2 leading-7 text-slate-600">
                        Задайте до пяти размеров и примените их сразу ко всем
                        загруженным фотографиям. Это удобно при наполнении каталога
                        или подготовке галереи: для каждого исходного файла
                        вы получите один и тот же набор вариантов.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="bg-slate-100 px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Нужна дополнительная обработка?</h2>
            <p class="mx-auto mt-4 max-w-2xl leading-7 text-slate-600">
                Этот инструмент создаёт только миниатюры. Для уменьшения веса используйте оптимизатор,
                а для одновременного изменения формата и других параметров — полный инструмент.
            </p>
            <div class="mt-7 flex flex-wrap justify-center gap-3">
                <a href="{{ route('images.optimizer') }}"
                    class="rounded-xl bg-violet-600 px-5 py-3 font-semibold text-white hover:bg-violet-500">Оптимизировать
                    для веба</a>
                <a href="{{ route('process-photos.form') }}"
                    class="rounded-xl border border-slate-300 bg-white px-5 py-3 font-semibold hover:border-violet-400">Открыть
                    полный инструмент</a>
            </div>
        </div>
    </section>

    <section id="faq" class="bg-white px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-4xl">
            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
                Вопросы о создании миниатюр
            </h2>
            <div class="mt-8 space-y-4">
                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">
                        Сколько размеров можно создать за один запуск?
                    </summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Можно задать до пяти вариантов ширины и высоты.
                        Каждый вариант применяется ко всем загруженным
                        изображениям. Например, для трёх фотографий и двух
                        заданных размеров получится шесть миниатюр.
                    </p>
                </details>

                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">
                        Будут ли изображения обрезаны или растянуты?
                    </summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Нет. Фотография уменьшается целиком с сохранением
                        исходных пропорций. Содержимое по краям не обрезается,
                        а объекты на изображении не растягиваются.
                    </p>
                </details>

                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">
                        Почему миниатюра может быть меньше заданных размеров?
                    </summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Указанные ширина и высота задают границы, в которые
                        вписывается изображение. Например, из фотографии
                        1200×800 пикселей при настройке 300×300 получится
                        миниатюра 300×200. Получить квадрат без обрезки
                        прямоугольного оригинала таким способом нельзя.
                    </p>
                </details>

                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">
                        Что произойдёт, если оригинал меньше нужной миниатюры?
                    </summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Маленькие изображения не увеличиваются. Если оригинал
                        уже вписывается в заданные границы, его ширина и высота
                        останутся прежними. Для более крупной версии понадобится
                        исходное изображение большего разрешения.
                    </p>
                </details>

                <details class="rounded-2xl border border-slate-200 p-5">
                    <summary class="cursor-pointer font-semibold">
                        В каком формате сохраняются миниатюры?
                    </summary>
                    <p class="mt-3 leading-7 text-slate-600">
                        Миниатюры сохраняют формат исходного изображения:
                        JPG, PNG или WebP. Если нужно одновременно создать
                        уменьшенные копии и изменить формат, используйте
                        <a href="/" class="text-violet-700 underline">полный инструмент обработки изображений</a>.
                    </p>
                </details>
            </div>
        </div>
    </section>
@endsection
