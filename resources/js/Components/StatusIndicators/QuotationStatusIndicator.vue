<script setup>


import {QuotationStatusType} from "@/Enums/QuotationStatusType";

const props = defineProps([
    'status',
]);

const getBgColor = (status) => {
    if (status === QuotationStatusType.DRAFT) {
        return 'bg-gray-100 border-gray-200';
    }
    if (status === QuotationStatusType.IN_REVIEW) {
        return 'bg-yellow-100 border-yellow-200';
    }
    if (status === QuotationStatusType.ACTIVE) {
        return 'bg-green-100 border-green-200';
    }
    if (status === QuotationStatusType.EXPIRED) {
        return 'bg-red-100 border-red-200';
    }

    return 'bg-white';
}
</script>

<template>
    <span :class="['font-bold uppercase text-xs border p-1 rounded whitespace-nowrap', getBgColor(status)] ">
        {{ __(QuotationStatusType._KEY + status) }}
    </span>
</template>
