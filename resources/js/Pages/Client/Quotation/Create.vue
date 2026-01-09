<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FormTextInput from '@/Components/Form/FormTextInput.vue';
import FormNumberInput from '@/Components/Form/FormNumberInput.vue';
import FormSelectInput from '@/Components/Form/FormSelectInput.vue';
import { formatting } from '@/Mixins/formatting';
import { translations } from '@/Mixins/translations';
import { ref, computed } from 'vue';

const __ = translations.methods.__;

const props = defineProps({
    products: Array,
    company: Object,
});

const form = useForm({
    reference: null,
    lines: [],
});

const selectedProductId = ref(null);
const selectedQuantity = ref(1);

const productOptions = computed(() => {
    const options = { '': __('select_product') };
    props.products.forEach(product => {
        const brandText = product.brand ? ` (${product.brand})` : '';
        options[product.id] = `${product.name}${brandText} - ${formatting.methods.formatEuro(product.unit_price)}`;
    });
    return options;
});

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

    selectedProductId.value = null;
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

        <div class="admin_form_container">
            <form @submit.prevent="submit">
                <FormTextInput
                    id="reference"
                    v-model="form.reference"
                    :error-message="form.errors.reference"
                    :label="__('reference')"
                    :placeholder="__('reference_placeholder')"
                />

                <hr class="base-hr">

                <div class="mb-4">
                    <h3 class="text-lg font-semibold mb-2">{{ __('products') }}</h3>

                    <div class="flex gap-4 items-end">
                        <div class="flex-1">
                            <FormSelectInput
                                id="product_select"
                                v-model="selectedProductId"
                                :label="__('product')"
                                :options="productOptions"
                            />
                        </div>
                        <div class="w-32">
                            <FormNumberInput
                                id="quantity_select"
                                v-model="selectedQuantity"
                                :label="__('quantity')"
                                :min="1"
                                :step="1"
                            />
                        </div>
                        <div class="input_group">
                            <span class="block font-medium text-sm text-gray-700 invisible">Label</span>
                            <PrimaryButton type="button" @click="addProduct" class="mt-1 whitespace-nowrap">
                                {{ __('button.cart_add') }}
                            </PrimaryButton>
                        </div>
                    </div>
                </div>

                <div v-if="form.lines.length > 0" class="admin_table_container mb-4">
                    <table>
                        <thead>
                            <tr>
                                <th>{{ __('product') }}</th>
                                <th>{{ __('brand') }}</th>
                                <th class="w-24">{{ __('quantity') }}</th>
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

                <div v-if="form.lines.length > 0" class="bg-gray-50 p-4 rounded-lg mb-4">
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
                    <hr class="my-2">
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

                <hr class="base-hr">

                <div class="flex items-left mt-4">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing || form.lines.length === 0 }"
                        :disabled="form.processing || form.lines.length === 0"
                    >
                        {{ __('button.create_quotation') }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
