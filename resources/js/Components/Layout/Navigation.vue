<script setup>
import {ref, computed} from 'vue';
import Dropdown from "@/Components/Miscellaneous/Dropdown.vue";
import ApplicationLogo from "@/Components/Miscellaneous/ApplicationLogo.vue";
import NavLink from "@/Components/Miscellaneous/NavLink.vue";
import ResponsiveNavLink from "@/Components/Miscellaneous/ResponsiveNavLink.vue";
import {Link, usePage} from "@inertiajs/vue3";
import DropdownLink from "@/Components/Miscellaneous/DropdownLink.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

const showingNavigationDropdown = ref(false);
const page = usePage();
const user = computed(() => page.props.auth?.user);
const fullName = computed(() => {
    if (!user.value) return '';
    return `${user.value.first_name} ${user.value.last_name}`;
});

const activeMenu = {
    dashboard: (route().current('admin.dashboard') || route().current('dashboard')),
    adminQuotations: (route().current('admin.quotation.index') || route().current('admin.quotation.show') || route().current('quotation.create') || route().current('admin.quotation_line.create')),
    adminProducts: (route().current('admin.product.index') || route().current('admin.product.show') || route().current('admin.product.edit') || route().current('admin.product.create')),
    adminUsers: (route().current('admin.user.index') || route().current('admin.user.show')),
    adminSuppliers: (route().current('admin.supplier.index') || route().current('admin.supplier.create')),
    adminClients: (route().current('admin.client.index')),

    clientQuotations: (route().current('client.quotation.index') || route().current('client.quotation.show') || route().current('quotation.create')),
}

</script>

