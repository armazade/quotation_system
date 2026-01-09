<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import LinkButton from '@/Components/Buttons/BaseButton.vue';
import QuotationCard from '@/Components/Cards/QuotationCard.vue';

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
                        {{ __('button.request_quotation') }}
                    </link-button>
                    <link-button v-if="quotationsCount > 5" :href="route('client.quotation.index')">
                        {{ __('button.see_all') }}
                    </link-button>
                </div>
            </div>

            <div v-if="quotations.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <QuotationCard
                    v-for="quotation in quotations"
                    :key="quotation.id"
                    :quotation="quotation"
                    :show-company="false"
                    :detail-route="route('client.quotation.show', quotation)"
                />
            </div>

            <div v-else class="text-gray-500 text-center py-8">
                {{ __('no_results') }}
            </div>
        </div>
    </AuthenticatedLayout>
</template>
