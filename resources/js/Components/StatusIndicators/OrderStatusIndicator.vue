<script setup>

import {OrderStatusType} from "@/Enums/OrderStatusType";

const props = defineProps([
    'status',
    'size',
]);

const getBgColor = (status) => {
    if (status === OrderStatusType.REVIEW_TECHNICAL_DRAWING) {
        return 'bg-orange-200 border-orange-300';
    }
    if (status === OrderStatusType.WAITING_FOR_TECHNICAL_DRAWING) {
        return 'bg-yellow-100 border-yellow-200';
    }
    if (status === OrderStatusType.COMPLETED) {
        return 'bg-green-200 border-green-300';
    }
    if (status === OrderStatusType.IN_PROCESS) {
        return 'bg-blue-100 border-blue-200';
    }
    if (status === OrderStatusType.CANCELED) {
        return 'bg-gray-200 border-gray-300';
    }

    return 'bg-white';
}

const getSize = (size) => {
    return size ?? 'text-xs';
}
</script>

<template>
    <span :class="['font-bold uppercase border p-1 rounded whitespace-nowrap', getBgColor(status), getSize(size)] ">
        {{ __(OrderStatusType._KEY + status) }}
    </span>
</template>
