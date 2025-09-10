<script setup>
import {onMounted, ref} from 'vue';
import InputLabel from "@/Components/Form/Elements/InputLabel.vue";
import InputError from "@/Components/Form/Elements/InputError.vue";
import NumberInput from "@/Components/Form/Elements/NumberInput.vue";

const props = defineProps({
    id: {
        default: null,
    },
    name: {
        default: null,
    },
    label: {
        default: null,
    },
    modelValue: {
        default: null,
    },
    required: {
        default: false,
    },
    showRequired: {
        default: true,
    },
    errorMessage: {
        default: null,
    },
    step: {
        default: 1,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <div class="input_group">
        <InputLabel v-if="label" :for="name ?? id" :show-required="required && showRequired" :value="label"/>

        <NumberInput
            :id="id"
            :autocomplete="name ?? id"
            :step="step"
            :value="modelValue"
            class="mt-1 block w-full"
            @input="$emit('update:modelValue', $event.target.value)"
        />

        <InputError :message="errorMessage" class="mt-2"/>
    </div>
</template>
