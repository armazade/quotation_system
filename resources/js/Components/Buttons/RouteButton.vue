<script setup>

import LinkButton from "@/Components/Buttons/BaseButton.vue";
import {ButtonType} from "@/Enums/ButtonType";

const props = defineProps({
    inertiaRoute: {
        default: null,
        required: true
    },
    buttonType: {
        default: ButtonType.VIEW,
    },
    buttonLabel: {
        default: null,
    },
    buttonColor: {
        default: null,
    },
});

</script>

<template>
    <link-button :buttonColor="buttonColor" :href="inertiaRoute">
        {{ buttonLabel ? __(buttonLabel) : __('button.' + props.buttonType) }}
    </link-button>
</template>
