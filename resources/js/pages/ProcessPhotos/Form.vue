<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import ImageCompressionSetting from '@/components/ProcessPhotoFormPartials/ImageCompressionSetting.vue'
import ImageMaxResolutionSetting from '@/components/ProcessPhotoFormPartials/ImageMaxResolutionSetting.vue'
import ImageUploaderWithPreview from '@/components/ProcessPhotoFormPartials/ImageUploaderWithPreview.vue'
import ThumbnailsBuilder from '@/components/ProcessPhotoFormPartials/ThumbnailsBuilder.vue'
import WatermarkSettings from '@/components/ProcessPhotoFormPartials/WatermarkSettings.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import FileList from '@/pages/ProcessPhotos/FileList.vue';

const breadcrumbs = [
    { title: 'Process Photos', href: '/process-photos' }
]

type PageProps = {
    flash: {
        success?: string
        processed?: {
            isArchive: boolean
            downloadUrl: string
            files: {
                filename: string
                url: string
            }[]
        }
    }
}

const page = usePage<PageProps>()
const imageUploaderWithPreviewRef = ref(null)

defineProps({
    processedFiles: {
        type: Array,
        default: () => []
    },
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

    form.post('/process-photos', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('files')

            // Очищаем файлы в компоненте
            if (imageUploaderWithPreviewRef.value) {
                imageUploaderWithPreviewRef.value.clearFiles()
            }
        },
    })
}

// Удаление файла
const deleteFile = (id) => {
    // Здесь будет запрос на удаление
    // form.delete(`/files/${id}`);
    console.log('Delete file:', id);
};

// Удаление всех файлов
const deleteAllFiles = () => {
    // Здесь будет запрос на удаление всех
    // form.delete('/files');
    console.log('Delete all files');
};
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
                    v-if="page.props.flash.success"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
                >
                    {{ page.props.flash.success }}
                </div>

                <div
                    v-if="page.props.flash.processed"
                    class="bg-white rounded-lg shadow-md p-6"
                >
                    <h2 class="text-xl font-bold mb-4">
                        Результат обработки
                    </h2>

                    <!-- main download -->

                    <div class="mb-4">
                        <a
                            :href="page.props.flash.processed.downloadUrl"
                            download
                            class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                        >
                            Скачать результат
                        </a>
                    </div>

                    <!-- files -->

                    <!-- Если это архив - показываем одну ссылку -->
                    <div v-if="page.props.flash.processed.isArchive"
                        class="flex items-center justify-between border rounded p-3 bg-blue-50">
                        <div>
                            <span class="font-medium">📦 Архив</span>
                            <span class="text-sm text-gray-600 ml-2">
                                ({{ page.props.flash.processed.files?.length || 0 }} файлов)
                            </span>
                        </div>
                        <a
                            :href="page.props.flash.processed.downloadUrl"
                            download
                            class="text-blue-500 hover:underline font-medium"
                        >
                            ⬇ Скачать архив
                        </a>
                    </div>

                    <div v-else class="space-y-2">
                        <div
                            v-for="file in page.props.flash.processed.files"
                            :key="file.filename"
                            class="flex items-center justify-between border rounded p-2"
                        >
                            <span>
                                {{ file.filename }}
                            </span>

                            <a
                                :href="file.url"
                                download
                                class="text-blue-500 hover:underline"
                            >
                                Скачать
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Форма -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <form @submit.prevent="submit">
                        <!-- Upload -->
                        <div class="mb-6">
                            <ImageUploaderWithPreview
                                ref="imageUploaderWithPreviewRef"
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

                    <!-- Компонент со списком файлов -->
                    <FileList
                        :processedFiles="$page.props.files || []"
                        @delete="deleteFile"
                        @delete-all="deleteAllFiles"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
