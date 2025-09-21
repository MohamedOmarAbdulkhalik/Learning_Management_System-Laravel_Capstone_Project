<template>
  <div>
    <h3>مكون Vue تفاعلي!</h3>
    <p>{{ message }}</p>
    <button @click="updateMessage">غيّر الرسالة</button>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const message = ref('مرحبا من Vue');

function updateMessage() {
  message.value = 'تم التحديث!';
}
</script>

<style scoped>
h3 {
  color: blue;
}
</style>
