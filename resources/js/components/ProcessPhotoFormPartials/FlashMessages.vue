<!-- components/FlashMessages.vue -->
<script setup lang="ts">
import type { PageProps } from '@/types/files'

// Принимаем весь объект flash как пропс
defineProps<{
    flash: NonNullable<PageProps['flash']>
}>()
</script>

<template>
    <!-- Текстовое уведомление об успехе -->
    <div
        v-if="flash.success"
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
    >
        {{ flash.success }}
    </div>

    <!-- Блок с результатами обработки -->
    <div
        v-if="flash.processed"
        class="bg-white rounded-lg shadow-md p-6 mb-6"
    >
        <h2 class="text-xl font-bold mb-4">Результат обработки</h2>

        <!-- Основная кнопка скачивания -->
        <div class="mb-4">
            <a
                :href="flash.processed.downloadUrl"
                download
                class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition"
            >
                📥 Скачать результат
            </a>
        </div>

        <!-- Логика отображения файлов -->
        <div v-if="flash.processed.isArchive" class="flex items-center justify-between border rounded p-3 bg-blue-50">
            <div>
                <span class="font-medium">📦 Архив</span>
                <span class="text-sm text-gray-600 ml-2">
                    ({{ flash.processed.files?.length || 0 }} файлов)
                </span>
            </div>
            <a
                :href="flash.processed.downloadUrl"
                download
                class="text-blue-500 hover:underline font-medium"
            >
                ⬇ Скачать архив
            </a>
        </div>

        <div v-else class="space-y-2">
            <div
                v-for="file in flash.processed.files"
                :key="file.filename"
                class="flex items-center justify-between border rounded p-2 hover:bg-gray-50"
            >
                <span class="truncate mr-4">{{ file.filename }}</span>
                <a
                    :href="file.url"
                    download
                    class="text-blue-500 hover:underline whitespace-nowrap"
                >
                    Скачать
                </a>
            </div>
        </div>
    </div>
</template>
