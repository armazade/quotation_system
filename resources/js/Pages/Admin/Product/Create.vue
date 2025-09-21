<script>
import {Head, useForm} from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from "@/Components/Form/Elements/TextInput.vue";
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/Form/Elements/InputError.vue';
import InputLabel from '@/Components/Form/Elements/InputLabel.vue';
import SelectInput from '@/Components/Form/Elements/SelectInput.vue';
import NumberInput from '@/Components/Form/Elements/NumberInput.vue';
import FormCheckboxInput from "@/Components/Form/FormCheckboxInput.vue";
import FormNumberInput from "@/Components/Form/FormNumberInput.vue";
import FormSelectInput from "@/Components/Form/FormSelectInput.vue";
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import FileInput from "@/Components/Form/Elements/FileInput.vue";

export default {
    components: {
        FileInput,
        FormTextInput,
        FormSelectInput,
        FormNumberInput,
        FormCheckboxInput,
        Head, AdminLayout, TextInput, SelectInput, PrimaryButton, InputError, InputLabel, NumberInput
    },
    props: {
        suppliers: Object,
    },
    setup(props) {
        const form = useForm({
            name: null,
            article_number: null,
            description: null,
            unit_price: null,
            is_active: false,
            supplier_id: null,
            file: null,
        })

        function submit() {
            form.post(route('admin.product.store'))
        }

        return {form, submit}
    },
}
</script>

<template>
    <Head :title="__('product.create')"/>

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('product.create') }}</h2>
        </template>

        <div class="admin_form_container">
            <form @submit.prevent="submit()">
                <FormTextInput
                    id="name"
                    v-model="form.name"
                    :error-message="form.errors.name"
                    :label="__('name')"
                    :required="true"
                />

                <FormTextInput
                    id="article_number"
                    v-model="form.article_number"
                    :error-message="form.errors.article_number"
                    :label="__('article_number')"
                    :required="true"
                />

                <hr class="base-hr">

                <FormNumberInput
                    id="unit_price"
                    v-model="form.unit_price"
                    :error-message="form.errors.unit_price"
                    :label="__('unit_price')"
                    :required="true"
                    :step="0.01"
                />

                <FormCheckboxInput
                    id="is_active"
                    v-model:checked="form.is_active"
                    :error-message="form.errors.is_active"
                    :label="__('is_active')"
                />

                <hr class="base-hr">

                <FormSelectInput
                    id="supplier_id"
                    v-model="form.supplier_id"
                    :error-message="form.errors.supplier_id"
                    :label="__('supplier')"
                    :options="suppliers"
                    :required="true"
                />

                <hr class="base-hr">

                <FileInput
                    :accept-mimes="['jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp']"
                    class="mt-1"
                    @input="form.file = $event.target.files[0]"
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
