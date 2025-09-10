<script setup>

import moment from "moment/moment";
import {ShipmentProviderType} from "@/Enums/ShipmentProviderType";
import LinkButton from "@/Components/Buttons/BaseButton.vue";
import RealButton from "@/Components/Buttons/RealButton.vue";

const props = defineProps({
    shipments: {
        default: []
    },
    isAdmin: {
        default: false,
    },
});

</script>

<template>
    <div v-if="shipments.length > 0">
        <div class="admin_table_title_container">
            <div class="admin_table_title">{{ __('shipments') }}</div>
        </div>

        <div class="admin_table_container">
            <table>
                <thead>
                <tr>
                    <th>{{ __('sent_at') }}</th>
                    <th>{{ __('shipment_provider') }}</th>
                    <th>{{ __('tracking_code') }}</th>
                    <th v-if="isAdmin"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="shipment in shipments">
                    <td>{{ moment(shipment.sent_at).format("YYYY-MM-DD") }}</td>
                    <td>
                        {{ shipment.shipment_provider === ShipmentProviderType.OTHER ? shipment.shipment_provider_other : __(ShipmentProviderType._KEY + shipment.shipment_provider) }}
                    </td>
                    <td>
                        <real-button
                            v-if="shipment.tracking_url"
                            :href="shipment.tracking_url"
                            target="_blank"
                        >
                            {{ shipment.tracking_code }}
                        </real-button>
                    </td>
                    <td v-if="isAdmin">
                        <template v-if="shipment.shipping_label">
                            <LinkButton
                                :printTargetUrl="route('file.download', {uuid: shipment.shipping_label.uuid})"
                            >
                                {{ __('print') }}
                            </LinkButton>
                        </template>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
