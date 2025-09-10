<script setup>

import Tooltip from "@/Components/Miscellaneous/Tooltip.vue";
import {StyleColorType} from "@/Enums/StyleColorType";

const props = defineProps({
    body: {
        type: String,
        default: 'tooltip',
    },
    tooltipId: {
        type: String,
        default: 'tooltipId',
    },
    color: {
        type: String,
        default: StyleColorType.INFO
    }
});

</script>

<template>
    <div class="inline inline-block my-auto">
        <svg
            :class="['h-4 mb-0.5 inline inline-block my-auto', color]"
            :data-tooltip-target="tooltipId"
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
        >
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" x2="12" y1="16" y2="12"/>
            <line x1="12" x2="12.01" y1="8" y2="8"/>
        </svg>

        <tooltip
            :body="body"
            :target-id="tooltipId"
        />
    </div>
</template>
