<script setup>
import {onMounted, ref} from 'vue';

const props = defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

const value = props.modelValue;

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <textarea
        ref="input"
        v-model="value"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
        @input="$emit('update:modelValue', $event.target.value)"
    />
</template>
