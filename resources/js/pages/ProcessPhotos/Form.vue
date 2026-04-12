<!-- resources/js/Pages/Dashboard/ProcessPhotos.vue -->
<script setup>

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

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

const selectedFiles = ref([])
const isProcessing = ref(false)
const fileInput = ref(null)

// Обработка выбора файлов
const handleFileSelect = (event) => {
    const files = Array.from(event.target.files)

    files.forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader()
            reader.onload = (e) => {
                selectedFiles.value.push({
                    file: file,
                    preview: e.target.result,
                    name: file.name,
                    size: file.size
                })
            }
            reader.readAsDataURL(file)
        }
    })

    // Очищаем input
    if (fileInput.value) {
        fileInput.value.value = ''
    }
}

// Удаление файла
const removeFile = (index) => {
    selectedFiles.value.splice(index, 1)
}

// Форматирование размера
const formatFileSize = (bytes) => {
    if (bytes === 0) return '0 B'
    const k = 1024
    const sizes = ['B', 'KB', 'MB']
    const i = Math.floor(Math.log(bytes) / Math.log(k))
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

// Отправка формы
const submitForm = () => {
    if (!selectedFiles.value.length) return

    const formData = new FormData()
    selectedFiles.value.forEach((item, index) => {
        formData.append(`photos[${index}]`, item.file)
    })

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
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Заголовок -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-2xl font-bold mb-4">Обработка фотографий</h1>
                    <p class="text-gray-600">
                        Загрузите фотографии для сжатия без потери качества
                    </p>
                </div>

                <!-- Flash сообщение -->
                <div v-if="flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ flash.success }}
                </div>

                <!-- Форма загрузки -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <form @submit.prevent="submitForm">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                Выберите фотографии
                            </label>

                            <input
                                type="file"
                                ref="fileInput"
                                @change="handleFileSelect"
                                multiple
                                accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />

                            <p class="text-sm text-gray-500 mt-1">
                                Можно выбрать несколько фотографий. Поддерживаются: JPEG, PNG, GIF. Макс. размер: 10MB
                            </p>
                        </div>

                        <!-- Превью -->
                        <div v-if="selectedFiles.length" class="mb-4">
                            <h3 class="font-bold mb-2">Выбранные файлы ({{ selectedFiles.length }})</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <div v-for="(file, index) in selectedFiles" :key="index" class="relative">
                                    <img :src="file.preview" class="w-full h-32 object-cover rounded border" />
                                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b">
                                        {{ formatFileSize(file.size) }}
                                    </div>
                                    <button
                                        @click="removeFile(index)"
                                        type="button"
                                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600"
                                    >
                                        ×
                                    </button>
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
