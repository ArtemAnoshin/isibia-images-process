<script setup lang="ts">
interface Props {
    title: string
    description?: string
}

withDefaults(defineProps<Props>(), {
    description: ''
})
</script>

<template>
    <div class="mb-6 p-5 bg-white border border-gray-200 rounded-lg shadow-sm wrapper">
        <!-- Заголовок и описание -->
        <div class="mb-4">
            <h4 class="text-md font-semibold text-gray-700 mb-1">
                {{ title }}
            </h4>
            <p
                v-if="description"
                class="text-sm text-gray-600"
            >
                {{ description }}
            </p>
        </div>

        <!-- Контент (слот) -->
        <div class="setting-content">
            <slot />
        </div>
    </div>
</template>
