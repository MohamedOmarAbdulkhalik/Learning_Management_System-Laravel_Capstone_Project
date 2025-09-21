<template>
  <div class="w-full h-64 md:h-48">
    <canvas ref="canvas" class="w-full h-full"></canvas>
  </div>
</template>

<script>
import { Chart } from "chart.js/auto";

export default {
  props: {
    labels: { type: Array, default: () => [] },
    data: { type: Array, default: () => [] }
  },
  mounted() {
    if (this.labels.length > 0 && this.data.length > 0) {
      this.createChart();
    }
  },
  methods: {
    createChart() {
      new Chart(this.$refs.canvas, {
        type: 'line',
        data: {
          labels: this.labels,
          datasets: [{
            label: 'Grades',
            data: this.data,
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#6366f1',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false, // <== هذا يضمن أن canvas يأخذ حجم الحاوية
          scales: {
            y: {
              beginAtZero: true,
              max: 100,
              title: { display: true, text: 'Grade' }
            },
            x: {
              title: { display: true, text: 'Assignments' }
            }
          }
        }
      });
    }
  },
  watch: {
    labels: { handler() { if(this.labels.length && this.data.length) this.createChart(); }, deep: true },
    data: { handler() { if(this.labels.length && this.data.length) this.createChart(); }, deep: true }
  }
}
</script>
