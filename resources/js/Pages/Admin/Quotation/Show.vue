<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import QuotationStatusIndicator from '@/Components/StatusIndicators/QuotationStatusIndicator.vue';
import RealButton from '@/Components/Buttons/RealButton.vue';
import LinkButton from '@/Components/Buttons/BaseButton.vue';
import { formatting } from '@/Mixins/formatting';
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
                <link-button :href="route('admin.quotation.index')">
                    {{ __('button.back') }}
                </link-button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">{{ __('company_details') }}</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-gray-500">{{ __('debiteur_number') }}:</span>
                    <span class="ml-2 font-semibold">{{ quotation.company.debiteur_number || '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">{{ __('company_name') }}:</span>
                    <real-button :href="route('admin.company.show', { company: quotation.company.id })" class="ml-2">
                        {{ quotation.company.name }}
                    </real-button>
                </div>
                <div>
                    <span class="text-gray-500">{{ __('created_at') }}:</span>
                    <span class="ml-2">{{ moment(quotation.created_at).format("DD-MM-YYYY HH:mm") }}</span>
                </div>
                <div v-if="quotation.user">
                    <span class="text-gray-500">{{ __('user') }}:</span>
                    <span class="ml-2">{{ quotation.user.first_name }} {{ quotation.user.last_name }}</span>
                </div>
                <div v-if="quotation.reference">
                    <span class="text-gray-500">{{ __('reference') }}:</span>
                    <span class="ml-2">{{ quotation.reference }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
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
                        <tr v-if="quotation.lines.length === 0">
                            <td colspan="5">{{ __('no_results') }}</td>
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

            <div class="mt-4 text-sm text-gray-600 bg-blue-50 p-3 rounded">
                {{ __('delivery_info') }}
            </div>
        </div>
    </AuthenticatedLayout>
</template>
