<script setup xmlns="http://www.w3.org/1999/html">
import {onMounted, ref} from 'vue';

const props = defineProps({
    name: {
        default: null,
    },
    modelValue: {
        default: null,
    },
    options: {
        default: null,
    },
    placeholderValue: {
        default: false,
    },
    hasTranslations: {
        default: false,
    },
    translationPrefix: {
        default: null,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <select
        ref="input"
        :value="modelValue"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <option v-if="placeholderValue" disabled value="">{{ placeholderValue }}</option>
        <option v-for="(label, value) in options" :value="value">
            {{ hasTranslations && label ? __((translationPrefix ?? name) + '.' + label) : label }}
        </option>
    </select>
</template>
