<script setup>

import moment from "moment/moment";
import {useForm} from "@inertiajs/vue3";
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import LinkButton from "@/Components/Buttons/BaseButton.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Pagination from "@/Components/Miscellaneous/Pagination.vue";
import RealButton from "@/Components/Buttons/RealButton.vue";

const props = defineProps({
    type: {
        default: null,
        required: true,
    },
    companies: {
        default: []
    },
    companyTotal: {
        default: null
    },
    companyLinks: {
        default: null
    },
    showFilters: {
        default: true
    },
});

const form = useForm({
    company_name: null,
});

const submit = () => {
    const routeString = 'admin.' + props.type + '.index';

    form.get(route(routeString), {
        preserveScroll: true,
        preserveState: true,
    });
};

</script>

<template>

    <div>
        <div v-if="showFilters" class="admin_filters">
            <form @submit.prevent="submit">
                <div class="form_container">
                    <FormTextInput
                        id="company_name"
                        v-model="form.company_name"
                        :error-message="form.errors.company_name"
                        :label="__('company_name')"
                    />
                </div>

                <div class="results_container">
                    <span class="results_label">
                        {{ companyTotal }} {{ __('results') }}
                    </span>

                    <div class="button_container">
                        <link-button :href="route(('admin.' + props.type + '.index'))">
                            {{ __('button.clear') }}
                        </link-button>
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            {{ __('button.filter') }}
                        </PrimaryButton>
                    </div>
                </div>
            </form>
        </div>

        <div class="admin_table_container">
            <table>
                <thead>
                <tr>
                    <th>{{ __('created_at') }}</th>
                    <th>{{ __('company_name') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="company in companies">
                    <td>{{ moment(company.created_at).format("YYYY-MM-DD") }}</td>
                    <td>
                        <real-button :href="route('admin.company.show', { id:  company.id})">
                            {{ company.name }}
                        </real-button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div v-if="companyLinks" class="pagination_container">
        <pagination :links="companyLinks"/>
    </div>
</template>
