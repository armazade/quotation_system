<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    href: String,
    disabled: {
        disabled: Boolean,
        default: false,
    },
    target: {
        default: null,
    },
});
</script>

<template>
    <a
        :class="['link', disabled ? 'disabled' : ''] "
        :href="href"
        :target="target"
    >
        <slot/>
    </a>
</template>
