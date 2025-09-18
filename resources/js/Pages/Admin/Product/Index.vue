<script setup>
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3'
import Pagination from '@/Components/Miscellaneous/Pagination.vue';
import LinkButton from "@/Components/Buttons/BaseButton.vue";
import RealButton from "@/Components/Buttons/RealButton.vue";
import ProductStatusIndicator from "@/Components/StatusIndicators/ProductStatusIndicator.vue";

defineProps({
    products: Object,
});
</script>

<template>
    <Head :title="__('products')"/>

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('products') }}</h2>
        </template>

        <div class="admin_page_status_container">
            <div class="button_container">
                <link-button :href="route('admin.product.create')">
                    {{ __('button.create') }}
                </link-button>
            </div>
        </div>

        <div class="admin_table_container">
            <table>
                <thead>
                <tr>
                    <th>{{ __('is_active') }}</th>
                    <th>{{ __('name') }}</th>
                    <th>{{ __('supplier') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products.data">
                    <td>
                        <ProductStatusIndicator :status="product.is_active" class="my-auto"/>
                    </td>
                    <td>
                        <real-button :href="route('admin.product.show', { id:  product.id})">
                            {{ product.name }}
                        </real-button>
                    </td>
                    <td>
                        <real-button :href="route('admin.company.show', { id:  product.supplier.id})">
                            {{ product.supplier.name }}
                        </real-button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination_container">
            <pagination :links="products.links"/>
        </div>
    </AdminLayout>
</template>
