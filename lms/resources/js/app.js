import './bootstrap';  // إذا تستخدم bootstrap أو أي إعدادات أخرى

import { createApp } from 'vue';

// استيراد مكونات Vue التي ترغب باستخدامها في Blade
import ExampleComponent from './components/ExampleComponent.vue';
import AssignmentsStatusChart from './Components/dashboard/AssignmentsStatusChart.vue';
import CourseDistributionChart from './Components/dashboard/CourseDistributionChart.vue';
import GradesChart from './Components/dashboard/GradesChart.vue';
// إنشاء التطبيق Vue
const app = createApp({});

// تسجيل المكونات التي تستخدمها
app.component('example-component', ExampleComponent);
app.component('assignments-status-chart', AssignmentsStatusChart);
app.component('course-distribution-chart', CourseDistributionChart);
app.component('grades-chart', GradesChart);
// فقط مركب Vue داخل عنصر DOM معين #app أو عنصر محدد
app.mount('#vue-app');  // أو id تختاره

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
