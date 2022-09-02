<template>
  <GChart :type="type" :data="data" :options="options" />
</template>

<script>
import { GChart } from 'vue-google-charts/legacy';


export default {
  name: 'GoogleChart',
  components: {
    GChart,
  },
  data() {
    return {
      data:  [
        ['City', '2010 Population', '2000 Population'],
        ['New York City, NY', 8175000, 8008000],
        ['Los Angeles, CA', 3792000, 3694000],
        ['Chicago, IL', 2695000, 2896000],
        ['Houston, TX', 2099000, 1953000],
        ['Philadelphia, PA', 1526000, 1517000],
    ],
      
      type: 'BarChart',
      options: {
        title: 'Population of Largest U.S. Cities',
        chartArea: { width: '50%' },
        hAxis: {
            title: 'Total Population',
            minValue: 0,
        },
        vAxis: {
            title: 'City',
        },
        width: 800,
        height: 600,
        }
     };
  },
};
</script>
