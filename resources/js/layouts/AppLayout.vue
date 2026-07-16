<template>
    <div>
        <slot />
        <DevNotice
            contact-email="artem.anoshin@gmail.com"
        />
    </div>
</template>

<script setup lang="ts">
    import DevNotice from '@/components/DevNotice.vue';
</script>
