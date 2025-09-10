<script setup>
import {computed} from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    name: {
        default: null,
    },
    id: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(value) {
        emit('update:checked', value);
    },
});
</script>

<template>
    <input
        :id="id"
        v-model="proxyChecked"
        :name="name"
        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
        type="checkbox"
    />
</template>
