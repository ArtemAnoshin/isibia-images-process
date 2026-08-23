<div class="relative z-10 w-full text-slate-900" data-public-home>
    <header class="border-b border-white/10 bg-slate-950/85 text-white backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-4 py-4">
            <a href="{{ route('process-photos.form') }}" class="text-lg font-bold tracking-tight">
                Isibia <span class="text-violet-300">Process Images</span>
            </a>
            <nav aria-label="Основная навигация" class="flex items-center gap-5 text-sm">
                @include('pages.partials.tools-dropdown')
                <a href="#processor" class="hover:text-violet-300">Оптимизатор</a>
                <a href="#faq" class="hidden hover:text-violet-300 sm:inline">Вопросы</a>
                <a href="{{ route('about-developer-page') }}" class="hidden hover:text-violet-300 sm:inline">О разработчике</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="bg-slate-950 px-4 py-14 text-center text-white sm:py-20">
            <div class="mx-auto max-w-4xl">
                <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-violet-300">Быстрые изображения для веб-проектов</p>
                <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">Оптимизация изображений для сайта</h1>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                    Подготовьте сразу несколько изображений для публикации: сервис применит оптимальное сжатие
                    без заметной потери качества и уменьшит максимальное разрешение до 1920×1080 пикселей.
                </p>
                <a href="#processor" class="mt-8 inline-flex rounded-xl bg-violet-500 px-6 py-3 font-semibold text-white transition hover:bg-violet-400">Оптимизировать изображения</a>
            </div>
        </section>

        <section id="processor" aria-label="Инструмент оптимизации изображений для сайта">
            @inertia
        </section>

        <section class="bg-white px-4 py-16 sm:py-20">
            <div class="mx-auto max-w-6xl">
                <p class="text-sm font-semibold uppercase tracking-wider text-violet-700">Готово для публикации</p>
                <h2 class="mt-3 max-w-3xl text-2xl font-bold tracking-tight sm:text-3xl">Что делает оптимизатор</h2>
                <div class="mt-8 grid gap-5 md:grid-cols-3">
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="font-semibold">Уменьшает вес файлов</h3>
                        <p class="mt-2 leading-7 text-slate-600">Применяет подходящее для веба сжатие без заметной потери качества изображения.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="font-semibold">Ограничивает разрешение</h3>
                        <p class="mt-2 leading-7 text-slate-600">Уменьшает слишком большие изображения до максимальных 1920×1080 пикселей с сохранением пропорций.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="font-semibold">Обрабатывает пакетно</h3>
                        <p class="mt-2 leading-7 text-slate-600">Применяет единые настройки ко всему набору JPG, PNG и WebP за один запуск.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-slate-100 px-4 py-16 sm:py-20">
            <div class="mx-auto max-w-6xl">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Для каких задач подходит</h2>
                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <p class="rounded-2xl bg-white p-5 font-medium">Карточки интернет-магазинов</p>
                    <p class="rounded-2xl bg-white p-5 font-medium">Статьи и блоги</p>
                    <p class="rounded-2xl bg-white p-5 font-medium">Корпоративные сайты</p>
                    <p class="rounded-2xl bg-white p-5 font-medium">CMS и контентные проекты</p>
                </div>
            </div>
        </section>

        <section id="faq" class="bg-white px-4 py-16 sm:py-20">
            <div class="mx-auto max-w-4xl">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Вопросы об оптимизации изображений</h2>
                <div class="mt-8 space-y-4">
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">Изменится ли качество изображения?</summary>
                        <p class="mt-3 leading-7 text-slate-600">Сервис использует умеренное сжатие, рассчитанное на уменьшение веса без заметного ухудшения при просмотре на сайте.</p>
                    </details>
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">Что произойдёт с небольшими изображениями?</summary>
                        <p class="mt-3 leading-7 text-slate-600">Если изображение уже меньше 1920×1080 пикселей, его разрешение не будет увеличиваться.</p>
                    </details>
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">Сохраняются ли формат и пропорции?</summary>
                        <p class="mt-3 leading-7 text-slate-600">Да, исходный формат и пропорции сохраняются. Ограничивается только максимальная ширина и высота.</p>
                    </details>
                </div>
                <p class="mt-8 text-center text-slate-600">
                    Хотите выбрать параметры вручную? <a href="{{ route('process-photos.form') }}" class="font-semibold text-violet-700">Откройте полный инструмент</a>.
                </p>
            </div>
        </section>
    </main>

    <footer class="bg-slate-950 px-4 py-8 text-sm text-slate-400">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} Isibia Process Images</p>
            <a href="{{ route('process-photos.form') }}" class="hover:text-white">Пакетная обработка изображений</a>
        </div>
    </footer>
</div>
