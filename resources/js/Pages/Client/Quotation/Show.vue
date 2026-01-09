<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import QuotationStatusIndicator from '@/Components/StatusIndicators/QuotationStatusIndicator.vue';
import DeleteButton from '@/Components/Buttons/DeleteButton.vue';
import LinkButton from '@/Components/Buttons/BaseButton.vue';
import { formatting } from '@/Mixins/formatting';
import { QuotationStatusType } from '@/Enums/QuotationStatusType';
import moment from 'moment';
import { computed } from 'vue';

const props = defineProps({
    quotation: Object,
});

const deliveryCost = computed(() => {
    return props.quotation.subtotal < 50 ? 9.00 : 0.00;
});
</script>

<template>
    <Head :title="__('quotation')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="admin_page_header">
                {{ __('quotation') }} - {{ quotation.reference || quotation.id.substring(0, 8) }}
            </h2>
        </template>

        <div class="admin_page_status_container">
            <QuotationStatusIndicator :status="quotation.status" class="my-auto" />

            <div class="button_container">
                <DeleteButton
                    v-if="quotation.status === 'draft'"
                    :item="quotation"
                    route-name="client.quotation.destroy"
                />
                <link-button :href="route('quotation.create')">
                    {{ __('button.create_new') }}
                </link-button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <span class="text-gray-500">{{ __('created_at') }}:</span>
                    <span class="ml-2">{{ moment(quotation.created_at).format("DD-MM-YYYY HH:mm") }}</span>
                </div>
                <div v-if="quotation.quotation_sent_at">
                    <span class="text-gray-500">{{ __('sent_at') }}:</span>
                    <span class="ml-2">{{ moment(quotation.quotation_sent_at).format("DD-MM-YYYY") }}</span>
                </div>
                <div v-if="quotation.expires_at">
                    <span class="text-gray-500">{{ __('expires_in') }}:</span>
                    <span class="ml-2" :class="quotation.expires_in_days <= 0 ? 'text-red-600 font-semibold' : ''">
                        {{ quotation.expires_in_days > 0 ? moment(quotation.expires_at).format("DD-MM-YYYY") : __('quotation_status.expired') }}
                    </span>
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-4">{{ __('quotation_lines') }}</h3>

            <div class="admin_table_container">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('product') }}</th>
                            <th>{{ __('brand') }}</th>
                            <th>{{ __('quantity') }}</th>
                            <th class="text-right">{{ __('unit_price') }}</th>
                            <th class="text-right">{{ __('costs_total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="line in quotation.lines" :key="line.id">
                            <td>{{ line.description }}</td>
                            <td>{{ line.product?.brand || '-' }}</td>
                            <td>{{ line.quantity }}</td>
                            <td class="text-right">{{ formatting.methods.formatEuro(line.unit_price) }}</td>
                            <td class="text-right">{{ formatting.methods.formatEuro(line.total_price) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg mt-4">
                <div class="flex justify-between mb-2">
                    <span>{{ __('costs_subtotal') }}</span>
                    <span>{{ formatting.methods.formatEuro(quotation.subtotal) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>{{ __('costs_shipping') }}</span>
                    <span v-if="deliveryCost > 0">{{ formatting.methods.formatEuro(deliveryCost) }}</span>
                    <span v-else class="text-green-600 font-semibold">{{ __('delivery_free') }}</span>
                </div>
                <hr class="my-2">
                <div class="flex justify-between font-bold text-lg">
                    <span>{{ __('costs_total') }}</span>
                    <span>{{ formatting.methods.formatEuro(quotation.grand_total) }}</span>
                </div>
            </div>

            <div class="mt-4 text-sm text-gray-600 bg-blue-50 p-4 rounded space-y-2">
                <p>{{ __('delivery_info') }}</p>
                <p v-if="quotation.status === QuotationStatusType.ACTIVE && quotation.expires_in_days > 0">
                    {{ __('quotation_valid_for') }} <strong>{{ quotation.expires_in_days }}</strong> {{ __('days') }}
                </p>
                <p v-else-if="quotation.status === QuotationStatusType.EXPIRED" class="text-red-600 font-semibold">
                    {{ __('quotation_status.expired') }}
                </p>
                <p class="text-xs text-gray-500 pt-2 border-t border-blue-100">
                    {{ __('quotation_disclaimer') }}
                </p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
