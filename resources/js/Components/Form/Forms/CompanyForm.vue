<script setup>

import InputLabel from "@/Components/Form/Elements/InputLabel.vue";
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import FormSelectInput from "@/Components/Form/FormSelectInput.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import {CompanyType} from "@/Enums/CompanyType";
import FormNumberInput from "@/Components/Form/FormNumberInput.vue";

const props = defineProps({
    form: {
        required: true,
    },
    company: {
        required: true,
    },
    isAdmin: {
        default: false,
    },
    countryCodeTypes: {
        default: null,
    },
});

function submit(company) {
    props.form.patch(route('admin.company.update', company.id))
}

</script>

<template>
    <form @submit.prevent="submit(company)">
        <FormTextInput
            id="name"
            v-model="form.name"
            :error-message="form.errors.name"
            :label="__('name')"
        />

        <FormTextInput
            id="email"
            v-model="form.email"
            :error-message="form.errors.email"
            :label="__('email')"
        />

        <div>
            <InputLabel :value="__('phone_number')" for="phone_number"/>

            <div class="flex flex-row space-x-2">
                <FormSelectInput
                    id="phone_country_code"
                    v-model="form.phone_country_code"
                    :error-message="form.errors.phone_country_code"
                    :options="countryCodeTypes"
                />

                <FormNumberInput
                    id="phone_number"
                    v-model="form.phone_number"
                    :error-message="form.errors.phone_number"
                />
            </div>
        </div>

        <FormTextInput
            id="website"
            v-model="form.website"
            :error-message="form.errors.website"
            :label="__('website')"
        />

        <FormTextInput
            id="legal_owner"
            v-model="form.legal_owner"
            :error-message="form.errors.legal_owner"
            :label="__('legal_owner')"
        />

        <FormTextInput
            id="vat_number"
            v-model="form.vat_number"
            :error-message="form.errors.vat_number"
            :label="__('vat_number')"
        />

        <FormTextInput
            id="coc_number"
            v-model="form.coc_number"
            :error-message="form.errors.coc_number"
            :label="__('coc_number')"
        />

        <FormTextInput
            id="iban_number"
            v-model="form.iban_number"
            :error-message="form.errors.iban_number"
            :label="__('iban_number')"
        />

        <FormTextInput
            id="bic_number"
            v-model="form.bic_number"
            :error-message="form.errors.bic_number"
            :label="__('bic_number')"
        />

        <FormSelectInput
            v-if="company.company_type === CompanyType.CLIENT"
            id="subscription_type"
            v-model="form.subscription_type"
            :error-message="form.errors.subscription_type"
            :has-translations="true"
            :label="__('subscription_type')"
            :options="subscriptionTypes"
        />

        <FormTextInput
            id="exact_id"
            v-model="form.exact_id"
            :error-message="form.errors.exact_id"
            :label="__('exact_id')"
        />

        <div class="flex items-left mt-4">
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ __('button.save') }}
            </PrimaryButton>
        </div>

    </form>
</template>
