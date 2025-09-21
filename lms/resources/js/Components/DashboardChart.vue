<template>
  <canvas ref="canvas"></canvas>
</template>

<script>
import { Chart } from 'chart.js/auto';

export default {
  props: ['data','labels'],
  mounted() {
    new Chart(this.$refs.canvas, {
      type: 'bar',
      data: {
        labels: this.labels,
        datasets: [{
          label: 'Statistics',
          data: this.data,
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
        }]
      }
    });
  }
}
</script>
