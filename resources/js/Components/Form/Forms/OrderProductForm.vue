<script setup>

import FormCheckboxInput from "@/Components/Form/FormCheckboxInput.vue";
import InputError from "@/Components/Form/Elements/InputError.vue";
import FileInput from "@/Components/Form/Elements/FileInput.vue";
import FormTextareaInput from "@/Components/Form/FormTextareaInput.vue";
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import {TransferType} from "@/Enums/TransferType";
import {SizeType} from "@/Enums/SizeType";
import FormSelectInput from "@/Components/Form/FormSelectInput.vue";

const props = defineProps({
    form: {
        required: true,
    },
    quotation: {
        required: true,
    },
    product: {
        required: true,
    },
    acceptMimes: {
        required: true,
    },
    fileUploadTypes: {
        required: true,
    },
});

</script>

<template>
    <div class="flex flex-row space-x-10">
        <div class="flex flex-col flex-1 space-y-4">
            <template v-if="product.transfer_type === TransferType.PMS && product.pms_color_amount > 0">
                <div class="flex flex-col space-y-3">
                    <FormTextInput
                        v-for="(index) in parseInt(product.pms_color_amount)"
                        :id="product.id + '.pms_colors.' + index"
                        v-model="form['pms_colors'][index-1]"
                        :label="__('color') + ' ' + index"
                        :required="true"
                    />
                </div>

                <InputError :message="form.errors.pms_colors" class="mt-2"/>

                <hr class="base-hr">
            </template>

            <FormTextareaInput
                v-model="form.remark"
                :error-message="form.errors.remark"
                :label="__('remark')"
            />

            <hr class="base-hr">

            <div class="input_group space-y-3">
                <FormSelectInput
                    id="shipping_location_id"
                    v-model="form.file_upload_method"
                    :error-message="form.errors.file_upload_method"
                    :has-translations="true"
                    :label="__('technical_drawing_upload')"
                    :options="fileUploadTypes"
                    :placeholderValue="''"
                    :required="true"
                    class="mt-1 block w-full"
                    translation-prefix="file_upload_type"
                />

                <template v-if="form.file_upload_method !== null">
                    <FormTextInput
                        v-if="form.file_upload_method === fileUploadTypes.link"
                        id="file_link"
                        v-model="form.file_link"
                        :error-message="form.errors.file_link"
                        :label="__('technical_drawing_alternative_upload', {'reference': quotation.reference})"
                        :required="true"
                    />

                    <template v-else>
                        <FileInput
                            :accept-mimes="acceptMimes"
                            class="mt-1"
                            @input="form.file = $event.target.files[0]"
                        />

                        <InputError :message="form.errors.file" class="mt-2"/>
                    </template>

                    <hr class="base-hr">

                    <FormCheckboxInput
                        id="rights_declared"
                        v-model:checked="form.rights_declared"
                        :error-message="form.errors.rights_declared"
                        :label="__('declare_image_rights')"
                        :required="true"
                    />
                </template>
            </div>
        </div>
        <div class="flex flex-col flex-1">
            <div>
                {{ __(TransferType._KEY + product.transfer_type) }}
            </div>
            <div>
                {{ product.transfer_name }}
            </div>
            <div>
                {{ __(SizeType._KEY + product.size_type) }}
            </div>
            <div>
                {{ product.has_blocker ? __('blocker_yes') : __('blocker_no') }}
            </div>
            <div v-if="product.pms_color_amount > 0">
                {{ __('colors', {amount: product.pms_color_amount}) }}
            </div>
        </div>
    </div>
</template>
