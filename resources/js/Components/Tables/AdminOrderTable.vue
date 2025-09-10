<script setup>

import moment from "moment/moment";
import {formatting} from "@/Mixins/formatting";
import {useForm} from "@inertiajs/vue3";
import FormSelectInput from "@/Components/Form/FormSelectInput.vue";
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import LinkButton from "@/Components/Buttons/BaseButton.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import OrderStatusIndicator from "@/Components/StatusIndicators/OrderStatusIndicator.vue";
import RealButton from "@/Components/Buttons/RealButton.vue";
import Pagination from "@/Components/Miscellaneous/Pagination.vue";
import FormNumberInput from "@/Components/Form/FormNumberInput.vue";

const props = defineProps({
    orders: {
        default: []
    },
    orderTotal: {
        default: null
    },
    orderLinks: {
        default: null
    },
    orderStatusTypes: {
        default: null
    },
    showCompanyName: {
        default: true
    },
    showFilters: {
        default: true
    },
    showExport: {
        default: true
    },
});

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const form = useForm({
    order_status: urlParams.get('order_status') ?? null,
    reference: urlParams.get('reference') ?? null,
    company_name: urlParams.get('company_name') ?? null,
    order_number: urlParams.get('order_number') ?? null,
});

const submit = () => {
    form.get(route('admin.order.index'), {
        preserveScroll: true,
        preserveState: true,
    });
};

</script>

<template>

    <div>
        <div v-if="showFilters" class="admin_filters">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <div class="button_container">
                        <link-button :href="route('admin.order_export.show')">
                            {{ __('button.export') }}
                        </link-button>
                    </div>
                </div>
                <div class="form_container">
                    <FormSelectInput
                        id="order_status"
                        v-model="form.order_status"
                        :error-message="form.errors.order_status"
                        :has-translations="true"
                        :label="__('status')"
                        :options="orderStatusTypes"
                    />

                    <FormNumberInput
                        id="order_number"
                        v-model="form.order_number"
                        :error-message="form.errors.order_number"
                        :label="__('order_number')"
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
                        {{ orderTotal }} {{ __('results') }}
                    </span>

                    <div class="button_container">
                        <link-button :href="route('admin.order.index')">
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
                    <th class="text-right">{{ __('costs_total') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="order in orders">
                    <td>{{ moment(order.created_at).format("YYYY-MM-DD") }}</td>
                    <td>
                        <OrderStatusIndicator :status="order.status"/>
                    </td>
                    <td class="max-w-52 truncate">
                        <real-button :href="route('admin.order.show', { id:  order.id})">
                            #{{ order.number }}
                            <template v-if="order.reference">
                                ({{ order.reference }})
                            </template>
                        </real-button>
                    </td>
                    <td v-if="showCompanyName">
                        <real-button :href="route('admin.company.show', { id:  order.company.id})">
                            {{ order.company.name }}
                        </real-button>
                    </td>
                    <td class="text-right">{{ formatting.methods.formatEuro(order.total_price) }}</td>
                </tr>
                <tr v-if="orders.length === 0">
                    <td colspan="5">{{ __('no_results') }}</td>
                    <td v-if="showCompanyName"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div v-if="orderLinks" class="pagination_container">
        <pagination :links="orderLinks"/>
    </div>
</template>
