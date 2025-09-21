<script setup>

import RealButton from "@/Components/Buttons/RealButton.vue";

const props = defineProps({
    company: {
        required: true,
    },
});

</script>

<template>
    <div class="inline-grid grid-cols-2 mx-auto space-x-4 w-full">
        <div class="admin_vertical_table_container">
            <div class="admin_table_title_container">
                <div class="admin_table_title">{{ __('company_details') }}</div>
            </div>

            <div class="table_container">
                <table>
                    <tbody>
                    <tr>
                        <th>{{ __('company_name') }}</th>
                        <td>{{ company.name }}</td>
                    </tr>

                    <tr>
                        <th>{{ __('phone_number') }}</th>
                        <td>{{ company.phone_country_code + ' ' + company.phone_number }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('email') }}</th>
                        <td>{{ company.email }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('website') }}</th>
                        <td>
                            <real-button :href="company.website" target="_blank">
                                {{ company.website }}
                            </real-button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="admin_vertical_table_container">
            <div class="admin_table_title_container">
                <div class="admin_table_title">{{ __('legal_details') }}</div>
            </div>

            <div class="table_container">
                <table>
                    <tbody>
                    <tr>
                        <th>{{ __('vat_number') }}</th>
                        <td>{{ company.vat_number }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('coc_number') }}</th>
                        <td>{{ company.coc_number }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('legal_owner') }}</th>
                        <td>{{ company.legal_owner }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('bic_number') }}</th>
                        <td>{{ company.bic_number }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('iban_number') }}</th>
                        <td>{{ company.iban_number }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
