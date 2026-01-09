<script setup>

import {useForm} from "@inertiajs/vue3";
import LinkButton from "@/Components/Buttons/BaseButton.vue";

const props = defineProps({
    routeName: {
        default: null,
        required: true
    },
    item: {
        default: null,
        required: true,
    },
    confirmationMessage: {
        default: 'confirm.delete',
    },
});

const deleteItem = (item) => {
    if (window.confirm(translations.methods.__(props.confirmationMessage))) {
        let form = useForm({});

        form.delete(route(props.routeName, item), {
            onFinish: () => form.reset(),
        });
    }
};

</script>

<template>
    <link-button @click="deleteItem(props.item)">
        {{ __('button.delete') }}
    </link-button>
</template>
