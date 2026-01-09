<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FormTextInput from '@/Components/Form/FormTextInput.vue';
import { formatting } from '@/Mixins/formatting';
import { translations } from '@/Mixins/translations';
import { ref, computed } from 'vue';

const __ = translations.methods.__;

const props = defineProps({
    products: Array,
    company: Object,
    preselectedProduct: Object,
});

const form = useForm({
    reference: null,
    lines: [],
});

const selectedProductId = ref(null);
const selectedQuantity = ref(1);
const searchQuery = ref('');
const showDropdown = ref(false);

// Auto-add preselected product if provided
if (props.preselectedProduct) {
    form.lines.push({
        product_id: props.preselectedProduct.id,
        description: props.preselectedProduct.name,
        quantity: 1,
        unit_price: props.preselectedProduct.unit_price,
        product: props.preselectedProduct,
    });
}

const filteredProducts = computed(() => {
    let results = props.products;

    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        results = props.products.filter(product => {
            return product.name.toLowerCase().includes(query) ||
                   product.article_number?.toLowerCase().includes(query) ||
                   product.brand?.toLowerCase().includes(query);
        });
    }

    return results.slice(0, 50);
});

function selectProduct(product) {
    selectedProductId.value = product.id;
    const brandText = product.brand ? ` (${product.brand})` : '';
    searchQuery.value = `${product.article_number} - ${product.name}${brandText}`;
    showDropdown.value = false;
}

function handleFocus() {
    showDropdown.value = true;
}

function handleBlur() {
    setTimeout(() => {
        showDropdown.value = false;
    }, 200);
}

function clearSearch() {
    searchQuery.value = '';
    selectedProductId.value = null;
    showDropdown.value = false;
}

const subtotal = computed(() => {
    return form.lines.reduce((sum, line) => sum + (line.quantity * line.unit_price), 0);
});

const deliveryCost = computed(() => {
    return subtotal.value < 50 ? 9.00 : 0.00;
});

const grandTotal = computed(() => {
    return subtotal.value + deliveryCost.value;
});

const amountForFreeDelivery = computed(() => {
    return Math.max(0, 50 - subtotal.value);
});

function addProduct() {
    if (!selectedProductId.value) return;

    const product = props.products.find(p => p.id === selectedProductId.value);
    if (!product) return;

    const existingIndex = form.lines.findIndex(l => l.product_id === product.id);
    if (existingIndex >= 0) {
        form.lines[existingIndex].quantity += selectedQuantity.value;
    } else {
        form.lines.push({
            product_id: product.id,
            description: product.name,
            quantity: selectedQuantity.value,
            unit_price: product.unit_price,
            product: product,
        });
    }

    clearSearch();
    selectedQuantity.value = 1;
}

function removeLine(index) {
    form.lines.splice(index, 1);
}

function updateQuantity(index, newQuantity) {
    if (newQuantity < 1) {
        removeLine(index);
    } else {
        form.lines[index].quantity = newQuantity;
    }
}

function submit() {
    form.post(route('quotation.store'));
}
</script>

