<script setup>
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import LinkButton from '@/Components/Buttons/BaseButton.vue';
import QuotationCard from '@/Components/Cards/QuotationCard.vue';

defineProps({
    todayQuotationsCount: Number,
    pendingQuotations: Array,
});
</script>

<template>
    <Head :title="__('dashboard')"/>

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('dashboard') }}</h2>
        </template>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('quotations_today') }}</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ todayQuotationsCount }}</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('quotations_pending_review') }}</h3>
                <p class="text-3xl font-bold text-yellow-600 mt-2">{{ pendingQuotations?.length || 0 }}</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 flex items-center justify-center">
                <link-button :href="route('admin.quotation.index')">
                    {{ __('button.see_all') }} {{ __('quotations') }}
                </link-button>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('quotations_pending_review') }}</h3>
            </div>

            <div v-if="pendingQuotations && pendingQuotations.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <QuotationCard
                    v-for="quotation in pendingQuotations"
                    :key="quotation.id"
                    :quotation="quotation"
                    :show-company="true"
                    :detail-route="route('admin.quotation.show', quotation)"
                />
            </div>

            <div v-else class="text-gray-500 text-center py-8">
                {{ __('no_results') }}
            </div>
        </div>
    </AdminLayout>
</template>
