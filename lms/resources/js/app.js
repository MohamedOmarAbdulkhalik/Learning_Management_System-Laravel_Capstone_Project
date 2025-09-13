import { createApp } from 'vue';

const app = createApp({});
app.mount('#app');

import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
