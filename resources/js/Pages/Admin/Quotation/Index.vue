<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminQuotationTable from '@/Components/Tables/AdminQuotationTable.vue';
import LinkButton from '@/Components/Buttons/BaseButton.vue';

defineProps({
    quotations: Object,
    quotationStatusTypes: Object,
});
</script>

<template>
    <Head :title="__('quotations')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('quotations') }}</h2>
        </template>

        <div class="admin_page_status_container">
            <div class="button_container">
                <link-button :href="route('admin.quotation.create')">
                    {{ __('button.create') }}
                </link-button>
            </div>
        </div>

        <AdminQuotationTable
            :quotations="quotations.data"
            :quotation-total="quotations.total"
            :quotation-links="quotations.links"
            :quotation-status-types="quotationStatusTypes"
            :show-filters="true"
            :show-company-name="true"
        />
    </AuthenticatedLayout>
</template>
