<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({ width: '', height: '' })
    }
});

const emit = defineEmits(['update:modelValue']);

const resolution = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit('update:modelValue', value);
    }
});

const updateWidth = (value) => {
    resolution.value = { ...resolution.value, width: value };
};

const updateHeight = (value) => {
    resolution.value = { ...resolution.value, height: value };
};
</script>

<template>
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">
            Максимальное разрешение
        </label>
        <div class="flex space-x-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Ширина (px)</label>
                <input
                    :value="resolution.width"
                    @input="updateWidth($event.target.value)"
                    type="number"
                    min="1"
                    placeholder="например: 1920"
                    class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Высота (px)</label>
                <input
                    :value="resolution.height"
                    @input="updateHeight($event.target.value)"
                    type="number"
                    min="1"
                    placeholder="например: 1080"
                    class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
        </div>
        <p class="text-sm text-gray-500 mt-1">
            Оставьте поле пустым, если ограничение не требуется.
        </p>
    </div>
</template>
