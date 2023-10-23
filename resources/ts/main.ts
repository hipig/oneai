
import { createApp } from 'vue';
import store from '@/store';
import router from '@/router';
import App from './App.vue';
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';
import Vue3Toasity, { type ToastContainerOptions } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import 'tailwindcss/tailwind.css';

import './api/interceptor';

const app = createApp(App);

app.use(store);
app.use(router);

app.use(Vue3Toasity, {
    autoClose: 3000,
    hideProgressBar: true
} as ToastContainerOptions);

app.component('simplebar', simplebar);

app.mount('#app');
