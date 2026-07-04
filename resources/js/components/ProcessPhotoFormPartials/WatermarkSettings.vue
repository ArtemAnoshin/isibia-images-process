<script setup lang="ts">
import WatermarkPositioner from '@/components/ProcessPhotoFormPartials/WatermarkPositioner.vue'

const wm = defineModel<any>()

const handleFile = (e: Event) => {
    const input = e.target as HTMLInputElement

    if (!input.files?.length) {
        return
    }

    wm.value.image = input.files[0]
}
</script>

<template>
    <div class="mb-4">
        <label class="flex items-center space-x-2 mb-3">
            <input type="checkbox" v-model="wm.enabled" />
            <span>Водяной знак</span>
        </label>

        <div v-if="wm.enabled" class="space-y-3">
            <select v-model="wm.type" class="w-full border px-2 py-1 rounded">
                <option value="text">Текст</option>
                <option value="image">Картинка</option>
            </select>

            <div v-if="wm.type === 'text'">
                <input
                    v-model="wm.text"
                    placeholder="Текст"
                    class="w-full border px-2 py-1 rounded"
                />
            </div>

            <div v-if="wm.type === 'image'">
                <input type="file" accept="image/*" @change="handleFile" />
            </div>

            <WatermarkPositioner v-model="wm" />

            <div class="border rounded p-2 text-sm text-gray-400">
                Прозрачность
            </div>

            <input
                type="range"
                min="0"
                max="100"
                v-model.number="wm.opacity"
                class="w-full"
            />
        </div>
    </div>
</template>
