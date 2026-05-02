<!-- resources/js/Pages/ProcessPhotos/Form.vue -->
<script setup lang="ts">

import { router, Head } from '@inertiajs/vue3'
import { ref, reactive } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue';
import ImageCompressionSetting from '../../components/ProcessPhotoFormPartials/ImageCompressionSetting.vue'
import ImageMaxResolutionSetting from '../../components/ProcessPhotoFormPartials/ImageMaxResolutionSetting.vue'
import ImageUploaderWithPreview from '../../components/ProcessPhotoFormPartials/ImageUploaderWithPreview.vue';

const breadcrumbs = [
    {
        title: 'Process Photos',
        href: '/dashboard/process-photos',
    },
];

const props = defineProps({
    processedPhotos: {
        type: Array,
        default: () => []
    },
    flash: {
        type: Object,
        default: () => ({})
    }
})

const selectedFiles = ref<File[]>([])
const isProcessing = ref(false)
const fileInput = ref(null)

// Параметры обработки
const processingOptions = reactive({
    compression: 80, // 10–90%
    max_resolution: {},
    thumbnails: [],
    watermark: {
        enabled: false,
        type: 'text', // 'text' или 'image'
        position: 'bottom-right', // 'top-left', 'center', 'bottom-right', etc.
        opacity: 50, // 0–100%
        text: '',
        image_url: null,
    }
})

// Отправка формы
const submitForm = () => {
    if (!selectedFiles.value.length) return

    const formData = new FormData()

    // Файлы
    selectedFiles.value.forEach((item, index) => {
        formData.append(`photos[${index}]`, item.file)
    })

    // Параметры
    formData.append('compression', processingOptions.compression)
    formData.append('max_resolution', processingOptions.max_resolution)
    formData.append('thumbnails', JSON.stringify(processingOptions.thumbnails))

    // Водяной знак
    formData.append('watermark_enabled', processingOptions.watermark.enabled)
    if (processingOptions.watermark.enabled) {
        formData.append('watermark_type', processingOptions.watermark.type)
        formData.append('watermark_position', processingOptions.watermark.position)
        formData.append('watermark_opacity', processingOptions.watermark.opacity)
        if (processingOptions.watermark.type === 'text') {
            formData.append('watermark_text', processingOptions.watermark.text)
        }
        // Если водяной знак — картинка, можно будет загрузить отдельно
    }

    isProcessing.value = true

    router.post('/dashboard/process-photos', formData, {
        preserveScroll: true,
        onFinish: () => {
            isProcessing.value = false
            selectedFiles.value = []
        },
        onError: (errors) => {
            console.error('Upload error:', errors)
        }
    })
}
</script>

<template>
    <Head title="Process Photos" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Заголовок -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-2xl font-bold mb-4">Обработка фотографий</h1>
                    <p class="text-gray-600">
                        Загрузите фотографии и настройте параметры обработки
                    </p>
                </div>

                <!-- Flash сообщение -->
                <div v-if="flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ flash.success }}
                </div>

                <!-- Форма загрузки -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <form @submit.prevent="submitForm">
                        <!-- Загрузка файлов -->
                        <div class="mb-6">
                            <ImageUploaderWithPreview @update:files="selectedFiles = $event" />
                        </div>

                        <!-- Параметры обработки -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Настройки обработки</h3>

                            <!-- Степень сжатия -->
                            <ImageCompressionSetting v-model="processingOptions.compression" />

                            <!-- Максимальное разрешение -->
                            <ImageMaxResolutionSetting v-model="processingOptions.max_resolution" />

                            <!-- Миниатюры -->
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2">
                                    Создать миниатюры
                                </label>
                                <input
                                    v-model="processingOptions.thumbnails"
                                    type="text"
                                    placeholder='например: [{"width": 300,"height": 200}, {"width": 150,"height": 150}]'
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <p class="text-sm text-gray-500 mt-1">
                                    Формат: JSON массив объектов с полями width и height
                                </p>
                            </div>

                            <!-- Водяной знак -->
                            <div class="mb-4">
                                <label class="flex items-center space-x-2">
                                    <input
                                        v-model="processingOptions.watermark.enabled"
                                        type="checkbox"
                                        class="rounded text-blue-500"
                                    />
                                    <span class="text-gray-700">Добавить водяной знак</span>
                                </label>
                            </div>

                            <div v-if="processingOptions.watermark.enabled" class="pl-4 border-l-2 border-gray-200">
                                <div class="mb-3">
                                    <label class="block text-gray-700 font-medium mb-1">Тип водяного знака</label>
                                    <select
                                        v-model="processingOptions.watermark.type"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="text">Текст</option>
                                        <option value="image">Картинка</option>
                                    </select>
                                </div>

                                <div v-if="processingOptions.watermark.type === 'text'" class="mb-3">
                                    <label class="block text-gray-700 font-medium mb-1">Текст водяного знака</label>
                                    <input
                                        v-model="processingOptions.watermark.text"
                                        type="text"
                                        placeholder="Введите текст"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>

                                <div class="mb-3">
                                    <label class="block text-gray-700 font-medium mb-1">Положение</label>
                                    <select
                                        v-model="processingOptions.watermark.position"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="top-left">Сверху слева</option>
                                        <option value="top-right">Сверху справа</option>
                                        <option value="center">По центру</option>
                                        <option value="bottom-left">Снизу слева</option>
                                        <option value="bottom-right">Снизу справа</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-gray-700 font-medium mb-2">
                                        Прозрачность: {{ processingOptions.watermark.opacity }}%
                                    </label>
                                    <input
                                        v-model.number="processingOptions.watermark.opacity"
                                        type="range"
                                        min="0"
                                        max="100"
                                        step="5"
                                        class="w-full"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Кнопка отправки -->
                        <button
                            type="submit"
                            :disabled="isProcessing || !selectedFiles.length"
                            class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed transition"
                        >
                            <span v-if="isProcessing" class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Обработка...
                            </span>
                            <span v-else>Обработать фотографии</span>
                        </button>
                    </form>
                </div>

                <!-- Результаты обработки -->
                <div v-if="processedPhotos.length" class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Результаты обработки</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="(photo, index) in processedPhotos" :key="index" class="border rounded-lg p-3">
                            <img :src="photo.url" class="w-full h-48 object-cover rounded mb-2" />
                            <div class="space-y-1 text-sm">
                                <p class="font-medium">{{ photo.original_name }}</p>
                                <p class="text-green-600">Было: {{ photo.original_size }}</p>
                                <p class="text-blue-600">Стало: {{ photo.new_size }}</p>
                                <p class="text-red-600">Сэкономлено: {{ photo.saved }}</p>
                                <a :href="photo.url" download class="inline-block mt-2 text-blue-500 hover:text-blue-700 text-sm">
                                    Скачать ↓
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
