<script setup>
import {computed} from "vue";

const props = defineProps([
    'value',
    'showRequired',
    'class',
]);

const classValue = computed({
    get() {
        return props.class ?? null;
    },
});
</script>

<template>
    <label :class="classValue ?? 'block font-medium text-sm text-gray-700'">
        <span v-if="value" v-html="value"></span><span v-if="showRequired" class="text-red-600">*</span>
        <span v-else><slot/></span>
    </label>
</template>
