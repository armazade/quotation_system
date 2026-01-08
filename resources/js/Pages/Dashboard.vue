<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import LinkButton from '@/Components/Buttons/BaseButton.vue';
import RealButton from '@/Components/Buttons/RealButton.vue';
import QuotationStatusIndicator from '@/Components/StatusIndicators/QuotationStatusIndicator.vue';
import { formatting } from '@/Mixins/formatting';
import moment from 'moment';

defineProps({
    quotations: Array,
    quotationsCount: Number,
});
</script>

<template>
    <Head :title="__('dashboard')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('dashboard') }}</h2>
        </template>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('my_quotations') }}</h3>
                <div class="flex gap-2">
                    <link-button :href="route('quotation.create')">
                        {{ __('button.create_quotation') }}
                    </link-button>
                    <link-button v-if="quotationsCount > 5" :href="route('client.quotation.index')">
                        {{ __('button.see_all') }}
                    </link-button>
                </div>
            </div>

            <div v-if="quotations.length > 0" class="admin_table_container">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('created_at') }}</th>
                            <th>{{ __('status') }}</th>
                            <th>{{ __('reference') }}</th>
                            <th class="text-right">{{ __('costs_total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="quotation in quotations" :key="quotation.id">
                            <td>{{ moment(quotation.created_at).format("YYYY-MM-DD") }}</td>
                            <td>
                                <QuotationStatusIndicator :status="quotation.status" />
                            </td>
                            <td>
                                <real-button :href="route('client.quotation.show', quotation)">
                                    {{ quotation.reference || quotation.id.substring(0, 8) }}
                                </real-button>
                            </td>
                            <td class="text-right">
                                {{ formatting.methods.formatEuro(quotation.grand_total) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="text-gray-500 text-center py-8">
                {{ __('no_results') }}
            </div>
        </div>
    </AuthenticatedLayout>
</template>
