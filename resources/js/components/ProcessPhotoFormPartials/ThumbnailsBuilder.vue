<script setup lang="ts">
type Thumb = {
    width: number | null
    height: number | null
}

const thumbnails = defineModel<Thumb[]>({ default: [] })

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
    const num = value ? Math.max(1, Number(value)) : null

    thumbnails.value[index] = {
        ...thumbnails.value[index],
        [key]: num
    }
}
</script>

<template>
    <div class="mb-4">
        <div class="flex justify-between items-center mb-2">
            <label class="text-gray-700 font-medium">Миниатюры</label>

            <button
                type="button"
                @click="add"
                class="text-sm bg-blue-500 text-white px-2 py-1 rounded"
            >
                Добавить
            </button>
        </div>

        <div v-if="!thumbnails.length" class="text-sm text-gray-400">
            Нет миниатюр
        </div>

        <div v-for="(t, i) in thumbnails" :key="i" class="flex items-center space-x-2 mb-2">
            <input
                :value="t.width ?? ''"
                @input="update(i, 'width', ($event.target as HTMLInputElement).value)"
                type="number"
                placeholder="ширина"
                class="w-24 px-2 py-1 border rounded"
            />

            <input
                :value="t.height ?? ''"
                @input="update(i, 'height', ($event.target as HTMLInputElement).value)"
                type="number"
                placeholder="высота"
                class="w-24 px-2 py-1 border rounded"
            />

            <button @click="remove(i)" type="button" class="text-red-500">
                ✕
            </button>
        </div>
    </div>
</template>
