<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Number,
        required: true
    }
});

const emit = defineEmits(['update:modelValue']);

const compression = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit('update:modelValue', parseInt(value));
    }
});
</script>

<template>
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">
            Сжатие: {{ compression }}%
        </label>
        <input
            v-model="compression"
            type="range"
            min="10"
            max="90"
            step="5"
            class="w-full"
        />
    </div>
</template>
