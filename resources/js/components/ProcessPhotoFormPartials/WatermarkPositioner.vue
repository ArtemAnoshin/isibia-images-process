<script setup lang="ts">
import { ref } from 'vue'
import { computed } from 'vue'

const wm = defineModel<any>()

const containerRef = ref<HTMLDivElement | null>(null)

const dragging = ref(false)

let startX = 0
let startY = 0
let initialX = 0
let initialY = 0

// старт перетаскивания
const onMouseDown = (e: MouseEvent) => {
    dragging.value = true

    startX = e.clientX
    startY = e.clientY

    initialX = wm.value.x
    initialY = wm.value.y
}

// движение
const onMouseMove = (e: MouseEvent) => {
    if (!dragging.value) {
        return
    }

    const dx = e.clientX - startX
    const dy = e.clientY - startY

    wm.value.x = initialX + dx
    wm.value.y = initialY + dy
}

// отпускание
const onMouseUp = () => {
    dragging.value = false
}

const imageUrl = computed(() => {
    if (!wm.value.image) {
        return null
    }

    return URL.createObjectURL(wm.value.image)
})
</script>

<template>
    <div
        ref="containerRef"
        class="relative w-[400px] h-[300px] bg-gray-200 border rounded overflow-hidden"
        @mousemove="onMouseMove"
        @mouseup="onMouseUp"
        @mouseleave="onMouseUp"
    >
        <!-- Watermark -->
        <div
            v-if="wm.type === 'text' || wm.image"
            class="absolute cursor-move select-none"
            :style="{
                transform: `translate(${wm.x}px, ${wm.y}px) scale(${wm.scale})`,
                transformOrigin: 'top left'
            }"
            @mousedown.stop="onMouseDown"
        >
            <!-- Текст -->
            <div
                v-if="wm.type === 'text'"
                class="bg-black/50 text-white px-2 py-1 rounded text-sm"
            >
                {{ wm.text || 'Watermark' }}
            </div>

            <!-- Картинка -->
            <img
                v-if="wm.type === 'image' && imageUrl"
                :src="imageUrl"
                class="max-w-[150px] pointer-events-none"
            />
        </div>
    </div>

    <!-- Scale -->
    <div class="mt-2">
        <label class="text-sm text-gray-600">
            Размер watermark
        </label>

        <input
            type="range"
            min="0.2"
            max="2"
            step="0.1"
            v-model.number="wm.scale"
            class="w-full"
        />
    </div>
</template>
