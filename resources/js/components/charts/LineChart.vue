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
        title: 'Employee Contribution in ther ',
        curveType: 'function',
        legend: { position: 'bottom' },
        width: 800,
        height: 600,
      },
       chartData: [
        ['Year', 'Sales', 'Expenses'],
        ['2004', 1000, 400],
        ['2005', 1170, 460],
        ['2006', 660, 1120],
        ['2007', 1030, 540],
     ]


    };
  },
};
</script>
