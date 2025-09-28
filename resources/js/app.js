import '../css/app.css';
import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import i18n from './plugins/i18n';
import {formatting} from "@/Mixins/formatting";
import {translations} from "@/Mixins/translations";
import {permissions} from "@/Mixins/permissions";
import {urlParameters} from "@/Mixins/urlParameters";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .mixin(formatting)
            .mixin(translations)
            .mixin(permissions)
            .mixin(urlParameters)
            .mount(el)

    },
    progress: {
        color: '#4B5563',
    }
});
