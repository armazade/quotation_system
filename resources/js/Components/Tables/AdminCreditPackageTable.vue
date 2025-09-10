<script setup>

import moment from "moment/moment";
import Pagination from "@/Components/Miscellaneous/Pagination.vue";
import ProductStatusIndicator from "@/Components/StatusIndicators/ProductStatusIndicator.vue";
import {formatting} from "@/Mixins/formatting";
import {round} from "@popperjs/core/lib/utils/math";
import RealButton from "@/Components/Buttons/RealButton.vue";

const props = defineProps({
    packages: {
        default: []
    },
    packageLinks: {
        default: null
    },
});

</script>

<template>
    <div>
        <div class="admin_table_container">
            <table>
                <thead>
                <tr>
                    <th>{{ __('is_active') }}</th>
                    <th>{{ __('created_at') }}</th>
                    <th>{{ __('name') }}</th>
                    <th class="text-right">{{ __('unit_price') }}</th>
                    <th class="text-right">{{ __('credits') }}</th>
                    <th class="text-right">{{ __('free_credits') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="creditPackage in packages">
                    <td>
                        <ProductStatusIndicator :status="creditPackage.is_active" class="my-auto"/>
                    </td>
                    <td>{{ moment(creditPackage.created_at).format("YYYY-MM-DD") }}</td>
                    <td>
                        <real-button :href="route('admin.credit_package.show', { id:  creditPackage.id})">
                            {{ creditPackage.name }}
                        </real-button>
                    </td>
                    <td class="text-right">{{ formatting.methods.formatEuro(creditPackage.unit_price) }}</td>
                    <td class="text-right">{{ creditPackage.amount }}</td>
                    <td class="text-right">{{ round(creditPackage.amount - creditPackage.unit_price) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div v-if="packageLinks" class="pagination_container">
        <pagination :links="packageLinks"/>
    </div>
</template>
