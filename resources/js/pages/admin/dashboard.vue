<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <!-- Page Content  -->
    <div id="content">
      <Navbar />
      <div class="p-2 p-md-3">
        <b-card-group deck>
          <div class="card">
            <img src="../../assets/images/calendar.jpeg" class="card-img-top" alt="Fissure in Sandstone"/>
            <div class="card-body">
              <p class="card-text"> <vue-clock /></p>
            </div>
          </div>

          <div class="card">
            <img src="../../assets/images/dollar.jpg" class="card-img-top" alt="Fissure in Sandstone"/>
            <div class="card-body">
              <h5 class="card-title">Dollar Rate as of the moment</h5>
              <h4 class="card-text">{{$store.getters["authentication/getCurrentDollar"]}}</h4>
            </div>
          </div>

           <div class="card">
            <img src="../../assets/images/employee.jpeg" class="card-img-top" alt="Fissure in Sandstone"/>
            <div class="card-body">
              <h5 class="card-title">Total Number of Employees</h5>
              <h4 class="card-text">{{$store.getters["authentication/getNumberOfEmp"]}}</h4>
            </div>
          </div>


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

        <br>

        <!-- <b-card-group deck>
          <b-card bg-variant="light" text-variant="white" class="text-center">
            <GChart type="BarChart" :data="chartData" :options="chartOptions" />
          </b-card>
        </b-card-group> -->
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
    //  this.current_date = new Date().format('m-d-Y h:i:s');
    // this.current_date = date.getMonth()+"-"+ date.getDate()+"-"+date.getFullYear();
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
