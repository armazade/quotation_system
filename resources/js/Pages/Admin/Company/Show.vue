<script setup>
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {CompanyType} from "@/Enums/CompanyType";
import AdminQuotationTable from "@/Components/Tables/AdminQuotationTable.vue";
import RouteButton from "@/Components/Buttons/RouteButton.vue";
import {ButtonType} from "@/Enums/ButtonType";
import CompanyDetails from "@/Components/Details/CompanyDetails.vue";
import LocationsTable from "@/Components/Tables/LocationsTable.vue";
import AdminUserTable from "@/Components/Tables/AdminUserTable.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    company: Object,
    orderCount: {
        default: null
    },
    quotationCount: {
        default: null
    },
    creditTransactionCount: {
        default: null
    }
});

const isValidating = ref(false);

const validateVat = (company) => {
    if (isValidating.value) return;

    isValidating.value = true;

    router.post(route('admin.company.validate_vat', company.id), {}, {
        preserveScroll: true,
        onFinish: () => {
            isValidating.value = false;
        }
    });
};

</script>

<template>
    <Head :title="company.name"/>

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ company.name }}</h2>
        </template>

        <div class="admin_page_status_container">
            <div>
                <span :class="['font-bold uppercase border p-1 rounded whitespace-nowrap bg-gray-200 border-gray-300 text-xs'] ">
                    {{ __(company.company_type) }}
                </span>
            </div>

            <div class="button_container">
                <DeleteButton
                    :item="company"
                    route-name="admin.company.destroy"
                />

                <RouteButton
                    :button-type="ButtonType.EDIT"
                    :inertia-route="route('admin.company.edit', company)"
                />
            </div>
        </div>

        <CompanyDetails :company="company"/>

        <LocationsTable :company="company" actor="admin"/>

        <div v-if="company.company_type === CompanyType.CLIENT">
            <div class="admin_table_title_container flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="admin_table_title"> {{ __('quotations') }} ({{ quotationCount }})</div>
                </div>
                <div class="button_container">
                    <RouteButton
                        :button-type="ButtonType.CREATE"
                        :inertia-route="route('quotation.create', {'company': company.id})"
                    />
                </div>
            </div>

            <AdminQuotationTable
                :quotations="company.quotations"
                :show-company-name="false"
                :show-filters="false"
                :show-user-name="true"
            />
        </div>

        <div v-if="company.company_type === CompanyType.CLIENT">
            <div class="admin_table_title_container">
                <div class="admin_table_title"> {{ __('users') }}</div>
            </div>

            <AdminUserTable
                :show-company-name="false"
                :show-filters="false"
                :users="company.users"
            />
        </div>
    </AdminLayout>
</template>
