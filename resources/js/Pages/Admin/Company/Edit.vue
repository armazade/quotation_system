<script>
import {Head, useForm} from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from "@/Components/Form/Elements/TextInput.vue";
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/Elements/InputError.vue';
import InputLabel from '@/Components/Form/Elements/InputLabel.vue';
import SelectInput from '@/Components/Form/Elements/SelectInput.vue';
import NumberInput from '@/Components/Form/Elements/NumberInput.vue';
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import FormSelectInput from "@/Components/Form/FormSelectInput.vue";
import FormNumberInput from "@/Components/Form/FormNumberInput.vue";
import {CompanyType} from "@/Enums/CompanyType";
import CompanyForm from "@/Components/Form/Forms/CompanyForm.vue";

export default {
    computed: {
        CompanyType() {
            return CompanyType
        }
    },
    components: {
        CompanyForm,
        FormNumberInput,
        FormSelectInput,
        FormTextInput,
        Head, AdminLayout, TextInput, SelectInput, PrimaryButton, InputError, InputLabel, NumberInput
    },
    props: {
        countryCodeTypes: Object,
        company: Object,
    },
    setup(props) {
        const form = useForm({
            name: props.company.name,
            email: props.company.email,
            phone_country_code: props.company.phone_country_code,
            phone_number: props.company.phone_number,
            website: props.company.website,
            legal_owner: props.company.legal_owner,
            vat_number: props.company.vat_number,
            coc_number: props.company.coc_number,
            iban_number: props.company.iban_number,
            bic_number: props.company.bic_number,
            exact_id: props.company.exact_id,
            debiteur_number: props.company.debiteur_number,
        })

        return {form}
    },
}
</script>

<template>
    <Head :title="company.name"/>

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('company.edit') }}</h2>
        </template>

        <div class="admin_form_container">
            <CompanyForm
                :company="company"
                :country-code-types="countryCodeTypes"
                :form="form"
                :is-admin="true"
                :subscription-types="subscriptionTypes"
            />
        </div>
    </AdminLayout>
</template>


