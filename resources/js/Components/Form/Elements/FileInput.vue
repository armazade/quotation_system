<script setup>
import {onMounted, ref} from 'vue';

const props = defineProps({
    'modelValue': {},
    'hasMultiple': {
        default: false,
    },
    'acceptMimes': {
        default: '*',
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }

    const uploadElement = document.querySelector(".myclass");

    if (props.hasMultiple) {
        uploadElement.setAttribute("multiple", '');
    }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <input
        ref="input"
        :accept="acceptMimes"
        :value="modelValue"
        class="myclass"
        type="file"
        @input="$emit('update:modelValue', $event.target.value)"
    />
</template>
