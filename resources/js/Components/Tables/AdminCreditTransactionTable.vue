<script setup>

import moment from "moment/moment";
import Pagination from "@/Components/Miscellaneous/Pagination.vue";
import RealButton from "@/Components/Buttons/RealButton.vue";
import RouteButton from "@/Components/Buttons/RouteButton.vue";
import {TransactionType} from "@/Enums/TransactionType";
import {formatting} from "@/Mixins/formatting";
import LinkButton from "@/Components/Buttons/BaseButton.vue";
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    creditTransactions: {
        default: []
    },
    creditTransactionLinks: {
        default: null
    },
    transactionTotal: {
        default: null
    },
    showCompanyName: {
        default: true
    },
    showFilters: {
        default: true
    },
    forAdmin: {
        default: true
    },
    showPrice: {
        default: false
    },
});

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const form = useForm({
    company_name: urlParams.get('company_name') ?? null,
});

const submit = () => {
    form.get(route('admin.credit_transaction.index'), {
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
                    <FormTextInput
                        id="company_name"
                        v-model="form.company_name"
                        :error-message="form.errors.company_name"
                        :label="__('company_name')"
                    />
                </div>

                <div class="results_container">
                    <span class="results_label">
                        {{ transactionTotal }} {{ __('results') }}
                    </span>

                    <div class="button_container">
                        <link-button :href="route('admin.credit_transaction.index')">
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
                    <th v-if="showCompanyName">{{ __('company_name') }}</th>
                    <th v-else>{{ __('reference') }}</th>
                    <th>{{ __('transaction_type') }}</th>
                    <th class="text-right">{{ __('credits') }}</th>
                    <th v-if="showPrice" class="text-right">{{ __('price') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="creditTransaction in creditTransactions">
                    <td>{{ moment(creditTransaction.created_at).format("YYYY-MM-DD") }}</td>
                    <td v-if="showCompanyName">
                        <real-button :href="route('admin.company.show', { id:  creditTransaction.company.id})">
                            {{ creditTransaction.company.name }}
                        </real-button>
                    </td>
                    <td v-else>{{ creditTransaction.reference }}</td>
                    <td>{{ __(TransactionType._KEY + creditTransaction.transaction_type) }}</td>
                    <td class="text-right">{{ creditTransaction.amount }}</td>
                    <td v-if="showPrice" class="text-right">{{ formatting.methods.formatEuro(creditTransaction.price) }}</td>
                    <td class="action_button_container">
                        <RouteButton
                            v-if="forAdmin"
                            :inertiaRoute="route('admin.credit_transaction.show', creditTransaction)"
                        />
                        <RouteButton
                            v-else
                            :inertiaRoute="route('client.credit_transaction.show', creditTransaction)"
                        />
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div v-if="creditTransactionLinks" class="pagination_container">
        <pagination :links="creditTransactionLinks"/>
    </div>
</template>
