<script setup>
import {onMounted, ref} from 'vue';
import InputLabel from "@/Components/Form/Elements/InputLabel.vue";
import InputError from "@/Components/Form/Elements/InputError.vue";
import TextAreaInput from "@/Components/Form/Elements/TextAreaInput.vue";

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
    errorMessage: {
        default: null,
    },
    required: {
        default: false,
    },
    showRequired: {
        default: true,
    },
    maxLength: {
        default: 255,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

const value = props.modelValue;

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <div class="input_group">
        <InputLabel v-if="label" :for="name ?? id" :show-required="required && showRequired" :value="label"/>

        <div class="flex flex-col">
            <TextAreaInput
                :id="id"
                v-model="value"
                :required=required
                @input="$emit('update:modelValue', $event.target.value)"
            />

            <div v-if="maxLength" :class="['text-right mt-1', maxLength < value?.length ? 'text-red-500' : 'text-gray-400']">
                {{ value?.length ?? 0 }} / {{ maxLength }}
            </div>
        </div>

        <InputError :message="errorMessage" class="mt-2"/>
    </div>
</template>
