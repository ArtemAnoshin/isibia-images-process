<script setup lang="ts">
import { computed } from 'vue'

type Resolution = {
    width: number | null
    height: number | null
}

// современный v-model
const resolution = defineModel<Resolution>({
    default: {
        width: null,
        height: null
    }
})

// ограничения
const MIN = 1
const MAX = 10000

// нормализация значения
const normalize = (value: string): number | null => {
    if (!value) {
        return null
    }

    const num = Number(value)

    if (isNaN(num)) {
        return null
    }

    return Math.min(MAX, Math.max(MIN, Math.floor(num)))
}

// обновление ширины
const updateWidth = (value: string) => {
    resolution.value = {
        ...resolution.value,
        width: normalize(value)
    }
}

// обновление высоты
const updateHeight = (value: string) => {
    resolution.value = {
        ...resolution.value,
        height: normalize(value)
    }
}

// удобный текст для UX
const resolutionLabel = computed(() => {
    const { width, height } = resolution.value

    if (!width && !height) {
        return 'Без ограничений'
    }

    if (width && height) {
        return `${width} × ${height}px`
    }

    if (width) {
        return `Ширина до ${width}px`
    }

    if (height) {
        return `Высота до ${height}px`
    }

    return ''
})
</script>

<template>
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">
            Максимальное разрешение
            <span class="text-gray-500 text-sm">
                ({{ resolutionLabel }})
            </span>
        </label>

        <div class="flex space-x-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Ширина (px)
                </label>

                <input
                    :value="resolution.width ?? ''"
                    @input="updateWidth(($event.target as HTMLInputElement).value)"
                    type="number"
                    :min="MIN"
                    :max="MAX"
                    placeholder="например: 1920"
                    class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Высота (px)
                </label>

                <input
                    :value="resolution.height ?? ''"
                    @input="updateHeight(($event.target as HTMLInputElement).value)"
                    type="number"
                    :min="MIN"
                    :max="MAX"
                    placeholder="например: 1080"
                    class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
        </div>

        <p class="text-sm text-gray-500 mt-1">
            Изображения будут уменьшены, чтобы вписаться в заданные размеры с сохранением пропорций.
        </p>
    </div>
</template>
