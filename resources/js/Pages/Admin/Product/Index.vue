<script setup>
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3'
import Pagination from '@/Components/Miscellaneous/Pagination.vue';
import LinkButton from "@/Components/Buttons/BaseButton.vue";
import RealButton from "@/Components/Buttons/RealButton.vue";
import ProductStatusIndicator from "@/Components/StatusIndicators/ProductStatusIndicator.vue";
import {formatting} from "@/Mixins/formatting";
import {ref, watch} from 'vue';
import {translations} from "@/Mixins/translations";
import debounce from 'lodash/debounce';

const __ = translations.methods.__;

const props = defineProps({
    products: Object,
    canCreate: {
        type: Boolean,
        default: false,
    },
    filters: {
        type: Object,
        default: () => ({ search: '' }),
    },
});

const search = ref(props.filters?.search || '');

const doSearch = debounce(() => {
    const routeName = props.canCreate ? 'admin.product.index' : 'client.product.index';
    router.get(route(routeName), { search: search.value }, {
        preserveState: true,
        replace: true,
    });
}, 300);

watch(search, () => {
    doSearch();
});

const productRoute = (product) => {
    return props.canCreate
        ? route('admin.product.show', { id: product.id })
        : route('client.product.show', { product: product.id });
};
</script>

<template>
    <Head :title="__('products')"/>

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('products') }}</h2>
        </template>

        <div class="admin_page_status_container">
            <div class="flex-1">
                <input
                    type="text"
                    v-model="search"
                    :placeholder="__('search_product_placeholder')"
                    class="w-full max-w-md border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                />
            </div>
            <div v-if="canCreate" class="button_container">
                <link-button :href="route('admin.product.create')">
                    {{ __('button.create') }}
                </link-button>
            </div>
        </div>

        <div class="admin_table_container">
            <table>
                <thead>
                <tr>
                    <th>{{ __('article_number') }}</th>
                    <th>{{ __('name')}}</th>
                    <th>{{ __('brand') }}</th>
                    <th>{{ __('unit_price') }}</th>
                    <th>{{ __('supplier') }}</th>
                    <th v-if="canCreate">{{ __('is_active') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products.data">
                    <td>
                        <real-button :href="productRoute(product)">
                            {{ product.article_number }}
                        </real-button>
                    </td>
                    <td>
                        <real-button :href="productRoute(product)">
                            {{ product.name }}
                        </real-button>
                    </td>
                    <td>{{ product.brand }}</td>
                    <td>{{ formatting.methods.formatEuro(product.unit_price) }}</td>
                    <td>
                        <template v-if="canCreate">
                            <real-button :href="route('admin.company.show', { company:  product.supplier.id})">
                                {{ product.supplier.name }}
                            </real-button>
                        </template>
                        <template v-else>
                            {{ product.supplier.name }}
                        </template>
                    </td>
                    <td v-if="canCreate">
                        <ProductStatusIndicator :status="product.is_active" class="my-auto"/>
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
