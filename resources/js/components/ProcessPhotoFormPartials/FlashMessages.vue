<script setup lang="ts">
import { computed } from 'vue';
import type { PageProps } from '@/types/files';

const props = defineProps<{
    flash: NonNullable<PageProps['flash']>;
}>();

const result = computed(() => props.flash.processed);
const savedBytes = computed(() =>
    result.value ? result.value.originalSize - result.value.processedSize : 0,
);
const savingsPercent = computed(() => {
    if (!result.value?.originalSize || savedBytes.value <= 0) return 0;

    return Math.round((savedBytes.value / result.value.originalSize) * 100);
});

const formatBytes = (bytes: number): string => {
    if (!bytes) return '0 Б';

    const units = ['Б', 'КБ', 'МБ', 'ГБ'];
    const index = Math.min(
        Math.floor(Math.log(bytes) / Math.log(1024)),
        units.length - 1,
    );
    const value = bytes / 1024 ** index;

    return `${value.toFixed(index === 0 ? 0 : 1)} ${units[index]}`;
};
</script>

<template>
    <div
        v-if="flash.success && !flash.processed"
        class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800"
    >
        {{ flash.success }}
    </div>

    <section
        v-if="result"
        class="mb-6 overflow-hidden rounded-2xl border border-emerald-200 bg-white shadow-lg"
        aria-labelledby="processing-result-title"
    >
        <div
            class="flex flex-wrap items-center justify-between gap-4 bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-5 text-white"
        >
            <div>
                <p class="text-sm font-medium text-emerald-100">
                    Обработка завершена
                </p>
                <h2 id="processing-result-title" class="text-2xl font-bold">
                    Файлы готовы к скачиванию
                </h2>
            </div>
            <div
                v-if="savingsPercent > 0"
                class="rounded-full bg-white/15 px-4 py-2 font-semibold backdrop-blur"
            >
                −{{ savingsPercent }}% объёма
            </div>
        </div>

        <div class="p-6">
            <div class="grid gap-3 sm:grid-cols-3">
                <div class="rounded-xl bg-slate-50 p-4">
                    <p
                        class="text-xs font-semibold tracking-wide text-slate-500 uppercase"
                    >
                        До обработки
                    </p>
                    <p class="mt-1 text-xl font-bold text-slate-900">
                        {{ formatBytes(result.originalSize) }}
                    </p>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <p
                        class="text-xs font-semibold tracking-wide text-slate-500 uppercase"
                    >
                        После обработки
                    </p>
                    <p class="mt-1 text-xl font-bold text-slate-900">
                        {{ formatBytes(result.processedSize) }}
                    </p>
                </div>
                <div
                    class="rounded-xl p-4"
                    :class="savedBytes > 0 ? 'bg-emerald-50' : 'bg-blue-50'"
                >
                    <p
                        class="text-xs font-semibold tracking-wide uppercase"
                        :class="
                            savedBytes > 0
                                ? 'text-emerald-700'
                                : 'text-blue-700'
                        "
                    >
                        {{ savedBytes > 0 ? 'Экономия' : 'Создано файлов' }}
                    </p>
                    <p
                        class="mt-1 text-xl font-bold"
                        :class="
                            savedBytes > 0
                                ? 'text-emerald-800'
                                : 'text-blue-800'
                        "
                    >
                        {{
                            savedBytes > 0
                                ? formatBytes(savedBytes)
                                : result.fileCount
                        }}
                    </p>
                </div>
            </div>

            <div
                class="mt-5 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-slate-200 p-4"
            >
                <div class="flex items-center gap-3">
                    <span class="text-3xl">{{
                        result.isArchive ? '📦' : '🖼️'
                    }}</span>
                    <div>
                        <p class="font-semibold text-slate-900">
                            {{
                                result.isArchive
                                    ? `ZIP-архив · ${result.fileCount} файлов`
                                    : result.files[0]?.filename
                            }}
                        </p>
                        <p class="text-sm text-slate-500">
                            Размер загрузки:
                            {{ formatBytes(result.downloadSize) }}
                        </p>
                    </div>
                </div>
                <a
                    :href="result.downloadUrl"
                    download
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                >
                    <span>⬇</span>
                    {{ result.isArchive ? 'Скачать ZIP' : 'Скачать файл' }}
                </a>
            </div>
        </div>
    </section>
</template>
