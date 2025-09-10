<script setup>
import {computed, onMounted, ref} from 'vue';
import InputLabel from "@/Components/Form/Elements/InputLabel.vue";
import InputError from "@/Components/Form/Elements/InputError.vue";
import SelectInput from "@/Components/Form/Elements/SelectInput.vue";
import RealButton from "@/Components/Buttons/RealButton.vue";
import TooltipIcon from "@/Components/Miscellaneous/TooltipIcon.vue";

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
    disclaimer: {
        default: null,
    },
    disclaimerLink: {
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
    options: {
        default: null,
    },
    hasTranslations: {
        default: false,
    },
    translationPrefix: {
        default: null,
    },
    hasEmptyRow: {
        default: false,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

let parsedOptions = computed(() => {
    let parsedOptions = props.options;

    if (props.hasEmptyRow) {
        parsedOptions = Object.assign({'': ''}, props.options);
    }

    return parsedOptions;
})

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <div class="input_group">
        <InputLabel v-if="label" :for="name ?? id" :show-required="required && showRequired" :value="label"/>

        <SelectInput
            :id="id"
            :autocomplete="name ?? id"
            :has-translations="hasTranslations"
            :name="name ?? id"
            :options="parsedOptions"
            :required="required"
            :translation-prefix="translationPrefix"
            :value="modelValue"
            class="mt-1 block w-full"
            @input="$emit('update:modelValue', $event.target.value)"
        />

        <InputError :message="errorMessage" class="mt-2"/>

        <template v-if="disclaimer">
            <template v-if="disclaimerLink">
                <real-button :href="'https://' + disclaimerLink" :target="'_blank'">
                    <tooltip-icon :body="disclaimer"/>
                    {{ disclaimer }}
                </real-button>
            </template>

            <InputLabel v-else :for="name ?? id" :value="disclaimerLink"/>
        </template>
    </div>
</template>
