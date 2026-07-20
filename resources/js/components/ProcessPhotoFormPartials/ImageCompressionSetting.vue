<script setup lang="ts">
interface Props {
    modelValue: boolean;
}

withDefaults(defineProps<Props>(), {
    modelValue: true,
});
</script>

<template>
    <div class="setting-checkbox-container w-full flex items-center justify-between px-4 py-3 bg-white border rounded-lg cursor-pointer transition-all hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent border-gray-300">
        <label class="setting-checkbox-label">
        <div class="checkbox-wrapper">
            <input
                type="checkbox"
                :checked="modelValue"
                @change="$emit('update:modelValue', ($event.target as HTMLInputElement).checked)"
                class="setting-checkbox-input"
            />
            <div class="checkbox-custom" :class="{ checked: modelValue }">
                <i v-if="modelValue" class="fas fa-check checkbox-icon"></i>
            </div>
        </div>

        <div class="setting-text">
            <span class="font-medium text-gray-900">Сжатие изображений</span>
            <span class="text-sm text-gray-500">
            {{ modelValue
                ? 'Изображения сжимаются для оптимизации'
                : 'Изображения сохраняются без сжатия'
            }}
            </span>
        </div>

        <div class="setting-badge" :class="{ active: modelValue }">
            <i :class="modelValue ? 'fas fa-compress-arrows-alt' : 'fas fa-expand-arrows-alt'"></i>
            <span>{{ modelValue ? 'Сжатие' : 'Оригинал' }}</span>
        </div>
        </label>
    </div>
</template>
