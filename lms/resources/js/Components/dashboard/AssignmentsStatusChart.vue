<template>
  <canvas ref="canvas"></canvas>
</template>

<script>
import { Chart } from "chart.js/auto";

export default {
  props: {
    labels: { type: Array, default: () => [] },
    submitted: { type: Array, default: () => [] },
    graded: { type: Array, default: () => [] },
  },
  mounted() {
    new Chart(this.$refs.canvas, {
      type: 'bar',
      data: {
        labels: this.labels,
        datasets: [
          { label: 'Submitted', data: this.submitted, backgroundColor: '#f59e0b' },
          { label: 'Graded',    data: this.graded,    backgroundColor: '#10b981' },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  }
}
</script>

<style scoped>
canvas { height: 320px; }
</style>
