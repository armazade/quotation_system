<script>
import {Link} from "@inertiajs/vue3";

export default {
    props: {
        links: Array,
    },
    components: {
        Link
    }
}
</script>

<template>
    <div v-if="links.length > 3" class="my-4">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links" :key="key">
                <div
                    v-if="link.url === null"
                    class="mr-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :class="'bg-white', { 'bg-zinc-100': link.active }"
                    :href="link.url"
                    class="mr-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-zinc-200 focus:border-zinc-500 focus:text-zinc-500"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
