require('./bootstrap');
import 'element-plus/dist/index.css'

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { ZiggyVue } from '../../../../../vendor/tightenco/ziggy/dist/vue.m';
import NotificationPlugin from '@taskmanager/Plugins/NotificationPlugin';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(NotificationPlugin)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
