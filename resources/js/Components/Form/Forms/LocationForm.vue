<script setup>

import FormTextInput from "@/Components/Form/FormTextInput.vue";
import FormSelectInput from "@/Components/Form/FormSelectInput.vue";

const props = defineProps({
    form: {
        required: true,
    },
    countryTypes: {
        required: true,
    },
});

</script>

<template>
    <FormTextInput
        id="address_line_1"
        v-model="form.address_line_1"
        :error-message="form.errors.address_line_1"
        :label="__('address_line_1')"
        :required="true"
    />

    <FormTextInput
        id="address_line_2"
        v-model="form.address_line_2"
        :error-message="form.errors.address_line_2"
        :label="__('address_line_2')"
    />

    <FormTextInput
        id="zip_code"
        v-model="form.zip_code"
        :error-message="form.errors.zip_code"
        :label="__('zip_code')"
        :required="true"
    />

    <FormTextInput
        id="city"
        v-model="form.city"
        :error-message="form.errors.city"
        :label="__('city')"
        :required="true"
    />

    <FormSelectInput
        id="country"
        v-model="form.country"
        :error-message="form.errors.country"
        :has-translations="true"
        :label="__('country')"
        :options="countryTypes"
        :required="true"
        :translation-prefix="'country_type'"
    />
</template>
