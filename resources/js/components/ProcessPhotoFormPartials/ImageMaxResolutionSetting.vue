<script setup lang="ts">
import { computed } from 'vue'

type Resolution = {
    width: number | null
    height: number | null
}

const resolution = defineModel<Resolution>({
    default: () => ({
        width: 1920,
        height: 1080,
    }),
})

const MIN = 1
const MAX = 10000

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

const updateWidth = (value: string) => {
    resolution.value = { ...resolution.value, width: normalize(value) }
}

const updateHeight = (value: string) => {
    resolution.value = { ...resolution.value, height: normalize(value) }
}

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

    return `Высота до ${height}px`
})

const hasRestriction = computed(() => resolution.value.width !== null || resolution.value.height !== null)

const clearResolution = () => {
    resolution.value = { width: null, height: null }
}
</script>

<template>
    <div class="setting-checkbox-container w-full px-4 py-3 bg-white border rounded-lg transition-all hover:border-blue-400 border-gray-300">
        <div class="flex items-center justify-between mb-3">
            <span class="font-medium text-gray-900">Максимальное разрешение</span>
            <div class="setting-badge" :class="{ active: hasRestriction }">
                <i :class="hasRestriction ? 'fas fa-expand' : 'fas fa-ban'"></i>
                <span>{{ resolutionLabel }}</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex-1">
                <label class="block text-sm text-gray-600 mb-1">Ширина (px)</label>
                <input
                    :value="resolution.width ?? ''"
                    @input="updateWidth(($event.target as HTMLInputElement).value)"
                    type="number"
                    :min="MIN"
                    :max="MAX"
                    placeholder="1920"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>

            <span class="text-gray-400 mt-5">×</span>

            <div class="flex-1">
                <label class="block text-sm text-gray-600 mb-1">Высота (px)</label>
                <input
                    :value="resolution.height ?? ''"
                    @input="updateHeight(($event.target as HTMLInputElement).value)"
                    type="number"
                    :min="MIN"
                    :max="MAX"
                    placeholder="1080"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>
        </div>

        <div class="flex items-center justify-between mt-2">
            <p class="text-xs text-gray-400">
                Пропорции сохраняются. Оставьте пустым для отключения.
            </p>
            <button
                v-if="hasRestriction"
                @click="clearResolution"
                type="button"
                class="text-xs text-red-500 hover:text-red-700 transition-colors"
            >
                Сбросить
            </button>
        </div>
    </div>
</template>
