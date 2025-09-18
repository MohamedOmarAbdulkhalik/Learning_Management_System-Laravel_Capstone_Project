import './bootstrap';  // إذا تستخدم bootstrap أو أي إعدادات أخرى

import { createApp } from 'vue';

// استيراد مكونات Vue التي ترغب باستخدامها في Blade
import ExampleComponent from './components/ExampleComponent.vue';

// إنشاء التطبيق Vue
const app = createApp({});

// تسجيل المكونات التي تستخدمها
app.component('example-component', ExampleComponent);

// فقط مركب Vue داخل عنصر DOM معين #app أو عنصر محدد
app.mount('#vue-app');  // أو id تختاره

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
