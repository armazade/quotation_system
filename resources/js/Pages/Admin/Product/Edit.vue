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
        product: Object,
        suppliers: Object,
    },
    setup(props) {
        const form = useForm({
            name: props.product.name,
            unit_price: props.product.unit_price,
            is_active: props.product.is_active,
            supplier_id: props.product.supplier_id,
            article_number: props.product.article_number,
            file: null,
            _method: 'PATCH',
        })

        function submit() {
            form.post(route('admin.product.update', props.product.id), {
                forceFormData: true
            });
        }

        return {form, submit}
    },
}
</script>

<template>
    <Head :title="__('product.edit')"/>

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('product.edit') }}</h2>
        </template>

        <div class="admin_form_container">
            <form @submit.prevent="submit()">
                <FormTextInput
                    id="article_number"
                    v-model="form.article_number"
                    :error-message="form.errors.article_number"
                    :label="__('article_number')"
                    :required="true"
                />

                <hr class="base-hr">

                <FormTextInput
                    id="name"
                    v-model="form.name"
                    :error-message="form.errors.name"
                    :label="__('name')"
                    :required="true"
                />

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

                <div>
                    <input id="file" type="file" @change="e => form.file = e.target.files[0]"/>
                </div>

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
