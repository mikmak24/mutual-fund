<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <!-- Page Content  -->
    <div id="content">
      <Navbar />
      <div class="p-2 p-md-3">
        <b-card-group deck>
          <b-card
            bg-variant="primary"
            text-variant="white"
            header="CURRENT DATE"
            class="text-center"
          >
            <h4 style="color: white">{{current_date}}</h4>
          </b-card>

          <b-card
            bg-variant="secondary"
            text-variant="white"
            header="Dollar Rate as the moment"
            class="text-center"
          >
            <h4 style="color: white">
              {{$store.getters["authentication/getCurrentDollar"]}}
            </h4>
          </b-card>

          <b-card
            bg-variant="success"
            text-variant="white"
            header="Number of Employees:"
            class="text-center"
          >
            <h4 style="color: white">
              {{$store.getters["authentication/getNumberOfEmp"]}}
            </h4>
          </b-card>
        </b-card-group>
        <hr />

        <b-card-group deck>
          <b-card bg-variant="light" text-variant="white" class="text-center">
            <GChart :type="type" :data="chartData" :options="chartOptions" />
          </b-card>

          <b-card bg-variant="light" text-variant="white" class="text-center">
            <GChart
              type="PieChart"
              :data="pieChartData"
              :options="piechartOptions"
            />
          </b-card>
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

export default {
	name: "Dashboard",
	components: {
		Navbar,
		Sidebar,
		Footer,
		BarChart,
    GChart
	},
	mounted() {
    var date = new Date();
    this.current_date = date.getMonth()+"-"+ date.getDate()+"-"+date.getFullYear();
   	this.$store.dispatch("masteraccount/fetch");

    this.$store.dispatch("monthlycontribution/countContributionRequest").then(response => {
      this.notifications = response.count
		});

    this.$store.dispatch("masteraccount/fetchLineChartData").then(response => {

			let array = this.chartData
			for (let i = 0; i < response.length; i++) {
				array.push([response[i].date_of_change, response[i].amount])
			}
			console.log(array)
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

          //
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
            ['Start Year: 2022', 0]
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
