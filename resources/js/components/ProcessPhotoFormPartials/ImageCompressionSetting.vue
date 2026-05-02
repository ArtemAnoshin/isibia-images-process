<script setup lang="ts">
import { computed } from 'vue'

// v-model (современный способ)
const compression = defineModel<number>({ default: 70 })

// настройки
const MIN = 10
const MAX = 90
const STEP = 5

// защита от выхода за пределы
const safeCompression = computed({
    get: () => compression.value,
    set: (val: number) => {
        const clamped = Math.min(MAX, Math.max(MIN, val))
        compression.value = clamped
    }
})

// текстовое описание (UX!)
const compressionLabel = computed(() => {
    const value = compression.value

    if (value <= 30) {
        return 'Минимальное (лучшее качество)'
    }

    if (value <= 60) {
        return 'Среднее'
    }

    return 'Максимальное (сильное сжатие)'
})
</script>

<template>
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">
            Сжатие: {{ compression }}%
            <span class="text-gray-500 text-sm">
                ({{ compressionLabel }})
            </span>
        </label>

        <input
            v-model="safeCompression"
            type="range"
            :min="MIN"
            :max="MAX"
            :step="STEP"
            class="w-full"
        />

        <!-- шкала -->
        <div class="flex justify-between text-xs text-gray-400 mt-1">
            <span>Качество</span>
            <span>Баланс</span>
            <span>Размер</span>
        </div>
    </div>
</template>
