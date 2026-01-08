<script setup>
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import LinkButton from '@/Components/Buttons/BaseButton.vue';

defineProps({
    todayQuotationsCount: Number,
});
</script>

<template>
    <Head :title="__('dashboard')"/>

    <AdminLayout>
        <template #header>
            <h2 class="admin_page_header">{{ __('dashboard') }}</h2>
        </template>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('quotations_today') }}</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ todayQuotationsCount }}</p>
                </div>
                <link-button :href="route('admin.quotation.index')">
                    {{ __('button.see_all') }}
                </link-button>
            </div>
        </div>
    </AdminLayout>
</template>
