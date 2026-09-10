<header class="border-b border-white/10 bg-slate-950/85 text-white backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-4 py-4">
        @if (Route::is('process-photos.form'))
            <a class="text-lg font-bold tracking-tight">
                Isibia <span class="text-violet-300">Process Images</span>
            </a>
        @else
            <a href="{{ route('process-photos.form') }}" class="text-lg font-bold tracking-tight">
                Isibia <span class="text-violet-300">Process Images</span>
            </a>
        @endif

        <nav aria-label="Основная навигация" class="flex items-center gap-5 text-sm">
            @include('pages.partials.tools-dropdown')
            <a href="#processor" class="hover:text-violet-300">Инструмент</a>
            <a href="#features" class="hidden hover:text-violet-300 sm:inline">Возможности</a>
            <a href="#faq" class="hidden hover:text-violet-300 sm:inline">Вопросы</a>
            <a href="{{ route('about-developer-page') }}" class="hover:text-violet-300">О разработчике</a>
        </nav>
    </div>
</header>
