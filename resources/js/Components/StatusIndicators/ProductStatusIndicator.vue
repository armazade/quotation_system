<script setup>

import {ProductStatusType} from "@/Enums/ProductStatusType";

const props = defineProps([
    'size',
    'status',
]);

const getBgColor = (status) => {
    if (status === false) {
        return 'bg-orange-200 border-orange-300';
    }

    return 'bg-green-200 border-green-300';
}

const getSize = (size) => {
    return size ?? 'text-xs';
}
</script>

<template>
    <span :class="['font-bold uppercase border p-1 rounded whitespace-nowrap', getBgColor(status), getSize(size)] ">
        {{ __(ProductStatusType._KEY + status) }}
    </span>
</template>
