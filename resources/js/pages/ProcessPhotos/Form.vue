<script setup lang="ts">
import { Head, useForm, usePage, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import FlashMessages from '@/components/ProcessPhotoFormPartials/FlashMessages.vue'
import ImageCompressionSetting from '@/components/ProcessPhotoFormPartials/ImageCompressionSetting.vue'
import ImageFormatSetting from '@/components/ProcessPhotoFormPartials/ImageFormatSetting.vue'
import ImageMaxResolutionSetting from '@/components/ProcessPhotoFormPartials/ImageMaxResolutionSetting.vue'
import ImageOriginalFileNameSetting from '@/components/ProcessPhotoFormPartials/ImageOriginalFileNameSetting.vue'
import ImageUploaderWithPreview from '@/components/ProcessPhotoFormPartials/ImageUploaderWithPreview.vue'
import ThumbnailsBuilder from '@/components/ProcessPhotoFormPartials/ThumbnailsBuilder.vue'
import WatermarkSettings from '@/components/ProcessPhotoFormPartials/WatermarkSettings.vue'
import Wrapper from '@/components/ProcessPhotoFormPartials/Wrapper.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import FileList from '@/pages/ProcessPhotos/FileList.vue';
import type { PageProps } from '@/types/files'

const page = usePage<PageProps>()
const processedFiles = computed(() => page.props.files ?? [])
const flash = computed(() => page.props.flash ?? {})
const imageUploaderWithPreviewRef = ref(null)

// ✅ единый form
const form = useForm({
    files: [] as File[],

    compression: true,

    format: 'original' as 'original' | 'jpeg' | 'png' | 'webp',

    // Сохранять оригинальное имя файлов
    originalFileName: true,

    resolution: {
        width: 1920 as number | null,
        height: 1080 as number | null
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

            if (imageUploaderWithPreviewRef.value) {
                (imageUploaderWithPreviewRef.value as any).clearFiles()
            }
        },
    })
}

// ✅ Удаление одного файла
const deleteFile = (id: number) => {
    router.delete(`/files/${id}`, {
        preserveScroll: true,
        onSuccess: () => {
            // Inertia автоматически обновит список файлов,
            // так как контроллер вернет новый render с обновленными props
        },
    });
};

// ✅ Удаление всех файлов
const deleteAllFiles = () => {
    router.delete('/files', {
        preserveScroll: true,
        onSuccess: () => {
            // Список файлов очистится автоматически после ответа сервера
        },
    });
};
</script>

<template>
    <Head
        title="Обработка фотографий для вашего сайта"
    />

    <AppLayout>
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

                <FlashMessages :flash="flash" />

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
                        <h3 class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-cog mr-2"></i>
                            <span>Настройки обработки</span>
                        </h3>

                        <Wrapper :title="'Формат'" :class="'z-100'">
                            <ImageFormatSetting
                                v-model="form.format"
                            />
                        </Wrapper>

                        <Wrapper :title="'Сохранять оригинальное имя файла'">
                            <ImageOriginalFileNameSetting
                                v-model="form.originalFileName"
                            />
                        </Wrapper>

                        <Wrapper :title="'Оптимизировать для веб'">
                            <ImageCompressionSetting
                                v-model="form.compression"
                            />
                        </Wrapper>

                        <Wrapper :title="'Максимальное разрешение в пикселах'">
                            <ImageMaxResolutionSetting
                                v-model="form.resolution"
                            />
                        </Wrapper>

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
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
                        :processedFiles="processedFiles || []"
                        @delete="deleteFile"
                        @delete-all="deleteAllFiles"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
