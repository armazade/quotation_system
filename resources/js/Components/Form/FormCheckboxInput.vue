<script setup>
import {computed} from 'vue';
import InputLabel from "@/Components/Form/Elements/InputLabel.vue";
import InputError from "@/Components/Form/Elements/InputError.vue";
import Checkbox from "@/Components/Form/Elements/Checkbox.vue";

const emit = defineEmits(['update:checked']);

const props = defineProps({
    id: {
        default: null,
        required: true,
    },
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    name: {
        default: null,
    },
    label: {
        default: null,
        required: true,
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
    <div class="input_group">
        <div class="flex flex-row">
            <Checkbox
                :id="id"
                v-model:checked="proxyChecked"
                :name="name"
                class="my-auto"
            />

            <InputLabel
                v-if="label"
                :for="name ?? id"
                :show-required="required && showRequired"
                :value="label"
                class="ml-2 text-sm text-gray-600 my-auto"
            />
        </div>

        <InputError :message="errorMessage" class="mt-2"/>
    </div>
</template>
