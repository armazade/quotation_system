<script setup xmlns="http://www.w3.org/1999/html">
import {ref} from 'vue';

defineProps([
    'modelValue',
    'options',
    'name',
]);

defineEmits(['update:modelValue']);

const input = ref(null);

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <div class="flex flex-col">
        <template v-for="(label, value) in options">
            <label :for="name + value">
                <input
                    :id="name + value"
                    :checked="modelValue === value"
                    :name="name"
                    :value="value"
                    type="radio"
                    @change="$emit('update:modelValue', $event.target.value)"
                />
                {{ label }}
            </label>
        </template>
    </div>
</template>
