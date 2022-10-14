<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <div id="content">
      <Navbar />
      <div class="p-2 p-md-3">
        <b-card-group deck>
          <div class="card">
            <a class="img-card" href="#">
              <img src="../../assets/images/calendar.jpeg" />
            </a>
            <div class="card-content">
              <p class="">
                <vue-clock />
              </p>
            </div>
          </div>
          <div class="card">
            <a class="img-card" href="#">
              <img src="../../assets/images/dollar.jpg" />
            </a>
            <div class="card-content">
              <h5 class="card-title">Dollar Rate as of the moment</h5>
              <h4 class="card-text">
                {{$store.getters["authentication/getCurrentDollar"]}}
              </h4>
            </div>
          </div>
        </b-card-group>
        <hr />
        <b-card-group deck>
          <div class="card" v-if="showChart" style="width: 18rem">
              <GChart :type="type" :data="chartData" :options="chartOptions" />
          </div>
          <div class="card" v-if="showChart" style="width: 18rem">
             <GChart
              type="ColumnChart"
              :data="columnchartData"
              :options="chartOptions"
            />
          </div>
        </b-card-group>
        <br>
         <b-card-group deck>
          <div class="card" v-if="showChart" style="width: 18rem">
            <GChart
              type="PieChart"
              :data="pieChartData"
              :options="piechartOptions"
            />
          </div>
        </b-card-group>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "../../components/Navbar";
import Sidebar from "../../components/Sidebar";
import Footer from "../../components/Footer";
import BarChart from '../../components/charts/BarChart'
import { GChart } from 'vue-google-charts/legacy';
import VueClock from '@dangvanthanh/vue-clock';

export default {
	name: "Dashboard",
	components: {
		Navbar,
		Sidebar,
		Footer,
		BarChart,
    GChart,
    VueClock
	},
	mounted() {
   	this.$store.dispatch("masteraccount/fetch");
    this.$store.dispatch("monthlycontribution/countContributionRequest").then(response => {
      this.notifications = response.count
		});
    this.$store.dispatch("masteraccount/fetchLineChartData").then(response => {
			let array = this.chartData
      let array2 = this.columnchartData
			for (let i = 0; i < response.length; i++) {
				array.push([response[i].date_of_change, response[i].amount])
        array2.push([response[i].date_of_change, response[i].percentage, response[i].amount])
			}
      this.showChart = true
    });

    this.$store.dispatch("employees/fetchActiveInActiveEmployee").then(response => {
        let array = this.pieChartData
        array.push(['Active', response['active']])
        array.push(['Inactive', response['inactive']])
		});
	},
  data() {
      return {
          current_date: '',
          notifications: 0,
          showChart: false,
          type: 'LineChart',
          pietype: 'PieChart',
          chartOptions: {
            title: "Master Account History of Values",
            curveType: 'function',
            legend: { position: 'top' },
            width: 800,
            height: 600,
          },
          chartData: [
            ['Year', 'Share Value'],

          ],
          columnchartData: [
            ['Year', 'Percentage', 'Company Share']
          ],
          pieChartData: [
              ['Task', 'Hours per Day']
          ],
          piechartOptions: {
            title: 'Percentage of Active and Inactive Employees',
            width: 800,
            height: 600,
          }
      }
    },
};
</script>
<style scoped>
html,
body {
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  height: 100%;
  width: 100%;
  background: #fff;
  font-family: "Roboto", sans-serif;
  font-weight: 400;
}

.wrapper {
  display: table;
  height: 100%;
  width: 100%;
}

.container-fostrap {
  display: table-cell;
  padding: 1em;
  text-align: center;
  vertical-align: middle;
}
.fostrap-logo {
  width: 100px;
  margin-bottom: 15px;
}
h1.heading {
  color: #fff;
  font-size: 1.15em;
  font-weight: 900;
  margin: 0 0 0.5em;
  color: #505050;
}
@media (min-width: 450px) {
  h1.heading {
    font-size: 3.55em;
  }
}
@media (min-width: 760px) {
  h1.heading {
    font-size: 3.05em;
  }
}
@media (min-width: 900px) {
  h1.heading {
    font-size: 3.25em;
    margin: 0 0 0.3em;
  }
}
.card {
  display: block;
  margin-bottom: 20px;
  line-height: 1.42857143;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  transition: box-shadow 0.25s;
}
.card:hover {
  box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.img-card {
  width: 100%;
  height: 200px;
  border-top-left-radius: 2px;
  border-top-right-radius: 2px;
  display: block;
  overflow: hidden;
}
.img-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  transition: all 0.25s ease;
}
.card-content {
  padding: 15px;
  text-align: left;
}
.card-title {
  margin-top: 0px;
  font-weight: 700;
  font-size: 1.65em;
}
.card-title a {
  color: #000;
  text-decoration: none !important;
}
.card-read-more {
  border-top: 1px solid #d4d4d4;
}
.card-read-more a {
  text-decoration: none !important;
  padding: 10px;
  font-weight: 600;
  text-transform: uppercase;
}
</style>
