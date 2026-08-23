<script setup lang="ts">
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import FlashMessages from '@/components/ProcessPhotoFormPartials/FlashMessages.vue';
import ImageCompressionSetting from '@/components/ProcessPhotoFormPartials/ImageCompressionSetting.vue';
import ImageFormatSetting from '@/components/ProcessPhotoFormPartials/ImageFormatSetting.vue';
import ImageMaxResolutionSetting from '@/components/ProcessPhotoFormPartials/ImageMaxResolutionSetting.vue';
import ImageOriginalFileNameSetting from '@/components/ProcessPhotoFormPartials/ImageOriginalFileNameSetting.vue';
import ImageUploaderWithPreview from '@/components/ProcessPhotoFormPartials/ImageUploaderWithPreview.vue';
import ThumbnailsBuilder from '@/components/ProcessPhotoFormPartials/ThumbnailsBuilder.vue';
import Wrapper from '@/components/ProcessPhotoFormPartials/Wrapper.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import FileList from '@/pages/ProcessPhotos/FileList.vue';
import type { PageProps } from '@/types/files';

const page = usePage<PageProps>();
const processedFiles = computed(() => page.props.files ?? []);
const flash = computed(() => page.props.flash ?? {});
const tool = computed(() => page.props.tool ?? 'batch');
const isBatchTool = computed(() => tool.value === 'batch');
const isConverterTool = computed(() => tool.value === 'converter');
const isThumbnailsTool = computed(() => tool.value === 'thumbnails');
const pageTitle = computed(() =>
    tool.value === 'optimizer'
        ? 'Оптимизация изображений для сайта онлайн'
        : tool.value === 'converter'
          ? 'Конвертер изображений онлайн — JPG, PNG и WebP'
          : tool.value === 'thumbnails'
            ? 'Создать миниатюры изображений онлайн'
            : 'Пакетная обработка изображений онлайн — JPG, PNG, WebP',
);
const formTitle = computed(() =>
    tool.value === 'optimizer'
        ? 'Оптимизация изображений для веба'
        : tool.value === 'converter'
          ? 'Изменение формата изображений'
          : tool.value === 'thumbnails'
            ? 'Создание миниатюр изображений'
            : 'Настройки обработки фотографий',
);
const formDescription = computed(() =>
    tool.value === 'optimizer'
        ? 'Загрузите изображения — оптимальные настройки уже выбраны'
        : tool.value === 'converter'
          ? 'Загрузите изображения и выберите новый формат'
          : tool.value === 'thumbnails'
            ? 'Загрузите изображения и укажите размеры миниатюр'
            : 'Загрузите фотографии и настройте параметры обработки',
);
const submitLabel = computed(() =>
    tool.value === 'optimizer'
        ? 'Оптимизировать изображения'
        : tool.value === 'converter'
          ? 'Изменить формат'
          : tool.value === 'thumbnails'
            ? 'Создать миниатюры'
            : 'Обработать фотографии',
);
const imageUploaderWithPreviewRef = ref(null);
const isEmbeddedInPublicPage =
    typeof document !== 'undefined' &&
    document.querySelector('[data-public-home]') !== null;

// ✅ единый form
const form = useForm({
    files: [] as File[],

    compression: tool.value !== 'converter',

    format: (tool.value === 'converter' ? 'webp' : 'original') as
        | 'original'
        | 'jpeg'
        | 'png'
        | 'webp',

    // Сохранять оригинальное имя файлов
    originalFileName: true,

    includeOriginal: true,

    resolution: {
        width: (tool.value === 'converter' ? null : 1920) as number | null,
        height: (tool.value === 'converter' ? null : 1080) as number | null,
    },

    thumbnails: (tool.value === 'thumbnails'
        ? [
              { width: 400, height: 300 },
              { width: 150, height: 150 },
          ]
        : []) as { width: number | null; height: number | null }[],

    /*watermark: {
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
    }*/
});

