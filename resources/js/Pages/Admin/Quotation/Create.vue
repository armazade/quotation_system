<script>
import {Head, useForm} from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import FormSelectInput from "@/Components/Form/FormSelectInput.vue";
import FormTextInput from "@/Components/Form/FormTextInput.vue";

export default {
    components: {
        Head,
        AdminLayout,
        PrimaryButton,
        FormSelectInput,
        FormTextInput
    },
    props: {
        companies: Object,
    },
    setup(props) {
        const form = useForm({
            company_id: null,
            reference: null,
        })

        function submit() {
            form.post(route('admin.quotation.store'))
        }

        return {form, submit}
    },
}
</script>

<template>
    <Head :title="__('quotation.create')"/>

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('quotation.create') }}</h2>
        </template>

        <div class="admin_form_container">
            <form @submit.prevent="submit()">
                <FormSelectInput
                    id="company_id"
                    v-model="form.company_id"
                    :error-message="form.errors.company_id"
                    :label="__('company')"
                    :options="companies"
                    :required="true"
                />


                <hr class="base-hr">

                <div class="flex items-left mt-4">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        {{ __('button.save') }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
