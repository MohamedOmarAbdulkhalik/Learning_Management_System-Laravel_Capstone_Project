<template>
  <canvas ref="canvas"></canvas>
</template>

<script>
import { Chart } from "chart.js/auto";

export default {
  props: ['labels','data'],
  mounted() {
    new Chart(this.$refs.canvas, {
      type: 'bar',
      data: {
        labels: this.labels,
        datasets: [{
          label: 'Assignments',
          data: this.data,
          backgroundColor: ['#3b82f6','#10b981'],
        }]
      }
    });
  }
}
</script>
