<div class="relative z-10 w-full text-slate-900" data-public-home>
    <header class="border-b border-white/10 bg-slate-950/85 text-white backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-4 py-4">
            <a href="{{ route('process-photos.form') }}" class="text-lg font-bold tracking-tight">
                Isibia <span class="text-violet-300">Process Images</span>
            </a>
            <nav aria-label="Основная навигация" class="flex items-center gap-5 text-sm">
                @include('pages.partials.tools-dropdown')
                <a href="#processor" class="hover:text-violet-300">Конвертер</a>
                <a href="#faq" class="hidden hover:text-violet-300 sm:inline">Вопросы</a>
                <a href="{{ route('about-developer-page') }}" class="hidden hover:text-violet-300 sm:inline">О разработчике</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="bg-slate-950 px-4 py-14 text-center text-white sm:py-20">
            <div class="mx-auto max-w-4xl">
                <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-violet-300">JPEG, PNG и WebP</p>
                <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">Изменить формат изображений онлайн</h1>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                    Выберите новый формат и конвертируйте сразу несколько изображений. Разрешение,
                    размеры и имена файлов останутся без изменений.
                </p>
                <a href="#processor" class="mt-8 inline-flex rounded-xl bg-violet-500 px-6 py-3 font-semibold text-white transition hover:bg-violet-400">Выбрать изображения</a>
            </div>
        </section>

        <section id="processor" aria-label="Конвертер форматов изображений">
            @inertia
        </section>

        <section class="bg-white px-4 py-16 sm:py-20">
            <div class="mx-auto max-w-6xl">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Доступные форматы</h2>
                <div class="mt-8 grid gap-5 md:grid-cols-3">
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold">JPEG</h3>
                        <p class="mt-2 leading-7 text-slate-600">Распространённый формат для фотографий и изображений без прозрачности.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold">PNG</h3>
                        <p class="mt-2 leading-7 text-slate-600">Подходит для графики, скриншотов и изображений с прозрачным фоном.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold">WebP</h3>
                        <p class="mt-2 leading-7 text-slate-600">Современный формат с поддержкой прозрачности и хорошей совместимостью с браузерами.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-slate-100 px-4 py-16 sm:py-20">
            <div class="mx-auto max-w-4xl text-center">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Нужно подготовить изображения для сайта?</h2>
                <p class="mx-auto mt-4 max-w-2xl leading-7 text-slate-600">
                    Конвертер изменяет только формат. Чтобы дополнительно уменьшить вес и ограничить разрешение
                    до 1920×1080, используйте оптимизатор для веба.
                </p>
                <div class="mt-7 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('images.optimizer') }}" class="rounded-xl bg-violet-600 px-5 py-3 font-semibold text-white hover:bg-violet-500">Оптимизировать для веба</a>
                    <a href="{{ route('process-photos.form') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 font-semibold hover:border-violet-400">Открыть полный инструмент</a>
                </div>
            </div>
        </section>

        <section id="faq" class="bg-white px-4 py-16 sm:py-20">
            <div class="mx-auto max-w-4xl">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Вопросы об изменении формата</h2>
                <div class="mt-8 space-y-4">
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">Можно ли изменить формат нескольких файлов сразу?</summary>
                        <p class="mt-3 leading-7 text-slate-600">Да, выбранный целевой формат применяется ко всему загруженному набору изображений.</p>
                    </details>
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">Изменится ли разрешение изображения?</summary>
                        <p class="mt-3 leading-7 text-slate-600">Нет. Этот инструмент меняет только формат и сохраняет исходные размеры изображения.</p>
                    </details>
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">Какой формат выбрать для сайта?</summary>
                        <p class="mt-3 leading-7 text-slate-600">Часто для веба подходит WebP, но выбор зависит от содержимого и требований проекта. Для автоматической подготовки используйте оптимизатор.</p>
                    </details>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-slate-950 px-4 py-8 text-sm text-slate-400">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} Isibia Process Images</p>
            <a href="{{ route('images.optimizer') }}" class="hover:text-white">Оптимизатор изображений для сайта</a>
        </div>
    </footer>
</div>
