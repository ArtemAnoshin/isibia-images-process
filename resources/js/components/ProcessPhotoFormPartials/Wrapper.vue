<script setup lang="ts">
import { ref } from 'vue'

interface Props {
    title: string
    description?: string,
    accent?: string,
    open?: boolean,
    icon?: string
}

const props = withDefaults(defineProps<Props>(), {
    description: '',
    accent: 'border-gray-200',
    open: false,
    icon: 'fas fa-file-signature'
})
const isOpen = ref(props.open)
</script>

<template>
    <div
        class="mb-6 p-5 bg-white border rounded-lg shadow-sm wrapper cursor-pointer"
        :class="props.accent"
        @click="isOpen = !isOpen"
    >
        <!-- Заголовок и описание -->
        <div :class="isOpen && 'mb-4'">
            <h4 class="text-md font-semibold text-gray-700" :class="isOpen && 'mb-1'">
                <i
                    v-if="icon"
                    :class="icon"
                    class="text-sm mr-2"
                ></i>
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
        <div
            class="setting-content"
            v-show="isOpen"
            @click.stop
        >
            <slot />
        </div>
    </div>
</template>
