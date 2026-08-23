<!-- resources/js/Components/ImageFormatSetting.vue -->
<script setup lang="ts">
import { ref, computed } from 'vue';

const props = withDefaults(
    defineProps<{
        allowOriginal?: boolean;
    }>(),
    {
        allowOriginal: true,
    },
);

type ImageFormat = 'original' | 'jpeg' | 'png' | 'webp';

interface FormatOption {
    value: ImageFormat;
    label: string;
    description: string;
    icon?: string;
}

const formats: FormatOption[] = [
    {
        value: 'original',
        label: 'Не менять формат',
        description: 'Сохранить исходный формат изображения',
        icon: '📄',
    },
    {
        value: 'jpeg',
        label: 'JPEG',
        description: 'Оптимально для фотографий, малый размер',
        icon: '🖼️',
    },
    {
        value: 'png',
        label: 'PNG',
        description: 'Без потерь, поддерживает прозрачность',
        icon: '🎨',
    },
    {
        value: 'webp',
        label: 'WebP',
        description: 'Современный формат, лучшее сжатие',
        icon: '⚡',
    },
];

// v-model для выбранного формата
const format = defineModel<ImageFormat>({ default: 'original' });

const availableFormats = computed(() =>
    props.allowOriginal
        ? formats
        : formats.filter((option) => option.value !== 'original'),
);

// Состояние открытия dropdown
const isOpen = ref(false);

// Вычисляемое свойство: выбранный формат
const selectedFormat = computed(() => {
    return (
        availableFormats.value.find((f) => f.value === format.value) ||
        availableFormats.value[0]
    );
});

// Безопасная установка формата
const setFormat = (value: ImageFormat) => {
    format.value = value;
    isOpen.value = false;
};
</script>

<template>
    <div class="relative">
        <!-- Триггер dropdown -->
        <button
            type="button"
            @click="isOpen = !isOpen"
            class="flex w-full cursor-pointer items-center justify-between rounded-lg border bg-white px-4 py-3 transition-all hover:border-blue-400 focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none"
            :class="{
                'border-blue-500 ring-2 ring-blue-200': isOpen,
                'border-gray-300': !isOpen,
            }"
        >
            <div class="flex items-center gap-3">
                <span class="text-xl">{{ selectedFormat.icon }}</span>
                <div class="text-left">
                    <div class="font-medium text-gray-900">
                        {{ selectedFormat.label }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ selectedFormat.description }}
                    </div>
                </div>
            </div>

            <!-- Стрелка -->
            <svg
                class="h-5 w-5 text-gray-400 transition-transform"
                :class="{ 'rotate-180': isOpen }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"
                />
            </svg>
        </button>

        <!-- Dropdown список -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <div
                v-if="isOpen"
                class="absolute z-10 mt-2 w-full overflow-hidden rounded-lg border border-gray-200 bg-white shadow-lg"
            >
                <div class="max-h-64 overflow-y-auto">
                    <button
                        v-for="option in availableFormats"
                        :key="option.value"
                        type="button"
                        @click="setFormat(option.value)"
                        class="flex w-full items-start gap-3 px-4 py-3 text-left transition-colors hover:bg-gray-50"
                        :class="{
                            'border-l-4 border-blue-500 bg-blue-50':
                                format === option.value,
                            'border-l-4 border-transparent':
                                format !== option.value,
                        }"
                    >
                        <span class="flex-shrink-0 text-xl">{{
                            option.icon
                        }}</span>
                        <div class="min-w-0 flex-1">
                            <div class="font-medium text-gray-900">
                                {{ option.label }}
                            </div>
                            <div class="mt-0.5 text-sm text-gray-600">
                                {{ option.description }}
                            </div>
                        </div>

                        <!-- Галочка для выбранного элемента -->
                        <svg
                            v-if="format === option.value"
                            class="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-600"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </Transition>
    </div>
</template>