<template>
    <nav class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('dashboard')">
                            <ApplicationLogo
                                class="block h-9 w-auto fill-current text-gray-800"
                            />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-6 sm:-my-px sm:ml-10 lg:flex">
                        <NavLink
                            v-if="!hasPermission($page.props.auth.permissions, 'admin_order_list')"
                            :active="activeMenu.dashboard"
                            :href="route('dashboard')"
                        >
                            {{ __('dashboard') }}
                        </NavLink>

                        <NavLink
                            v-if="hasPermission($page.props.auth.permissions, 'admin_quotation_list')"
                            :active="activeMenu.adminQuotations"
                            :href="route('admin.quotation.index')"
                        >
                            {{ __('quotations') }}
                        </NavLink>

                        <div v-if="hasPermission($page.props.auth.permissions, 'admin_company_list')" class="my-auto">
                            <Dropdown align="right">
                                <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        class="inline-flex items-center  border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        type="button"
                                    >
                                        {{ __('companies') }}
                                        <svg
                                            class="ml-2 -mr-0.5 h-4 w-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                clip-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                fill-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </span>
                                </template>

                                <template #content>

                                    <DropdownLink
                                        v-if="hasPermission($page.props.auth.permissions, 'admin_user_list')"
                                        :active="activeMenu.adminUsers"
                                        :href="route('admin.user.index')"
                                    >
                                        {{ __('users') }}
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>

                        <div v-if="hasPermission($page.props.auth.permissions, 'admin_product_list')" class="my-auto">
                            <Dropdown align="right">
                                <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        type="button"
                                    >
                                        {{ __('products') }}
                                        <svg
                                            class="ml-2 -mr-0.5 h-4 w-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                clip-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                fill-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </span>
                                </template>

                                <template #content>
                                    <DropdownLink
                                        v-if="hasPermission($page.props.auth.permissions, 'admin_product_list')"
                                        :active="activeMenu.adminProducts"
                                        :href="route('admin.product.index')"
                                    >
                                        {{ __('products') }}
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>

                        <NavLink
                            v-if="hasPermission($page.props.auth.permissions, 'client_quotation_list')"
                            :active="activeMenu.clientQuotations"
                            :href="route('client.quotation.index')"
                        >
                            {{ __('quotations') }}
                        </NavLink>
                    </div>
                </div>

                <div class="hidden lg:flex sm:items-center sm:ml-6">

                    <!-- Settings Dropdown -->
                    <div v-if="$page.props.auth.user" class="ml-3 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        type="button"
                                    >
                                        {{ fullName }}

                                        <svg
                                            class="ml-2 -mr-0.5 h-4 w-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                clip-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                fill-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink
                                    v-if="hasPermission($page.props.auth.permissions, 'client_company_read')"
                                    :active="route().current('client.company.show')"
                                    :href="route('client.company.show')"
                                >
                                    {{ __('my_company') }}
                                </DropdownLink>
                                <DropdownLink :href="route('profile.edit')"> {{ __('profile') }}</DropdownLink>
                                <DropdownLink :href="route('logout')" as="button" method="post">
                                    {{ __('button.logout') }}
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>

                    <div v-if="!$page.props.auth.user" class="ml-3 relative">
                        <PrimaryButton
                            class="mr-2"
                            onclick="window.location.href='register'"
                            type="button"
                        >
                            {{ __('button.register') }}
                        </PrimaryButton>

                        <PrimaryButton
                            onclick="window.location.href='login'"
                            type="button"
                        >
                            {{ __('button.login') }}
                        </PrimaryButton>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center lg:hidden">
                    <button
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                    >
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }"
                                d="M4 6h16M4 12h16M4 18h16"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                            />
                            <path
                                :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }"
                                d="M6 18L18 6M6 6l12 12"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
            :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
            class="lg:hidden"
        >
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink
                    v-if="!hasPermission($page.props.auth.permissions, 'admin_order_list')"
                    :active="activeMenu.dashboard"
                    :href="route('dashboard')"
                >
                    {{ __('dashboard') }}
                </ResponsiveNavLink>

                <ResponsiveNavLink
                    v-if="hasPermission($page.props.auth.permissions, 'admin_quotation_list')"
                    :active="activeMenu.adminQuotations"
                    :href="route('admin.quotation.index')"
                >
                    {{ __('quotations') }}
                </ResponsiveNavLink>

                <ResponsiveNavLink
                    v-if="hasPermission($page.props.auth.permissions, 'admin_company_list')"
                    :active="activeMenu.adminClients"
                    :href="route('admin.client.index')"
                >
                    {{ __('clients') }}
                </ResponsiveNavLink>

                <ResponsiveNavLink
                    v-if="hasPermission($page.props.auth.permissions, 'admin_company_list')"
                    :active="activeMenu.adminSuppliers"
                    :href="route('admin.supplier.index')"
                >
                    {{ __('suppliers') }}
                </ResponsiveNavLink>

                <ResponsiveNavLink
                    v-if="hasPermission($page.props.auth.permissions, 'admin_user_list')"
                    :active="activeMenu.adminUsers"
                    :href="route('admin.user.index')"
                >
                    {{ __('users') }}
                </ResponsiveNavLink>

                <ResponsiveNavLink
                    v-if="hasPermission($page.props.auth.permissions, 'admin_product_list')"
                    :active="activeMenu.adminTransfers"
                    :href="route('admin.transfer.index')"
                >
                    {{ __('products') }}
                </ResponsiveNavLink>

                <ResponsiveNavLink
                    v-if="hasPermission($page.props.auth.permissions, 'client_quotation_list')"
                    :active="activeMenu.clientQuotations"
                    :href="route('client.quotation.index')"
                >
                    {{ __('quotations') }}
                </ResponsiveNavLink>
            </div>

            <!-- Responsive Settings Options -->
            <div v-if="$page.props.auth.user" class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">
                        {{ $page.props.auth.user.name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink
                        v-if="hasPermission($page.props.auth.permissions, 'client_company_read')"
                        :active="route().current('client.company.show')"
                        :href="route('client.company.show')"
                    >
                        {{ __('my_company') }}
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('profile.edit')"> {{ __('profile') }}</ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('logout')" as="button" method="post">
                        {{ __('button.logout') }}
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>
</template>
