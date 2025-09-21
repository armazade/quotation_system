<script setup>
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3'
import AdminCompanyTable from "@/Components/Tables/AdminCompanyTable.vue";
import {CompanyType} from "@/Enums/CompanyType";

defineProps({
    companies: Object,
})
</script>

<template>
    <Head title="Companies" />

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('companies') }}</h2>
        </template>

        <AdminCompanyTable
            :companies="companies.data"
            :company-links="companies.links"
            :company-total="companies.total"
            :type="CompanyType.CLIENT"
        />
    </AdminLayout>
</template>
