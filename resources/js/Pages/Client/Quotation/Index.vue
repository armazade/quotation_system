<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Miscellaneous/Pagination.vue';
import LinkButton from '@/Components/Buttons/BaseButton.vue';
import RealButton from '@/Components/Buttons/RealButton.vue';
import QuotationStatusIndicator from '@/Components/StatusIndicators/QuotationStatusIndicator.vue';
import { formatting } from '@/Mixins/formatting';
import moment from 'moment';

defineProps({
    quotations: Object,
    quotationTotal: Number,
});
</script>

<template>
    <Head :title="__('my_quotations')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('my_quotations') }}</h2>
        </template>

        <div class="admin_page_status_container">
            <div class="button_container">
                <link-button :href="route('quotation.create')">
                    {{ __('button.create') }}
                </link-button>
            </div>
        </div>

        <div class="admin_table_container">
            <table>
                <thead>
                    <tr>
                        <th>{{ __('created_at') }}</th>
                        <th>{{ __('status') }}</th>
                        <th>{{ __('reference') }}</th>
                        <th>{{ __('products_count') }}</th>
                        <th class="text-right">{{ __('costs_total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="quotation in quotations.data" :key="quotation.id">
                        <td>{{ moment(quotation.created_at).format("YYYY-MM-DD") }}</td>
                        <td>
                            <QuotationStatusIndicator :status="quotation.status" />
                        </td>
                        <td>
                            <real-button :href="route('client.quotation.show', quotation)">
                                {{ quotation.reference || quotation.id?.substring(0, 8) }}
                            </real-button>
                        </td>
                        <td>{{ quotation.lines?.length || 0 }}</td>
                        <td class="text-right">
                            {{ formatting.methods.formatEuro(quotation.grand_total) }}
                        </td>
                    </tr>
                    <tr v-if="quotations.data.length === 0">
                        <td colspan="5">{{ __('no_results') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination_container">
            <pagination :links="quotations.links" />
        </div>
    </AuthenticatedLayout>
</template>
