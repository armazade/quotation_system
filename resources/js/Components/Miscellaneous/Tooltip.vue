<script setup>

const props = defineProps({
    body: {
        type: String,
        default: 'test tooltip',
    },
    targetId: {
        type: String,
        default: 'tooltipId',
    },
});

</script>

<template>
    <div
        :id="targetId"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
        role="tooltip"
    >
        {{ body }}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</template>
