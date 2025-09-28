<script setup>
import Navigation from "@/Components/Layout/Navigation.vue";
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <navigation/>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
        </div>
    </div>
</template>
