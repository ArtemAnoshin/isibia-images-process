<details class="group relative">
    <summary class="flex cursor-pointer list-none items-center gap-1 hover:text-violet-300">
        Инструменты
        <svg class="h-4 w-4 transition group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.22 7.22a.75.75 0 0 1 1.06 0L10 10.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
        </svg>
    </summary>
    <div class="absolute right-0 z-30 mt-3 w-64 overflow-hidden rounded-xl border border-white/10 bg-slate-900 p-2 text-sm text-white shadow-2xl">
        <a href="{{ route('process-photos.form') }}" class="block rounded-lg px-4 py-3 hover:bg-white/10 hover:text-violet-200">
            <strong class="block">Пакетная обработка</strong>
            <span class="mt-1 block text-xs font-normal text-slate-400">Все настройки в одном инструменте</span>
        </a>
        <a href="{{ route('images.optimizer') }}" class="block rounded-lg px-4 py-3 hover:bg-white/10 hover:text-violet-200">
            <strong class="block">Оптимизировать для веба</strong>
            <span class="mt-1 block text-xs font-normal text-slate-400">Сжатие и размер до 1920×1080</span>
        </a>
        <a href="{{ route('images.converter') }}" class="block rounded-lg px-4 py-3 hover:bg-white/10 hover:text-violet-200">
            <strong class="block">Изменить формат</strong>
            <span class="mt-1 block text-xs font-normal text-slate-400">Конвертация в JPEG, PNG или WebP</span>
        </a>
        <a href="{{ route('images.thumbnails') }}" class="block rounded-lg px-4 py-3 hover:bg-white/10 hover:text-violet-200">
            <strong class="block">Создать миниатюры</strong>
            <span class="mt-1 block text-xs font-normal text-slate-400">Несколько размеров за один запуск</span>
        </a>
    </div>
</details>
