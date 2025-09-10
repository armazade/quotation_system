<script setup>

import {ButtonType} from "@/Enums/ButtonType";
import {CountryType} from "@/Enums/CountryType";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import RouteButton from "@/Components/Buttons/RouteButton.vue";

const props = defineProps({
    company: {
        default: []
    },
    actor: {
        default: 'client'
    },
});

</script>

<template>
    <div v-if="company.locations.length > 0">
        <div class="admin_table_title_container">
            <div class="admin_table_title">{{ __('addresses') }}</div>

            <RouteButton
                :button-type="ButtonType.CREATE"
                :inertia-route="route((props.actor + '.location.create'), company.id)"
            />
        </div>

        <div class="admin_table_container">
            <table>
                <thead>
                <tr>
                    <th>{{ __('address') }}</th>
                    <th>{{ __('zip_code') }}</th>
                    <th>{{ __('city') }}</th>
                    <th>{{ __('country') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="location in company.locations">
                    <td>{{ location.address_line_1 }}</td>
                    <td>{{ location.zip_code }}</td>
                    <td>{{ location.city }}</td>
                    <td>{{ __(CountryType._KEY + location.country) }}</td>
                    <td class="action_button_container">
                        <RouteButton
                            :buttonType="ButtonType.EDIT"
                            :inertia-route="route((props.actor + '.location.edit'), location.id)"
                        />

                        <DeleteButton
                            v-if="!location.is_default"
                            :item="location"
                            :route-name="(props.actor + '.location.destroy')"
                        />
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
