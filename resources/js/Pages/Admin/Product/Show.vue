<script setup>
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import RouteButton from "@/Components/Buttons/RouteButton.vue";
import {ButtonType} from "@/Enums/ButtonType";
import ProductStatusIndicator from "@/Components/StatusIndicators/ProductStatusIndicator.vue";
import ProductCard from "@/Components/Miscellaneous/ProductCard.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";

defineProps({
    product: Object,
});

</script>

<template>
    <Head title="Product Details"/>

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ product.name }}</h2>
        </template>

        <div class="admin_page_status_container">
            <ProductStatusIndicator :status="product.is_active" class="my-auto"/>

            <div class="button_container">
                <DeleteButton
                    :item="product"
                    route-name="admin.product.destroy"
                />

                <RouteButton
                    :button-type="ButtonType.EDIT"
                    :inertia-route="route('admin.product.edit', product.id)"
                />
            </div>
        </div>

        <ProductCard :product="product"/>
    </AdminLayout>
</template>
