<!-- resources/js/Components/ImageFormatSetting.vue -->
<script setup lang="ts">
import { ref, computed } from 'vue'

type ImageFormat = 'original' | 'jpeg' | 'png' | 'webp'

interface FormatOption {
    value: ImageFormat
    label: string
    description: string
    icon?: string
}

const formats: FormatOption[] = [
    {
        value: 'original',
        label: 'Не менять формат',
        description: 'Сохранить исходный формат изображения',
        icon: '📄'
    },
    {
        value: 'jpeg',
        label: 'JPEG',
        description: 'Оптимально для фотографий, малый размер',
        icon: '🖼️'
    },
    {
        value: 'png',
        label: 'PNG',
        description: 'Без потерь, поддерживает прозрачность',
        icon: '🎨'
    },
    {
        value: 'webp',
        label: 'WebP',
        description: 'Современный формат, лучшее сжатие',
        icon: '⚡'
    }
]

// v-model для выбранного формата
const format = defineModel<ImageFormat>({ default: 'original' })

// Состояние открытия dropdown
const isOpen = ref(false)

// Вычисляемое свойство: выбранный формат
const selectedFormat = computed(() => {
    return formats.find(f => f.value === format.value) || formats[0]
})

// Безопасная установка формата
const setFormat = (value: ImageFormat) => {
    format.value = value
    isOpen.value = false
}

</script>

<template>
    <div class="relative">
        <!-- Триггер dropdown -->
        <button
            type="button"
            @click="isOpen = !isOpen"
            class="w-full flex items-center justify-between px-4 py-3 bg-white border rounded-lg cursor-pointer transition-all hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            :class="{
                'border-blue-500 ring-2 ring-blue-200': isOpen,
                'border-gray-300': !isOpen
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
                class="w-5 h-5 text-gray-400 transition-transform"
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
                class="absolute z-10 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden"
            >
                <div class="max-h-64 overflow-y-auto">
                    <button
                        v-for="option in formats"
                        :key="option.value"
                        type="button"
                        @click="setFormat(option.value)"
                        class="w-full flex items-start gap-3 px-4 py-3 text-left transition-colors hover:bg-gray-50"
                        :class="{
                            'bg-blue-50 border-l-4 border-blue-500': format === option.value,
                            'border-l-4 border-transparent': format !== option.value
                        }"
                    >
                        <span class="text-xl flex-shrink-0">{{ option.icon }}</span>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-gray-900">
                                {{ option.label }}
                            </div>
                            <div class="text-sm text-gray-600 mt-0.5">
                                {{ option.description }}
                            </div>
                        </div>

                        <!-- Галочка для выбранного элемента -->
                        <svg
                            v-if="format === option.value"
                            class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"
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
