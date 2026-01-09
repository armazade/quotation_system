<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

import { Link } from '@inertiajs/vue3';
import Dropdown from "@/Components/Miscellaneous/Dropdown.vue";
import NavLink from "@/Components/Miscellaneous/NavLink.vue";
import ApplicationLogo from "@/Components/Miscellaneous/ApplicationLogo.vue";
import ResponsiveNavLink from "@/Components/Miscellaneous/ResponsiveNavLink.vue";
import DropdownLink from "@/Components/Miscellaneous/DropdownLink.vue";
import LanguageSwitcher from "@/Components/Miscellaneous/LanguageSwitcher.vue";

const showingNavigationDropdown = ref(false);
const page = usePage();

// Safely access user data
const user = computed(() => page.props.auth?.user);

const isAdmin = computed(() => {
    return page.props.auth?.permissions?.includes('admin_company_list') ?? false;
});

const productIndexRoute = computed(() => {
    return isAdmin.value ? route('admin.product.index') : route('client.product.index');
});

const isProductRoute = computed(() => {
    return route().current('admin.product.*') || route().current('client.product.*');
});

const quotationIndexRoute = computed(() => {
    return isAdmin.value ? route('admin.quotation.index') : route('client.quotation.index');
});

const isQuotationRoute = computed(() => {
    return route().current('admin.quotation.*') || route().current('client.quotation.*') || route().current('quotation.*');
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 flex flex-col">
            <!-- Navigation -->
            <nav class="border-b border-gray-100 bg-white">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    {{ __('dashboard') }}
                                </NavLink>
                                <NavLink
                                    :href="productIndexRoute"
                                    :active="isProductRoute"
                                >
                                    {{ __('products') }}
                                </NavLink>
                                <NavLink
                                    :href="quotationIndexRoute"
                                    :active="isQuotationRoute"
                                >
                                    {{ __('quotations') }}
                                </NavLink>
                                <NavLink
                                    v-if="isAdmin"
                                    :href="route('admin.client.index')"
                                    :active="route().current('admin.client.*') || route().current('admin.company.*')"
                                >
                                    {{ __('companies') }}
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Language Switcher -->
                            <LanguageSwitcher />

                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ user?.full_name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            {{ __('dashboard') }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="productIndexRoute"
                            :active="isProductRoute"
                        >
                            {{ __('products') }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="quotationIndexRoute"
                            :active="isQuotationRoute"
                        >
                            {{ __('quotations') }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            v-if="isAdmin"
                            :href="route('admin.client.index')"
                            :active="route().current('admin.client.*') || route().current('admin.company.*')"
                        >
                            {{ __('companies') }}
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Language Switcher -->
                    <div class="border-t border-gray-200 py-3 px-4">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ __('language') }}</div>
                        <div class="flex flex-wrap gap-2">
                            <a
                                v-for="lang in [
                                    { code: 'en', name: 'EN', flagCode: 'gb' },
                                    { code: 'nl', name: 'NL', flagCode: 'nl' },
                                    { code: 'de', name: 'DE', flagCode: 'de' },
                                    { code: 'fr', name: 'FR', flagCode: 'fr' },
                                ]"
                                :key="lang.code"
                                :href="route('lang.update', { locale: lang.code })"
                                :class="[
                                    'flex items-center gap-1 px-3 py-2 rounded-md text-sm font-medium transition-colors',
                                    $page.props.locale === lang.code
                                        ? 'bg-blue-100 text-blue-700'
                                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                                ]"
                            >
                                <span :class="['fi', `fi-${lang.flagCode}`, 'rounded-sm']"></span>
                                <span>{{ lang.name }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="border-t border-gray-200 pb-1 pt-4">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">
                                {{ user?.full_name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ user?.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-grow">
                <div class="admin_page_container">
                    <div class="content">
                        <!-- Flash Messages -->
                        <template v-if="$page.props.flash?.message">
                            <div
                                v-if="$page.props.flash.message.type === 'success'"
                                id="toast"
                                class="w-full mb-4"
                                role="alert"
                            >
                                <div
                                    class="flex items-center w-full p-4 text-gray-500 bg-white rounded-lg shadow"
                                >
                                    <div
                                        class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                             viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                        </svg>
                                        <span class="sr-only">Check icon</span>
                                    </div>
                                    <div class="ms-3 text-sm font-normal">
                                        {{ __($page.props.flash.message.value, { first_name: user?.first_name }) }}
                                    </div>
                                </div>
                            </div>

                            <div
                                v-if="$page.props.flash.message.type === 'error'"
                                id="toast-danger"
                                class="w-full mb-4"
                                role="alert"
                            >
                                <div class="flex items-center w-full p-4 text-gray-500 bg-white rounded-lg shadow">
                                    <div
                                        class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                             viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                                        </svg>
                                        <span class="sr-only">Error icon</span>
                                    </div>
                                    <div class="ms-3 text-sm font-normal">
                                        {{ __($page.props.flash.message.value, { first_name: user?.first_name }) }}
                                    </div>
                                </div>
                            </div>

                            <div
                                v-if="$page.props.flash.message.type === 'warning'"
                                id="toast-warning"
                                class="w-full mb-4"
                                role="alert"
                            >
                                <div class="flex items-center w-full p-4 text-gray-500 bg-white rounded-lg shadow">
                                    <div
                                        class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg"
                                    >
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                             viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                                        </svg>
                                        <span class="sr-only">Warning icon</span>
                                    </div>
                                    <div class="ms-3 text-sm font-normal">
                                        {{ __($page.props.flash.message.value, { first_name: user?.first_name }) }}
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Warning Lists -->
                        <div
                            v-if="$page.props.flash?.warning_list"
                            id="list-warning"
                            class="w-full mb-4"
                        >
                            <div
                                class="flex p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                <svg
                                    aria-hidden="true"
                                    class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                                </svg>
                                <span class="sr-only">Error icon</span>
                                <div>
                                    <span class="font-medium">{{ $page.props.flash.warning_list.title }}</span>
                                    <ul class="mt-1.5 list-disc list-inside">
                                        <li v-for="item in $page.props.flash.warning_list.list?.translated" :key="item">
                                            {{ item }}
                                        </li>
                                        <li v-for="item in $page.props.flash.warning_list.list?.raw" :key="item">
                                            {{ item }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <slot/>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-blue-900 text-white py-6 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="text-center md:text-left">
                            <img alt="Schut Logo" src="/images/schut_logo.png" class="h-10">
                        </div>
                        <div class="text-center md:text-right">
                            <p class="font-semibold">Questions? Contact our sales team:</p>
                            <p class="text-blue-200">Tom van der Voort</p>
                            <p>
                                <a href="mailto:sales@schut.nl" class="text-white hover:text-blue-200 underline">
                                    sales@schut.nl
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>