// 🚀 submit
const submit = () => {
    if (!form.files.length) {
        alert('Добавьте хотя бы одно изображение');

        return;
    }

    if (tool.value === 'thumbnails' && !form.thumbnails.length) {
        alert('Добавьте хотя бы один размер миниатюры');

        return;
    }

    form.transform((data) => ({
        ...data,
        source: tool.value,
        ...(tool.value === 'optimizer'
            ? {
                  compression: true,
                  format: 'original' as const,
                  originalFileName: true,
                  includeOriginal: true,
                  resolution: { width: 1920, height: 1080 },
                  thumbnails: [],
              }
            : {}),
        ...(tool.value === 'converter'
            ? {
                  compression: false,
                  originalFileName: true,
                  includeOriginal: true,
                  resolution: { width: null, height: null },
                  thumbnails: [],
              }
            : {}),
        ...(tool.value === 'thumbnails'
            ? {
                  compression: false,
                  format: 'original' as const,
                  originalFileName: true,
                  includeOriginal: false,
                  resolution: { width: null, height: null },
              }
            : {}),
    })).post('/process-photos', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('files');

            if (imageUploaderWithPreviewRef.value) {
                (imageUploaderWithPreviewRef.value as any).clearFiles();
            }
        },
    });
};

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
    <Head :title="pageTitle" />

    <AppLayout>
        <div class="container mx-auto px-4 py-8">
            <div class="mx-auto max-w-4xl">
                <!-- Заголовок -->
                <div class="mb-6 rounded-lg bg-white p-6 shadow-md">
                    <div
                        class="flex flex-wrap items-center justify-between gap-4"
                    >
                        <div>
                            <component
                                :is="isEmbeddedInPublicPage ? 'h2' : 'h1'"
                                class="text-2xl font-bold"
                            >
                                {{ formTitle }}
                            </component>
                            <p class="text-gray-600">{{ formDescription }}</p>
                        </div>
                        <a
                            href="/about-developer"
                            class="inline-flex transform items-center rounded-lg bg-gradient-to-r from-blue-600 to-green-400 px-6 py-3 font-semibold text-white shadow-md transition-all duration-300 hover:-translate-y-0.5 hover:from-blue-700 hover:to-green-500 hover:shadow-lg"
                        >
                            <svg
                                class="mr-2 h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
                            Знакомство с разработчиком
                        </a>
                    </div>
                </div>

                <FlashMessages :flash="flash" />

                <!-- Форма -->
                <div class="mb-6 rounded-lg bg-white p-6 shadow-md">
                    <form @submit.prevent="submit">
                        <!-- Upload -->
                        <div class="mb-6">
                            <ImageUploaderWithPreview
                                ref="imageUploaderWithPreviewRef"
                                @update:files="form.files = $event"
                            />
                        </div>

                        <template v-if="isBatchTool">
                            <!-- Настройки полного инструмента -->
                            <h3 class="mb-2 block font-bold text-gray-700">
                                <i class="fas fa-cog mr-2"></i>
                                <span>Настройки обработки</span>
                            </h3>

                            <Wrapper
                                :title="'Формат изображений'"
                                :class="'z-100'"
                                :icon="'fas fa-file-image'"
                            >
                                <ImageFormatSetting v-model="form.format" />
                            </Wrapper>

                            <Wrapper
                                :title="'Сохранять оригинальное имя файла'"
                                :icon="'fas fa-file-signature'"
                            >
                                <ImageOriginalFileNameSetting
                                    v-model="form.originalFileName"
                                />
                            </Wrapper>

                            <Wrapper
                                :title="'Оптимизировать для веб'"
                                :icon="'fas fa-compress-arrows-alt'"
                            >
                                <ImageCompressionSetting
                                    v-model="form.compression"
                                />
                            </Wrapper>

                            <Wrapper
                                :title="'Максимальное разрешение в пикселах'"
                                :icon="'fas fa-expand'"
                            >
                                <ImageMaxResolutionSetting
                                    v-model="form.resolution"
                                />
                            </Wrapper>

                            <Wrapper
                                :title="'Добавить миниатюры'"
                                :accent="'border-green-200'"
                                :icon="'fas fa-images'"
                            >
                                <ThumbnailsBuilder v-model="form.thumbnails" />
                            </Wrapper>
                        </template>

                        <template v-else-if="isConverterTool">
                            <h3 class="mb-2 block font-bold text-gray-700">
                                <i class="fas fa-file-image mr-2"></i>
                                <span>Целевой формат</span>
                            </h3>
                            <Wrapper
                                :title="'Выберите новый формат'"
                                :class="'z-100'"
                                :icon="'fas fa-file-image'"
                            >
                                <ImageFormatSetting
                                    v-model="form.format"
                                    :allow-original="false"
                                />
                            </Wrapper>
                            <div
                                class="mb-6 flex items-start gap-3 rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900"
                            >
                                <i class="fas fa-info-circle mt-0.5"></i>
                                <p>
                                    Будет изменён только формат. Размер,
                                    разрешение и имена файлов сохранятся.
                                </p>
                            </div>
                        </template>

                        <template v-else-if="isThumbnailsTool">
                            <h3 class="mb-2 block font-bold text-gray-700">
                                <i class="fas fa-images mr-2"></i>
                                <span>Размеры миниатюр</span>
                            </h3>
                            <Wrapper
                                :title="'Добавить миниатюры'"
                                :accent="'border-green-200'"
                                :icon="'fas fa-images'"
                            >
                                <ThumbnailsBuilder v-model="form.thumbnails" />
                            </Wrapper>
                            <div
                                class="mb-6 flex items-start gap-3 rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900"
                            >
                                <i class="fas fa-info-circle mt-0.5"></i>
                                <p>
                                    Будут созданы только миниатюры выбранных
                                    размеров. Формат и пропорции исходных
                                    изображений сохранятся.
                                </p>
                            </div>
                        </template>

                        <div
                            v-else
                            class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-900"
                        >
                            <i class="fas fa-check-circle mt-0.5"></i>
                            <p>
                                Будет выбрано оптимальное сжатие без заметной
                                потери качества. Максимальное разрешение —
                                1920×1080 пикселей, формат и имена файлов будут
                                сохранены.
                            </p>
                        </div>

                        <!--<div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <WatermarkSettings
                                v-model="form.watermark"
                            />
                        </div>-->

                        <!-- Кнопка -->
                        <button
                            type="submit"
                            :disabled="form.processing || !form.files.length"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-3 font-medium text-white shadow-md transition-all duration-200 hover:from-blue-600 hover:to-blue-700 hover:shadow-lg active:scale-[0.98] disabled:cursor-not-allowed disabled:from-gray-300 disabled:to-gray-400"
                        >
                            <span v-if="form.processing"> Обработка... </span>
                            <span v-else>{{ submitLabel }}</span>
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
