<script setup>
import Navigation from "@/Components/Layout/Navigation.vue";
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <navigation/>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="admin_page_container">
                    <div class="content">
                        <div v-if="$page.props.flash.message" class="alert mb-4">
                            {{ $page.props.flash.message }}
                        </div>

                        <slot/>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
