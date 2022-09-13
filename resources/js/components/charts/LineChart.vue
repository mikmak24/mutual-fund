<template>
  <GChart :type="type" :data="chartData" :options="chartOptions" />
</template>

<script>
import { GChart } from 'vue-google-charts/legacy';

// import { chartType, chartData, chartOptions } from './LineChartData';

export default {
  name: 'LineChart',
  components: {
    GChart,
  },
  data() {
    return {
      type: 'LineChart',
      chartOptions: {
        title: "You're Contribution every month",
        curveType: 'function',
        legend: { position: 'top' },
        width: 800,
        height: 600,
      },
       chartData: [
        ['Year', 'Contibution'],
        ['2004', 1000],
        ['2005', 1170],
        ['2006', 660],
        ['2007', 1030],
     ]


    };
  },
};
</script>
