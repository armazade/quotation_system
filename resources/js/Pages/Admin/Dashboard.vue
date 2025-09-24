<script setup>
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head :title="__('dashboard')"/>

    <AdminLayout>
        <template #header>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                </div>
            </div>
        </div>
    </AdminLayout>
</template>
