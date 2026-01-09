<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Dropdown from "@/Components/Miscellaneous/Dropdown.vue";

const page = usePage();
const currentLocale = computed(() => page.props.locale || 'en');

const languages = [
    { code: 'en', name: 'EN', flag: '🇬🇧' },
    { code: 'nl', name: 'NL', flag: '🇳🇱' },
    { code: 'de', name: 'DE', flag: '🇩🇪' },
    { code: 'fr', name: 'FR', flag: '🇫🇷' },
];

const currentLanguage = computed(() => {
    return languages.find(lang => lang.code === currentLocale.value) || languages[0];
});
</script>

<template>
    <Dropdown align="right" width="40">
        <template #trigger>
            <button
                type="button"
                class="inline-flex items-center gap-2 bg-transparent px-3 py-2 text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
            >
                <span class="text-base">{{ currentLanguage.flag }}</span>
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
                    v-for="lang in languages"
                    :key="lang.code"
                    :href="route('lang.update', { locale: lang.code })"
                    :class="[
                        'flex items-center gap-3 px-4 py-2 text-sm transition-colors',
                        currentLocale === lang.code
                            ? 'bg-blue-50 text-blue-700 font-medium'
                            : 'text-gray-700 hover:bg-gray-100'
                    ]"
                >
                    <span class="text-base">{{ lang.flag }}</span>
                    <span>{{ lang.name }}</span>
                    <svg
                        v-if="currentLocale === lang.code"
                        class="ml-auto h-4 w-4 text-blue-600"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </a>
            </div>
        </template>
    </Dropdown>
</template>