<template>
    <Head :title="__('quotation.request')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('quotation.request') }}</h2>
        </template>

        <div class="bg-white shadow-sm sm:rounded-lg">
            <form @submit.prevent="submit" class="px-6 py-6">
                <FormTextInput
                    id="reference"
                    v-model="form.reference"
                    :error-message="form.errors.reference"
                    :label="__('reference')"
                    :placeholder="__('reference_placeholder')"
                />

                <hr class="my-6 border-gray-200">

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('products') }}</h3>

                    <div class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-end">
                        <!-- Product Search -->
                        <div class="flex-1 relative">
                            <label class="block font-medium text-sm text-gray-700 mb-1">{{ __('product') }}</label>
                            <input
                                type="text"
                                v-model="searchQuery"
                                @focus="handleFocus"
                                @blur="handleBlur"
                                :placeholder="__('search_product_placeholder')"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                            <div
                                v-if="showDropdown && filteredProducts.length > 0"
                                class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-80 overflow-auto"
                            >
                                <div
                                    v-for="product in filteredProducts"
                                    :key="product.id"
                                    @mousedown.prevent="selectProduct(product)"
                                    class="px-4 py-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-b-0"
                                >
                                    <div class="font-medium text-gray-900">{{ product.article_number }} - {{ product.name }}</div>
                                    <div class="text-sm text-gray-500 flex justify-between mt-1">
                                        <span>{{ product.brand || '-' }}</span>
                                        <span class="font-semibold text-blue-700">{{ formatting.methods.formatEuro(product.unit_price) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="w-full sm:w-28">
                            <label class="block font-medium text-sm text-gray-700 mb-1">{{ __('quantity') }}</label>
                            <input
                                type="number"
                                v-model.number="selectedQuantity"
                                min="1"
                                step="1"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>

                        <!-- Add Button -->
                        <div class="w-full sm:w-auto">
                            <PrimaryButton
                                type="button"
                                @click="addProduct"
                                class="w-full sm:w-auto whitespace-nowrap"
                                :disabled="!selectedProductId"
                            >
                                {{ __('button.cart_add') }}
                            </PrimaryButton>
                        </div>
                    </div>
                </div>

                <div v-if="form.lines.length > 0" class="admin_table_container mb-6">
                    <table>
                        <thead>
                            <tr>
                                <th>{{ __('product') }}</th>
                                <th>{{ __('brand') }}</th>
                                <th class="w-28">{{ __('quantity') }}</th>
                                <th class="text-right">{{ __('unit_price') }}</th>
                                <th class="text-right">{{ __('costs_total') }}</th>
                                <th class="w-20"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(line, index) in form.lines" :key="index">
                                <td>{{ line.description }}</td>
                                <td>{{ line.product?.brand || '-' }}</td>
                                <td>
                                    <input
                                        type="number"
                                        :value="line.quantity"
                                        @change="updateQuantity(index, parseInt($event.target.value))"
                                        min="1"
                                        class="w-20 border-gray-300 rounded-md shadow-sm text-center"
                                    />
                                </td>
                                <td class="text-right">{{ formatting.methods.formatEuro(line.unit_price) }}</td>
                                <td class="text-right">{{ formatting.methods.formatEuro(line.quantity * line.unit_price) }}</td>
                                <td class="text-center">
                                    <button type="button" @click="removeLine(index)" class="text-red-600 hover:text-red-800">
                                        {{ __('button.delete') }}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="form.lines.length > 0" class="bg-gray-50 p-5 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('quotation_total') }}</h3>

                    <div class="flex justify-between mb-2">
                        <span>{{ __('costs_subtotal') }}</span>
                        <span>{{ formatting.methods.formatEuro(subtotal) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>{{ __('costs_shipping') }}</span>
                        <span v-if="deliveryCost > 0">{{ formatting.methods.formatEuro(deliveryCost) }}</span>
                        <span v-else class="text-green-600 font-semibold">{{ __('delivery_free') }}</span>
                    </div>
                    <div v-if="amountForFreeDelivery > 0" class="text-sm text-gray-500 mb-2">
                        {{ __('add_for_free_delivery', { amount: formatting.methods.formatEuro(amountForFreeDelivery) }) }}
                    </div>
                    <hr class="my-3">
                    <div class="flex justify-between font-bold text-lg">
                        <span>{{ __('costs_total') }}</span>
                        <span>{{ formatting.methods.formatEuro(grandTotal) }}</span>
                    </div>

                    <div class="mt-4 text-sm text-gray-600 bg-blue-50 p-3 rounded">
                        {{ __('delivery_info') }}
                    </div>
                </div>

                <div v-if="form.errors.lines" class="text-red-600 mb-4">
                    {{ form.errors.lines }}
                </div>

                <hr class="my-6 border-gray-200">

                <div class="flex items-center gap-4">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing || form.lines.length === 0 }"
                        :disabled="form.processing || form.lines.length === 0"
                    >
                        {{ __('button.request_quotation') }}
                    </PrimaryButton>
                    <p class="text-sm text-gray-500">{{ __('quotation_disclaimer') }}</p>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
