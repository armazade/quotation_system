<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Dropdown from "@/Components/Miscellaneous/Dropdown.vue";

const page = usePage();
const currentLocale = computed(() => page.props.locale || 'en');

const languages = [
    { code: 'en', name: 'EN' },
    { code: 'nl', name: 'NL' },
    { code: 'de', name: 'DE' },
];

const currentLanguage = computed(() => {
    return languages.find(lang => lang.code === currentLocale.value) || languages[0];
});

const otherLanguages = computed(() => {
    return languages.filter(lang => lang.code !== currentLocale.value);
});
</script>

<template>
    <Dropdown align="right" width="32">
        <template #trigger>
            <button
                type="button"
                class="inline-flex items-center gap-1 bg-transparent px-3 py-2 text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
            >
                <span>{{ currentLanguage.name }}</span>
                <svg
                    class="h-4 w-4"
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
        </template>

        <template #content>
            <div class="py-1">
                <a
                    v-for="lang in otherLanguages"
                    :key="lang.code"
                    :href="route('lang.update', { locale: lang.code })"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors"
                >
                    {{ lang.name }}
                </a>
            </div>
        </template>
    </Dropdown>
</template>
