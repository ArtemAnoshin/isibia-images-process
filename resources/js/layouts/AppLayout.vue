<script setup lang="ts">
    import { usePage } from '@inertiajs/vue3'
    import { computed } from "vue"
    import DevNotice from '@/components/DevNotice.vue';

    const page = usePage();

    const contactEmail = computed(() => page.props.contact_email as string);
</script>

<template>
    <div>
        <slot />
        <DevNotice :contact-email="contactEmail"/>
    </div>
</template>
