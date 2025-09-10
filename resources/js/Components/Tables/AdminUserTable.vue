<script setup>

import moment from "moment/moment";
import {useForm} from "@inertiajs/vue3";
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import LinkButton from "@/Components/Buttons/BaseButton.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Pagination from "@/Components/Miscellaneous/Pagination.vue";
import RealButton from "@/Components/Buttons/RealButton.vue";

const props = defineProps({
    users: {
        default: []
    },
    userTotal: {
        default: null
    },
    userLinks: {
        default: null
    },
    showCompanyName: {
        default: true
    },
    showFilters: {
        default: true
    },
});

const form = useForm({
    full_name: null,
    email: null,
    company_name: null,
});

const submit = () => {
    form.get(route('admin.user.index'), {
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
                        id="full_name"
                        v-model="form.full_name"
                        :error-message="form.errors.full_name"
                        :label="__('name')"
                    />

                    <FormTextInput
                        id="email"
                        v-model="form.email"
                        :error-message="form.errors.email"
                        :label="__('email')"
                    />

                    <FormTextInput
                        id="company_name"
                        v-model="form.company_name"
                        :error-message="form.errors.company_name"
                        :label="__('company_name')"
                    />
                </div>

                <div class="results_container">
                    <span class="results_label">
                        {{ userTotal }} {{ __('results') }}
                    </span>

                    <div class="button_container">
                        <link-button :href="route('admin.user.index')">
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
                    <th>{{ __('email') }}</th>
                    <th>{{ __('name') }}</th>
                    <th v-if="showCompanyName">{{ __('company_name') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users">
                    <td>{{ moment(user.created_at).format("YYYY-MM-DD") }}</td>
                    <td>
                        <real-button :href="route('admin.user.show', { id:  user.id})">
                            {{ user.email }}
                        </real-button>
                    </td>
                    <td>{{ user.full_name }}</td>
                    <td v-if="showCompanyName">
                        <real-button :href="route('admin.company.show', { id:  user.company.id})">
                            {{ user.company.name }}
                        </real-button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div v-if="userLinks" class="pagination_container">
        <pagination :links="userLinks"/>
    </div>
</template>
