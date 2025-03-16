import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import "vue-multiselect/dist/vue-multiselect.css";
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

import './../../public/scss/main.scss'
import 'bootstrap-icons/font/bootstrap-icons.css'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

import '../../public/js/core/popper.min.js'
import '../../public/js/plugins/perfect-scrollbar.min.js'
import '../../public/js/plugins/chartjs.min.js'
import '../../public/css/nucleo-svg.css'
import '../../public/css/argon-dashboard.css'

import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

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
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

