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
    <Head :title="__('quotation.create')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('quotation.create') }}</h2>
        </template>

        <div class="bg-white shadow-sm sm:rounded-lg">
            <form @submit.prevent="submit" class="p-8">

                <!-- Reference Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('reference') }}</h3>
                    <FormTextInput
                        id="reference"
                        v-model="form.reference"
                        :error-message="form.errors.reference"
                        :label="__('reference')"
                        :placeholder="__('reference_placeholder')"
                    />
                </div>

                <hr class="border-gray-200 my-8">

                <!-- Products Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('products') }}</h3>

                    <!-- Add Product Row -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <p class="text-sm text-gray-600 mb-4">{{ __('search_and_add_products') }}</p>

                        <div class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-end">
                            <!-- Product Search -->
                            <div class="flex-1 relative">
                                <label class="block font-medium text-sm text-gray-700 mb-2">{{ __('product') }}</label>
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
                                <label class="block font-medium text-sm text-gray-700 mb-2">{{ __('quantity') }}</label>
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
                                    class="w-full sm:w-auto whitespace-nowrap px-6"
                                    :disabled="!selectedProductId"
                                >
                                    {{ __('button.cart_add') }}
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>

                    <!-- Product Lines Table -->
                    <div v-if="form.lines.length > 0" class="border border-gray-200 rounded-lg overflow-hidden mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('product') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('brand') }}</th>
                                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-28">{{ __('quantity') }}</th>
                                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('unit_price') }}</th>
                                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('costs_total') }}</th>
                                    <th class="px-6 py-4 w-20"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="(line, index) in form.lines" :key="index">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ line.description }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ line.product?.brand || '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <input
                                            type="number"
                                            :value="line.quantity"
                                            @change="updateQuantity(index, parseInt($event.target.value))"
                                            min="1"
                                            class="w-20 border-gray-300 rounded-md shadow-sm text-center text-sm"
                                        />
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-right">{{ formatting.methods.formatEuro(line.unit_price) }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">{{ formatting.methods.formatEuro(line.quantity * line.unit_price) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" @click="removeLine(index)" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            {{ __('button.delete') }}
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center mb-6">
                        <p class="text-gray-500">{{ __('no_products_added') }}</p>
                    </div>
                </div>

                <!-- Order Summary Section -->
                <div v-if="form.lines.length > 0" class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('quotation_total') }}</h3>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>{{ __('costs_subtotal') }}</span>
                                <span>{{ formatting.methods.formatEuro(subtotal) }}</span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>{{ __('costs_shipping') }}</span>
                                <span v-if="deliveryCost > 0">{{ formatting.methods.formatEuro(deliveryCost) }}</span>
                                <span v-else class="text-green-600 font-semibold">{{ __('delivery_free') }}</span>
                            </div>

                            <div v-if="amountForFreeDelivery > 0" class="text-sm text-gray-500 py-2">
                                {{ __('add_for_free_delivery', { amount: formatting.methods.formatEuro(amountForFreeDelivery) }) }}
                            </div>

                            <hr class="border-gray-300 my-3">

                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span>{{ __('costs_total') }}</span>
                                <span>{{ formatting.methods.formatEuro(grandTotal) }}</span>
                            </div>
                        </div>

                        <div class="mt-6 text-sm text-gray-600 bg-blue-50 p-4 rounded-lg">
                            {{ __('delivery_info') }}
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                <div v-if="form.errors.lines" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-600">
                    {{ form.errors.lines }}
                </div>

                <hr class="border-gray-200 my-8">

                <!-- Submit Section -->
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">{{ __('quotation_disclaimer') }}</p>
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing || form.lines.length === 0 }"
                        :disabled="form.processing || form.lines.length === 0"
                        class="px-8 py-3"
                    >
                        {{ __('button.create_quotation') }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
