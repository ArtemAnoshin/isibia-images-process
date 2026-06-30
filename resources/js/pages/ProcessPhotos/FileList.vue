<script setup lang="ts">

// Пропсы
defineProps({
    processedFiles: {
        type: Array,
        required: true,
        default: () => [],
    },
});

// Методы
const emit = defineEmits(['delete', 'deleteAll']);

const formatDate = (date) => {
    if (!date) {
        return '';
    }

    return new Date(date).toLocaleString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const deleteFile = (id) => {
    if (confirm('Удалить этот файл?')) {
        emit('delete', id);
    }
};

const deleteAll = () => {
    if (confirm('Удалить все файлы?')) {
        emit('deleteAll');
    }
};
</script>

<style scoped>
.file-list {
    margin-top: 20px;
}
</style>

<template>
    <div class="file-list">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-medium text-gray-700">
                Ваши обработанные файлы
                <span v-if="processedFiles.length" class="text-sm text-gray-400 ml-2">
                    ({{ processedFiles.length }})
                </span>
            </h3>

            <button
                v-if="processedFiles.length > 0"
                @click="deleteAll"
                class="text-sm text-red-600 hover:text-red-800 transition"
            >
                🗑 Удалить всё
            </button>
        </div>

        <!-- Если файлов нет -->
        <div v-if="!processedFiles.length" class="text-center py-8 border-2 border-dashed rounded-lg">
            <div class="text-4xl mb-2">📭</div>
            <p class="text-gray-500">Нет обработанных файлов</p>
            <p class="text-sm text-gray-400 mt-1">Загрузите изображения и обработайте их</p>
        </div>

        <!-- Список файлов -->
        <div v-else class="space-y-2">
            <div
                v-for="file in processedFiles"
                :key="file.id"
                class="flex items-center justify-between border rounded-lg p-3 bg-white hover:shadow-sm transition"
            >
                <!-- Левая часть: иконка и информация -->
                <div class="flex items-center gap-3 min-w-0 flex-1">
                    <span class="text-2xl flex-shrink-0">
                        {{ file.is_archive ? '📦' : '📄' }}
                    </span>

                    <div class="min-w-0 flex-1">
                        <div class="truncate font-medium text-gray-800" :title="file.original_name">
                            {{ file.original_name }}
                        </div>
                        <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                            <span v-if="file.is_archive">
                                Архив • {{ file.file_count }} файлов
                            </span>
                            <span v-else>
                                Файл
                            </span>

                            <span v-if="file.size" class="text-gray-400">
                                • {{ file.size }}
                            </span>

                            <span class="text-gray-400">
                                • до {{ formatDate(file.expires_at) }}
                            </span>

                            <span v-if="!file.is_available" class="text-red-500">
                                • ❌ Просрочен
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Правая часть: кнопки действий -->
                <div class="flex items-center gap-2 flex-shrink-0 ml-4">
                    <a
                        :href="file.download_url"
                        download
                        class="bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition text-sm flex items-center gap-1"
                    >
                        ⬇ Скачать
                    </a>

                    <button
                        @click="deleteFile(file.id)"
                        class="text-gray-400 hover:text-red-600 transition p-1"
                        title="Удалить"
                    >
                        ✕
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

