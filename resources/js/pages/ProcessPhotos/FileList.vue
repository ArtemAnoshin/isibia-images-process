<script setup lang="ts">
import type { ProcessedFile } from '@/types/files';

withDefaults(
    defineProps<{
        processedFiles: ProcessedFile[];
    }>(),
    {
        processedFiles: () => [],
    },
);

// Методы
const emit = defineEmits(['delete', 'deleteAll']);

const formatDate = (date: string) => {
    if (!date) {
        return '';
    }

    return new Date(date).toLocaleString('ru-RU', {
        day: 'numeric',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const deleteFile = (id: number) => {
    if (confirm('Удалить этот файл?')) {
        emit('delete', id);
    }
};

const deleteAll = () => {
    if (confirm('Удалить все файлы?')) {
        emit('deleteAll');
    }
};
</script>

<style scoped>
.file-list {
    margin-top: 20px;
}
</style>

<template>
    <section
        class="file-list rounded-2xl border border-slate-200 bg-slate-50 p-5"
    >
        <div class="mb-4 flex items-center justify-between gap-4">
            <div>
                <h3 class="font-semibold text-slate-900">
                    Недавние результаты
                </h3>
                <p class="mt-1 text-xs text-slate-500">
                    Файлы хранятся временно и очищаются автоматически
                </p>
            </div>
            <span
                v-if="processedFiles.length"
                class="rounded-full bg-white px-3 py-1 text-xs font-medium text-slate-500"
            >
                {{ processedFiles.length }}
            </span>
        </div>

        <!-- Если файлов нет -->
        <div
            v-if="!processedFiles.length"
            class="rounded-xl border-2 border-dashed border-slate-200 bg-white py-8 text-center"
        >
            <div class="mb-2 text-4xl">📭</div>
            <p class="text-gray-500">Нет обработанных файлов</p>
            <p class="mt-1 text-sm text-gray-400">
                Загрузите изображения и обработайте их
            </p>
        </div>

        <!-- Список файлов -->
        <div v-else class="space-y-3">
            <div
                v-for="file in processedFiles"
                :key="file.id"
                class="flex flex-wrap items-center justify-between gap-4 rounded-xl border border-slate-200 bg-white p-4 transition hover:border-slate-300 hover:shadow-sm"
            >
                <!-- Левая часть: иконка и информация -->
                <div class="flex min-w-0 flex-1 items-center gap-3">
                    <span class="flex-shrink-0 text-2xl">
                        {{ file.type === 'archive' ? '📦' : '🖼️' }}
                    </span>

                    <div class="min-w-0 flex-1">
                        <div
                            class="truncate font-medium text-gray-800"
                            :title="file.original_name"
                        >
                            {{ file.original_name }}
                        </div>
                        <div
                            class="flex flex-wrap items-center gap-2 text-xs text-gray-500"
                        >
                            <span>{{
                                file.type === 'archive'
                                    ? 'ZIP-архив'
                                    : 'Изображение'
                            }}</span>

                            <span v-if="file.size" class="text-gray-400">
                                • {{ file.size }}
                            </span>

                            <span class="text-gray-400"
                                >• {{ formatDate(file.created_at) }}</span
                            >
                        </div>
                    </div>
                </div>

                <!-- Правая часть: кнопки действий -->
                <div class="ml-4 flex flex-shrink-0 items-center gap-2">
                    <a
                        :href="file.download_url"
                        download
                        class="flex items-center gap-1 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
                    >
                        ⬇ Скачать
                    </a>

                    <button
                        @click="deleteFile(file.id)"
                        class="p-1 text-gray-400 transition hover:text-red-600"
                        title="Удалить"
                    >
                        ✕
                    </button>
                </div>
            </div>
            <button
                @click="deleteAll"
                class="mt-4 text-sm text-slate-500 transition hover:text-red-600"
            >
                Очистить список и удалить все файлы
            </button>
        </div>
    </section>
</template>
