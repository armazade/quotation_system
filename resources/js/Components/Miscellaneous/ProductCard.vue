<script setup>

import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import {formatting} from "@/Mixins/formatting";

const props = defineProps({
    product: {
        required: true,
    },
});

</script>

<template>
    <div>
        <div class="relative flex w-full max-w-xs flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
            <!-- Product Details -->
            <div class="mt-4 px-5">
                <div>
                    <h5
                        class="text-lg tracking-tight text-slate-900 truncate"
                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                    >
                        {{ product.name }}
                    </h5>
                    <p v-if="product.brand" class="text-sm text-gray-500 mt-1">
                        {{ product.brand }}
                    </p>
                </div>
                <div class="mt-2 mb-5 flex items-center justify-between">
                    <p>
                        <span class="text-xl font-bold text-slate-900">{{ formatting.methods.formatEuro(product.unit_price) }}</span>
                    </p>
                    <PrimaryButton class="ml-4">
                        {{ __('button.cart_add') }}
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </div>
</template>
