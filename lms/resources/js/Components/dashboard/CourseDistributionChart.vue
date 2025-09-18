<template>
  <canvas ref="canvas"></canvas>
</template>

<script>
import { Chart } from "chart.js/auto";

export default {
  props: ['labels','data'],
  mounted() {
    new Chart(this.$refs.canvas, {
      type: 'pie',
      data: {
        labels: this.labels,
        datasets: [{
          data: this.data,
          backgroundColor: ['#60a5fa','#34d399','#f87171','#fbbf24'],
        }]
      }
    });
  }
}
</script>
