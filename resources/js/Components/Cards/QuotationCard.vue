<script setup>
import QuotationStatusIndicator from '@/Components/StatusIndicators/QuotationStatusIndicator.vue';
import RealButton from '@/Components/Buttons/RealButton.vue';
import { formatting } from '@/Mixins/formatting';
import { translations } from '@/Mixins/translations';

const __ = translations.methods.__;

const props = defineProps({
    quotation: {
        type: Object,
        required: true,
    },
    showCompany: {
        type: Boolean,
        default: false,
    },
    detailRoute: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-3">
            <div>
                <QuotationStatusIndicator :status="quotation.status" />
            </div>
            <div class="text-sm text-gray-500">
                {{ formatting.methods.formatDate(quotation.created_at) }}
            </div>
        </div>

        <div v-if="showCompany && quotation.company" class="mb-2">
            <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('company') }}</div>
            <div class="font-semibold text-gray-900">{{ quotation.company.name }}</div>
            <div v-if="quotation.company.debiteur_number" class="text-sm text-gray-500">
                {{ quotation.company.debiteur_number }}
            </div>
        </div>

        <div class="mb-3">
            <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('reference') }}</div>
            <div class="font-medium text-gray-800">
                {{ quotation.reference || quotation.id.substring(0, 8) }}
            </div>
        </div>

        <div class="flex justify-between items-center pt-3 border-t border-gray-100">
            <div>
                <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('costs_total') }}</div>
                <div class="text-lg font-bold text-blue-700">
                    {{ formatting.methods.formatEuro(quotation.total_price || quotation.grand_total || 0) }}
                </div>
            </div>
            <real-button :href="detailRoute" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                {{ __('button.view') }}
            </real-button>
        </div>
    </div>
</template>
