<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import ImageCompressionSetting from '@/components/ProcessPhotoFormPartials/ImageCompressionSetting.vue'
import ImageMaxResolutionSetting from '@/components/ProcessPhotoFormPartials/ImageMaxResolutionSetting.vue'
import ImageUploaderWithPreview from '@/components/ProcessPhotoFormPartials/ImageUploaderWithPreview.vue'
import ThumbnailsBuilder from '@/components/ProcessPhotoFormPartials/ThumbnailsBuilder.vue'
import WatermarkSettings from '@/components/ProcessPhotoFormPartials/WatermarkSettings.vue'
import AppLayout from '@/layouts/AppLayout.vue'

const breadcrumbs = [
    { title: 'Process Photos', href: '/dashboard/process-photos' }
]

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

// ✅ единый form
const form = useForm({
    files: [] as File[],

    compression: 80,

    resolution: {
        width: null as number | null,
        height: null as number | null
    },

    thumbnails: [] as { width: number | null; height: number | null }[],

    watermark: {
        enabled: false,
        type: 'text',
        position: 'bottom-right',
        opacity: 50,
        text: '',
        image: null as File | null,

        // задел под canvas
        x: 0,
        y: 0,
        scale: 1
    }
})

// 🚀 submit
const submit = () => {
    if (!form.files.length) {
        alert('Добавьте хотя бы одно изображение')

        return
    }

    form.post('/dashboard/process-photos', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('files')
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
                    <h1 class="text-2xl font-bold mb-4">
                        Обработка фотографий
                    </h1>
                    <p class="text-gray-600">
                        Загрузите фотографии и настройте параметры обработки
                    </p>
                </div>

                <!-- Flash -->
                <div
                    v-if="flash.success"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
                >
                    {{ flash.success }}
                </div>

                <!-- Форма -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <form @submit.prevent="submit">

                        <!-- Upload -->
                        <div class="mb-6">
                            <ImageUploaderWithPreview
                                @update:files="form.files = $event"
                            />
                        </div>

                        <!-- Настройки -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">
                                Настройки обработки
                            </h3>

                            <ImageCompressionSetting
                                v-model="form.compression"
                            />

                            <ImageMaxResolutionSetting
                                v-model="form.resolution"
                            />

                            <ThumbnailsBuilder
                                v-model="form.thumbnails"
                            />

                            <WatermarkSettings
                                v-model="form.watermark"
                            />
                        </div>

                        <!-- Кнопка -->
                        <button
                            type="submit"
                            :disabled="form.processing || !form.files.length"
                            class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed transition"
                        >
                            <span v-if="form.processing">
                                Обработка...
                            </span>
                            <span v-else>
                                Обработать фотографии
                            </span>
                        </button>
                    </form>
                </div>

                <!-- Результаты -->
                <div
                    v-if="processedPhotos.length"
                    class="bg-white rounded-lg shadow-md p-6"
                >
                    <h2 class="text-xl font-bold mb-4">
                        Результаты обработки
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div
                            v-for="(photo, index) in processedPhotos"
                            :key="index"
                            class="border rounded-lg p-3"
                        >
                            <img
                                :src="photo.url"
                                class="w-full h-48 object-cover rounded mb-2"
                            />

                            <div class="space-y-1 text-sm">
                                <p class="font-medium">
                                    {{ photo.original_name }}
                                </p>
                                <p class="text-green-600">
                                    Было: {{ photo.original_size }}
                                </p>
                                <p class="text-blue-600">
                                    Стало: {{ photo.new_size }}
                                </p>
                                <p class="text-red-600">
                                    Сэкономлено: {{ photo.saved }}
                                </p>

                                <a
                                    :href="photo.url"
                                    download
                                    class="inline-block mt-2 text-blue-500 hover:text-blue-700 text-sm"
                                >
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
