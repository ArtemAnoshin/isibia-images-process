<div class="relative z-10 w-full text-slate-900" data-public-home>
    <header class="border-b border-white/10 bg-slate-950/85 text-white backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-4 py-4">
            <a href="{{ route('process-photos.form') }}" class="text-lg font-bold tracking-tight">
                Isibia <span class="text-violet-300">Process Images</span>
            </a>
            <nav aria-label="Основная навигация" class="flex items-center gap-5 text-sm">
                @include('pages.partials.tools-dropdown')
                <a href="#processor" class="hover:text-violet-300">Миниатюры</a>
                <a href="#faq" class="hidden hover:text-violet-300 sm:inline">Вопросы</a>
                <a href="{{ route('about-developer-page') }}" class="hidden hover:text-violet-300 sm:inline">О разработчике</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="bg-slate-950 px-4 py-14 text-center text-white sm:py-20">
            <div class="mx-auto max-w-4xl">
                <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-violet-300">До пяти размеров за один запуск</p>
                <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">Создать миниатюры изображений онлайн</h1>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                    Укажите нужную ширину и высоту и создайте уменьшенные копии сразу для нескольких изображений.
                    Пропорции и исходный формат будут сохранены.
                </p>
                <a href="#processor" class="mt-8 inline-flex rounded-xl bg-violet-500 px-6 py-3 font-semibold text-white transition hover:bg-violet-400">Создать миниатюры</a>
            </div>
        </section>

        <section id="processor" aria-label="Инструмент создания миниатюр">
            @inertia
        </section>

        <section class="bg-white px-4 py-16 sm:py-20">
            <div class="mx-auto max-w-6xl">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Миниатюры для сайта и контента</h2>
                <div class="mt-8 grid gap-5 md:grid-cols-3">
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="font-semibold">Несколько размеров</h3>
                        <p class="mt-2 leading-7 text-slate-600">Добавьте до пяти вариантов ширины и высоты за одну обработку.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="font-semibold">Пакетная обработка</h3>
                        <p class="mt-2 leading-7 text-slate-600">Создавайте одинаковый набор миниатюр сразу для нескольких файлов.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6">
                        <h3 class="font-semibold">Сохранение пропорций</h3>
                        <p class="mt-2 leading-7 text-slate-600">Изображения уменьшаются без растягивания и увеличения маленьких оригиналов.</p>
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
                    <a href="{{ route('images.optimizer') }}" class="rounded-xl bg-violet-600 px-5 py-3 font-semibold text-white hover:bg-violet-500">Оптимизировать для веба</a>
                    <a href="{{ route('process-photos.form') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 font-semibold hover:border-violet-400">Открыть полный инструмент</a>
                </div>
            </div>
        </section>

        <section id="faq" class="bg-white px-4 py-16 sm:py-20">
            <div class="mx-auto max-w-4xl">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Вопросы о миниатюрах</h2>
                <div class="mt-8 space-y-4">
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">Сколько размеров можно создать одновременно?</summary>
                        <p class="mt-3 leading-7 text-slate-600">За одну обработку можно указать до пяти вариантов размеров миниатюр.</p>
                    </details>
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">Будут ли изображения обрезаны?</summary>
                        <p class="mt-3 leading-7 text-slate-600">Нет, миниатюры масштабируются с сохранением исходных пропорций.</p>
                    </details>
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-semibold">В каком формате сохраняются миниатюры?</summary>
                        <p class="mt-3 leading-7 text-slate-600">Каждая миниатюра сохраняет формат исходного изображения.</p>
                    </details>
                </div>
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
