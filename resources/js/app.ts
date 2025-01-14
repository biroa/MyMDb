import './bootstrap';
import '../css/app.css';
import 'vue3-easy-data-table/dist/style.css';
import 'flowbite';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Vue3EasyDataTable from 'vue3-easy-data-table';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        let app = createApp({ render: () => h(App, props) });
        app.use(plugin)
        app.use(ZiggyVue)
        app.component('EasyDataTable', Vue3EasyDataTable)
        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
