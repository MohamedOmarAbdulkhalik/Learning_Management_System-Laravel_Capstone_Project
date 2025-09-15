import { createApp } from 'vue';
import DeleteConfirm from './Components/DeleteConfirm.vue';

const app = createApp({});
app.component('delete-confirm', DeleteConfirm);
app.mount('#app');

import './bootstrap';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();
