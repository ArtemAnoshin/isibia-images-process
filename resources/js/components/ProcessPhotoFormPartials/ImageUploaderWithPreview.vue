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
const MAX_FILE_SIZE_MB = 5
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

const clearFiles = () => {
    selectedFiles.value = []

    emit('update:files', [])

    if (fileInput.value) {
        fileInput.value.value = ''
    }
}

// Экспонируем метод для родителя
defineExpose({
  clearFiles
})
</script>

<template>
    <div>
        <label class="block text-gray-700 font-bold mb-2">
            <i class="fas fa-cloud-upload-alt mr-2"></i>
            <span>Выберите фотографии</span>
        </label>

        <div class="file-upload-wrapper">
            <i class="fas fa-camera-retro"></i>
            <span class="file-upload-text">Перетащите или нажмите для выбора</span>
            <span class="file-upload-types">JPG, PNG, WebP (Макс: {{ MAX_FILES }} файлов, {{ MAX_FILE_SIZE_MB }}MB каждый)</span>

            <input
                type="file"
                ref="fileInput"
                @change="handleFileSelect"
                multiple
                accept="image/*"
                id="actual-file-input"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
        </div>

        <!-- Превью -->
        <div v-if="selectedFiles.length" class="mt-4">
            <h3 class="font-bold mb-2">
                Выбранные файлы ({{ selectedFiles.length }})
            </h3>

            <div class="space-y-2 w-full">
                <div
                    v-for="(file, index) in selectedFiles"
                    :key="file.name + file.size"
                    class="flex items-center gap-3 p-2 border rounded bg-white shadow-sm"
                >
                    <img
                        :src="file.preview"
                        class="w-10 h-10 object-cover border rounded"
                        alt="Preview"
                    />
                    <div class="min-w-0 flex-1">
                        <div class="text-sm truncate">{{ file.name }}</div>
                        <div class="text-xs text-gray-500">{{ formatFileSize(file.size) }}</div>
                    </div>
                    <button
                        @click="removeFile(index)"
                        type="button"
                        class="ml-2 text-red-500 hover:text-red-700 focus:outline-none"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
