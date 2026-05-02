<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'

const props = defineProps<{
    modelValue: {
        image: File | null
        x: number
        y: number
        scale: number
    }
}>()

const emit = defineEmits(['update:modelValue'])

const canvasRef = ref<HTMLCanvasElement | null>(null)

let ctx: CanvasRenderingContext2D | null = null

const watermarkImg = new Image()

const dragging = ref(false)
let offsetX = 0
let offsetY = 0

// загрузка изображения
watch(() => props.modelValue.image, (file) => {
    if (!file) {
        return
    }

    const url = URL.createObjectURL(file)

    watermarkImg.src = url

    watermarkImg.onload = () => {
        draw()
    }
})

// canvas init
onMounted(() => {
    if (!canvasRef.value) {
        return
    }

    canvasRef.value.width = 400
    canvasRef.value.height = 300

    ctx = canvasRef.value.getContext('2d')

    draw()
})

// отрисовка
const draw = () => {
    if (!ctx || !canvasRef.value) {
        return
    }

    const { width, height } = canvasRef.value

    ctx.clearRect(0, 0, width, height)

    // фон (заглушка)
    ctx.fillStyle = '#eee'
    ctx.fillRect(0, 0, width, height)

    if (!watermarkImg.src) {
        return
    }

    const { x, y, scale } = props.modelValue

    const w = watermarkImg.width * scale
    const h = watermarkImg.height * scale

    ctx.globalAlpha = 0.7
    ctx.drawImage(watermarkImg, x, y, w, h)
}

// drag start
const onMouseDown = (e: MouseEvent) => {
    dragging.value = true

    offsetX = e.offsetX - props.modelValue.x
    offsetY = e.offsetY - props.modelValue.y
}

// drag move
const onMouseMove = (e: MouseEvent) => {
    if (!dragging.value) {
        return
    }

    const newX = e.offsetX - offsetX
    const newY = e.offsetY - offsetY

    update({ x: newX, y: newY })
}

// drag end
const onMouseUp = () => {
    dragging.value = false
}

// обновление модели
const update = (patch: Partial<typeof props.modelValue>) => {
    emit('update:modelValue', {
        ...props.modelValue,
        ...patch
    })

    draw()
}

// масштаб
const updateScale = (value: number) => {
    update({ scale: value })
}
</script>

<template>
    <div class="space-y-2">
        <canvas
            ref="canvasRef"
            class="border rounded cursor-move"
            @mousedown="onMouseDown"
            @mousemove="onMouseMove"
            @mouseup="onMouseUp"
            @mouseleave="onMouseUp"
        />

        <div>
            <label class="text-sm text-gray-600">
                Размер watermark
            </label>

            <input
                type="range"
                min="0.1"
                max="2"
                step="0.1"
                :value="modelValue.scale"
                @input="updateScale(Number(($event.target as HTMLInputElement).value))"
                class="w-full"
            />
        </div>
    </div>
</template>
