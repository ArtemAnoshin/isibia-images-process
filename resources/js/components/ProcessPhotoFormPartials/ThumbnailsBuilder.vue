<script setup lang="ts">
type Thumb = {
    width: number | null
    height: number | null
}

const thumbnails = defineModel<Thumb[]>({
    default: () => [
        { width: 400, height: 300 },
        { width: 150, height: 150 },
    ],
})

const MAX = 5

const add = () => {
    if (thumbnails.value.length >= MAX) {
        return
    }

    thumbnails.value.push({ width: null, height: null })
}

const remove = (index: number) => {
    thumbnails.value.splice(index, 1)
}

const update = (index: number, key: 'width' | 'height', value: string) => {
    const num = value ? Math.max(1, Math.floor(Number(value))) : null
    thumbnails.value[index] = { ...thumbnails.value[index], [key]: num }
}

const formatLabel = (thumb: Thumb) => {
    if (thumb.width && thumb.height) {
        return `${thumb.width}×${thumb.height}px`
    }

    if (thumb.width) {
        return `↔ ${thumb.width}px`
    }

    if (thumb.height) {
        return `↕ ${thumb.height}px`
    }

    return 'Не задано'
}
</script>

<template>
    <div class="setting-checkbox-container w-full px-4 py-3 bg-white border rounded-lg transition-all hover:border-blue-400 border-gray-300">
        <div class="flex items-center justify-between mb-3">
            <span class="font-medium text-gray-900">Миниатюры</span>
            <button
                type="button"
                @click="add"
                :disabled="thumbnails.length >= MAX"
                class="text-sm px-3 py-1.5 rounded-lg transition-all"
                :class="thumbnails.length >= MAX
                    ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                    : 'bg-blue-50 text-blue-600 hover:bg-blue-100 font-medium'"
            >
                <i class="fas fa-plus mr-1"></i>
                Добавить
            </button>
        </div>

        <!-- Пустое состояние -->
        <div
            v-if="!thumbnails.length"
            class="text-sm text-gray-400 text-center py-4 border-2 border-dashed border-gray-200 rounded-lg"
        >
            <i class="fas fa-images text-2xl mb-1 block"></i>
            Нет миниатюр. Нажмите «Добавить».
        </div>

        <!-- Список миниатюр -->
        <div class="space-y-2">
            <div
                v-for="(thumb, index) in thumbnails"
                :key="index"
                class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg group hover:bg-gray-100 transition-colors"
            >
                <!-- Номер -->
                <span class="text-xs text-gray-400 w-5 text-center flex-shrink-0">
                    {{ index + 1 }}
                </span>

                <!-- Поля ввода -->
                <div class="flex items-center gap-1.5 flex-1">
                    <input
                        :value="thumb.width ?? ''"
                        @input="update(index, 'width', ($event.target as HTMLInputElement).value)"
                        type="number"
                        min="1"
                        placeholder="Ширина"
                        class="w-full px-2.5 py-1.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    <span class="text-gray-400 text-sm flex-shrink-0">×</span>
                    <input
                        :value="thumb.height ?? ''"
                        @input="update(index, 'height', ($event.target as HTMLInputElement).value)"
                        type="number"
                        min="1"
                        placeholder="Высота"
                        class="w-full px-2.5 py-1.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>

                <!-- Бейдж с разрешением -->
                <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded border border-gray-200 flex-shrink-0 hidden sm:inline-block">
                    {{ formatLabel(thumb) }}
                </span>

                <!-- Кнопка удаления -->
                <button
                    @click="remove(index)"
                    type="button"
                    class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded hover:bg-red-50 flex-shrink-0"
                    title="Удалить"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Подсказка -->
        <p class="text-xs text-gray-400 mt-2">
            Миниатюры создаются с сохранением пропорций. Максимум {{ MAX }} шт.
        </p>
    </div>
</template>
