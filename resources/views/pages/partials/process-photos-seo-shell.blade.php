<div class="relative z-10 w-full text-slate-900" data-public-home>
    <header class="border-b border-white/10 bg-slate-950/85 text-white backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-4 py-4">
            <a href="{{ route('process-photos.form') }}" class="text-lg font-bold tracking-tight">
                Isibia <span class="text-violet-300">Process Images</span>
            </a>
            <nav aria-label="Основная навигация" class="flex items-center gap-5 text-sm">
                @include('pages.partials.tools-dropdown')
                <a href="#processor" class="hover:text-violet-300">Инструмент</a>
                <a href="#features" class="hidden hover:text-violet-300 sm:inline">Возможности</a>
                <a href="#faq" class="hidden hover:text-violet-300 sm:inline">Вопросы</a>
                <a href="{{ route('about-developer-page') }}" class="hover:text-violet-300">О разработчике</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="bg-slate-950 px-4 py-14 text-center text-white sm:py-20">
            <div class="mx-auto max-w-4xl">
                <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-violet-300">
                    Онлайн-инструмент для сайтов и контентных проектов
                </p>
                <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
                    Пакетная обработка изображений онлайн
                </h1>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                    Меняйте размер и формат JPG, PNG и WebP, оптимизируйте фотографии для веба
                    и создавайте миниатюры сразу для нескольких файлов.
                </p>
                <a href="#processor" class="mt-8 inline-flex rounded-xl bg-violet-500 px-6 py-3 font-semibold text-white transition hover:bg-violet-400">
                    Обработать изображения
                </a>
            </div>
        </section>

        <section id="processor" aria-label="Инструмент обработки изображений">
            @inertia
        </section>

        <section id="features" class="bg-white px-4 py-16 sm:py-20">
            <div class="mx-auto max-w-6xl">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Что можно сделать с изображениями</h2>
                <div class="mt-8 grid gap-5 md:grid-cols-3">
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold"><a href="{{ route('images.optimizer') }}" class="hover:text-violet-700">Оптимизировать изображения для сайта</a></h3>
                        <p class="mt-2 leading-7 text-slate-600">Уменьшить вес фотографий и ускорить загрузку страниц без лишних ручных операций.</p>
                        <a href="{{ route('images.optimizer') }}" class="mt-4 inline-flex font-semibold text-violet-700">Открыть инструмент →</a>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold"><a href="{{ route('images.converter') }}" class="hover:text-violet-700">Изменить формат изображений</a></h3>
                        <p class="mt-2 leading-7 text-slate-600">Конвертировать сразу несколько изображений в JPEG, PNG или WebP.</p>
                        <a href="{{ route('images.converter') }}" class="mt-4 inline-flex font-semibold text-violet-700">Открыть инструмент →</a>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold"><a href="{{ route('images.thumbnails') }}" class="hover:text-violet-700">Создать миниатюры</a></h3>
                        <p class="mt-2 leading-7 text-slate-600">Подготовить несколько размеров изображений за одну пакетную обработку.</p>
                        <a href="{{ route('images.thumbnails') }}" class="mt-4 inline-flex font-semibold text-violet-700">Открыть инструмент →</a>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-slate-100 px-4 py-16 sm:py-20">
            <div class="mx-auto max-w-6xl">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Как это работает</h2>
                <ol class="mt-8 grid gap-5 md:grid-cols-3">
                    <li class="rounded-2xl bg-white p-6"><strong class="text-violet-700">1. Загрузите</strong><p class="mt-2 text-slate-600">Выберите до десяти изображений JPG, PNG или WebP.</p></li>
                    <li class="rounded-2xl bg-white p-6"><strong class="text-violet-700">2. Настройте</strong><p class="mt-2 text-slate-600">Укажите формат, разрешение, сжатие и размеры миниатюр.</p></li>
                    <li class="rounded-2xl bg-white p-6"><strong class="text-violet-700">3. Скачайте</strong><p class="mt-2 text-slate-600">Получите готовые файлы после обработки на сервере.</p></li>
                </ol>
            </div>
        </section>

        <section id="faq" class="bg-white px-4 py-16 sm:py-20">
            <div class="mx-auto max-w-4xl">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Частые вопросы</h2>
                <div class="mt-8 space-y-4">
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">Какие форматы поддерживаются?</summary>
                        <p class="mt-3 leading-7 text-slate-600">Можно загружать изображения популярных веб-форматов и сохранять результат как JPEG, PNG или WebP.</p>
                    </details>
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">Можно ли обработать несколько файлов сразу?</summary>
                        <p class="mt-3 leading-7 text-slate-600">Да. Сервис применяет выбранные настройки ко всему загруженному набору изображений.</p>
                    </details>
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">Сохраняются ли пропорции изображения?</summary>
                        <p class="mt-3 leading-7 text-slate-600">При ограничении максимального разрешения изображения масштабируются с сохранением пропорций.</p>
                    </details>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-slate-950 px-4 py-8 text-sm text-slate-400">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} Isibia Process Images</p>
            <a href="{{ route('about-developer-page') }}" class="hover:text-white">О разработчике и контакты</a>
        </div>
    </footer>
</div>
