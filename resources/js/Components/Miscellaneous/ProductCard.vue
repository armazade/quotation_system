<script setup>

import LinkButton from "@/Components/Buttons/BaseButton.vue";
import {formatting} from "@/Mixins/formatting";

const props = defineProps({
    product: {
        required: true,
    },
});

</script>

<template>
    <div>
        <div class="relative flex w-full flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
            <!-- Product Details -->
            <div class="mt-4 px-5">
                <div>
                    <h5 class="text-lg tracking-tight text-slate-900">
                        {{ product.name }}
                    </h5>
                    <p v-if="product.article_number" class="text-sm text-gray-500 mt-1">
                        {{ __('article_number') }}: {{ product.article_number }}
                    </p>
                    <p v-if="product.brand" class="text-sm text-gray-500 mt-1">
                        {{ __('brand') }}: {{ product.brand }}
                    </p>
                </div>
                <div class="mt-3 mb-5">
                    <p class="mb-3">
                        <span class="text-xl font-bold text-slate-900">{{ formatting.methods.formatEuro(product.unit_price) }}</span>
                    </p>
                    <link-button :href="route('quotation.create', { product: product.id })" class="w-full text-center">
                        {{ __('button.create_quotation') }}
                    </link-button>
                </div>
            </div>
        </div>
    </div>
</template>
