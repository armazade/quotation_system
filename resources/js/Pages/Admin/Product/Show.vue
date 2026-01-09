<script setup>
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import RouteButton from "@/Components/Buttons/RouteButton.vue";
import {ButtonType} from "@/Enums/ButtonType";
import ProductStatusIndicator from "@/Components/StatusIndicators/ProductStatusIndicator.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import LinkButton from "@/Components/Buttons/BaseButton.vue";
import {formatting} from "@/Mixins/formatting";

defineProps({
    product: Object,
    canEdit: {
        type: Boolean,
        default: false,
    },
});

</script>

<template>
    <Head title="Product Details"/>

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ product.name }}</h2>
        </template>

        <div v-if="canEdit" class="admin_page_status_container">
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

        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('product_details') }}</h3>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('name') }}</dt>
                            <dd class="text-base text-gray-900">{{ product.name }}</dd>
                        </div>

                        <div v-if="product.article_number">
                            <dt class="text-sm font-medium text-gray-500">{{ __('article_number') }}</dt>
                            <dd class="text-base text-gray-900">{{ product.article_number }}</dd>
                        </div>

                        <div v-if="product.brand">
                            <dt class="text-sm font-medium text-gray-500">{{ __('brand') }}</dt>
                            <dd class="text-base text-gray-900">{{ product.brand }}</dd>
                        </div>

                        <div v-if="product.description">
                            <dt class="text-sm font-medium text-gray-500">{{ __('description') }}</dt>
                            <dd class="text-base text-gray-900">{{ product.description }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('unit_price') }}</dt>
                            <dd class="text-2xl font-bold text-blue-700">{{ formatting.methods.formatEuro(product.unit_price) }}</dd>
                        </div>

                        <div v-if="product.supplier">
                            <dt class="text-sm font-medium text-gray-500">{{ __('supplier') }}</dt>
                            <dd class="text-base text-gray-900">{{ product.supplier.name }}</dd>
                        </div>
                    </dl>
                </div>

                <div v-if="!canEdit" class="flex flex-col justify-center items-center bg-gray-50 rounded-lg p-6">
                    <p class="text-gray-600 mb-4 text-center">{{ __('create_quotation_with_product') }}</p>
                    <link-button :href="route('quotation.create', { product: product.id })" class="text-lg px-6 py-3">
                        {{ __('button.create_quotation') }}
                    </link-button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
