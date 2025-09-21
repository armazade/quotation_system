<script setup>

import moment from "moment/moment";
import {useForm} from "@inertiajs/vue3";
import FormSelectInput from "@/Components/Form/FormSelectInput.vue";
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import LinkButton from "@/Components/Buttons/BaseButton.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import RealButton from "@/Components/Buttons/RealButton.vue";
import Pagination from "@/Components/Miscellaneous/Pagination.vue";
import QuotationStatusIndicator from "@/Components/StatusIndicators/QuotationStatusIndicator.vue";

const props = defineProps({
    quotations: {
        default: []
    },
    quotationTotal: {
        default: null
    },
    quotationLinks: {
        default: null
    },
    quotationStatusTypes: {
        default: null
    },
    showCompanyName: {
        default: true
    },
    showUserName: {
        default: false
    },
    showFilters: {
        default: true
    },
});

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const form = useForm({
    quotation_status: urlParams.get('quotation_status') ?? null,
    reference: urlParams.get('reference') ?? null,
    company_name: urlParams.get('company_name') ?? null,
});

const submit = () => {
    form.get(route('admin.quotation.index'), {
        preserveScroll: true,
        preserveState: true,
    });
};

</script>

<template>

    <div>
        <div v-if="showFilters" class="admin_filters">
            <form @submit.prevent="submit">
                <div class="form_container">
                    <FormSelectInput
                        id="quotation_status"
                        v-model="form.quotation_status"
                        :error-message="form.errors.quotation_status"
                        :has-translations="true"
                        :label="__('status')"
                        :options="quotationStatusTypes"
                    />

                    <FormTextInput
                        id="reference"
                        v-model="form.reference"
                        :error-message="form.errors.reference"
                        :label="__('reference')"
                    />

                    <FormTextInput
                        id="company_name"
                        v-model="form.company_name"
                        :error-message="form.errors.company_name"
                        :label="__('company_name')"
                    />
                </div>

                <div class="results_container">
                    <span class="results_label">
                        {{ quotationTotal }} {{ __('results') }}
                    </span>

                    <div class="button_container">
                        <link-button :href="route('admin.quotation.index')">
                            {{ __('button.clear') }}
                        </link-button>
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            {{ __('button.filter') }}
                        </PrimaryButton>
                    </div>
                </div>
            </form>
        </div>

        <div class="admin_table_container">
            <table>
                <thead>
                <tr>
                    <th>{{ __('created_at') }}</th>
                    <th>{{ __('status') }}</th>
                    <th>{{ __('reference') }}</th>
                    <th v-if="showCompanyName">{{ __('company_name') }}</th>
                    <th v-if="showUserName">{{ __('user') }}</th>
                    <th class="text-right">{{ __('costs_total') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="quotation in quotations">
                    <td>{{ moment(quotation.created_at).format("YYYY-MM-DD") }}</td>
                    <td>
                        <QuotationStatusIndicator :status="quotation.status"/>
                    </td>
                    <td class="max-w-52 truncate">
                        <real-button
                            :href="route('admin.quotation.show', quotation)"
                        >
                            {{ quotation.reference }}
                        </real-button>
                    </td>
                    <td v-if="showCompanyName">
                        <real-button :href="route('admin.company.show', { id:  quotation.company.id})">
                            {{ quotation.company.name }}
                        </real-button>
                    </td>
                    <td v-if="showUserName" class="max-w-52 truncate">
                        {{ quotation.user.first_name }}
                    </td>
                    <td class="text-right">{{ formatting.methods.formatEuro(quotation.total_price) }}</td>
                </tr>
                <tr v-if="quotations.length === 0">
                    <td colspan="5">{{ __('no_results') }}</td>
                    <td v-if="showCompanyName"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div v-if="quotationLinks" class="pagination_container">
        <pagination :links="quotationLinks"/>
    </div>
</template>
