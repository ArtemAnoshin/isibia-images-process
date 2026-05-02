<script setup lang="ts">
import { ref, onBeforeUnmount } from 'vue'

type SelectedFile = {
    file: File
    preview: string
    name: string
    size: number
}

// состояние
const selectedFiles = ref<SelectedFile[]>([])
const fileInput = ref<HTMLInputElement | null>(null)

const emit = defineEmits<{
    (e: 'update:files', files: File[]): void
}>()

// настройки
const MAX_FILE_SIZE_MB = 10
const MAX_FILES = 10

// формат размера
const formatFileSize = (bytes: number): string => {
    const sizes = ['B', 'KB', 'MB', 'GB']

    if (bytes === 0) {
        return '0 B'
    }

    const i = Math.floor(Math.log(bytes) / Math.log(1024))

    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i]
}

// emit наружу
const emitFiles = () => {
    emit('update:files', selectedFiles.value.map(f => f.file))
}

// проверка файла
const validateFile = (file: File): string | null => {
    if (!file.type.startsWith('image/')) {
        return 'Файл не является изображением'
    }

    if (file.size > MAX_FILE_SIZE_MB * 1024 * 1024) {
        return `Файл больше ${MAX_FILE_SIZE_MB}MB`
    }

    return null
}

// обработка выбора
const handleFileSelect = (event: Event) => {
    const input = event.target as HTMLInputElement

    if (!input.files) {
        return
    }

    const files = Array.from(input.files)

    const availableSlots = MAX_FILES - selectedFiles.value.length

    if (availableSlots <= 0) {
        alert(`Максимум ${MAX_FILES} файлов`)

        return
    }

    if (files.length > availableSlots) {
        alert(`Можно добавить только ${availableSlots} файлов`)
    }

    const filesToAdd = files.slice(0, availableSlots)

    filesToAdd.forEach(file => {
        // валидация
        const error = validateFile(file)

        if (error) {
            alert(`${file.name}: ${error}`)

            return
        }

        // защита от дублей
        const exists = selectedFiles.value.some(
            f => f.name === file.name && f.size === file.size
        )

        if (exists) {
            return
        }

        const previewUrl = URL.createObjectURL(file)

        selectedFiles.value.push({
            file,
            preview: previewUrl,
            name: file.name,
            size: file.size
        })
    })

    emitFiles()

    // сброс input
    if (fileInput.value) {
        fileInput.value.value = ''
    }
}

// удаление
const removeFile = (index: number) => {
    const file = selectedFiles.value[index]

    // освобождаем память
    URL.revokeObjectURL(file.preview)

    selectedFiles.value.splice(index, 1)

    emitFiles()
}

// очистка при размонтировании компонента
onBeforeUnmount(() => {
    selectedFiles.value.forEach(f => {
        URL.revokeObjectURL(f.preview)
    })
})
</script>

<template>
    <div>
        <label class="block text-gray-700 font-bold mb-2">
            Выберите фотографии
        </label>

        <input
            type="file"
            ref="fileInput"
            @change="handleFileSelect"
            multiple
            accept="image/*"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <p class="text-sm text-gray-500 mt-1">
            Можно выбрать несколько фотографий.
            Макс: {{ MAX_FILES }} файлов, {{ MAX_FILE_SIZE_MB }}MB каждый
        </p>

        <!-- Превью -->
        <div v-if="selectedFiles.length" class="mt-4">
            <h3 class="font-bold mb-2">
                Выбранные файлы ({{ selectedFiles.length }})
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div
                    v-for="(file, index) in selectedFiles"
                    :key="file.name + file.size"
                    class="relative"
                >
                    <img
                        :src="file.preview"
                        class="w-full h-32 object-cover rounded border"
                    />

                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b">
                        {{ formatFileSize(file.size) }}
                    </div>

                    <button
                        @click="removeFile(index)"
                        type="button"
                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600"
                    >
                        ×
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
