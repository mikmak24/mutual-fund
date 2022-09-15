<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <!-- Page Content  -->
    <div id="content">
      <Navbar />
	  <div  class="p-2 p-md-3">

      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card bg-primary text-white mb-4">
            <div class="card-body"><h5 style="color:white;"><b-icon-calendar2-date></b-icon-calendar2-date> Date Today</h5></div>
            <div
              class="card-footer d-flex align-items-center justify-content-between"
            >
              <h2>{{current_date}}</h2>
              <div class="small text-white">
                <i class="fas fa-angle-right"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-warning text-white mb-4">
            <div class="card-body"><h5 style="color:white;"><b-icon-currency-dollar ></b-icon-currency-dollar> Dollar as the moment</h5></div>
            <div
              class="card-footer d-flex align-items-center justify-content-between"
            >
              <h2>{{$store.getters["authentication/getCurrentDollar"]}}</h2>
              <div class="small text-white">
                <i class="fas fa-angle-right"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-success text-white mb-4">
            <div class="card-body"><h5 style="color:white;"><b-icon-person-circle ></b-icon-person-circle> Number of Employees:</h5></div>
            <div
              class="card-footer d-flex align-items-center justify-content-between"
            >
              <h2>{{$store.getters["authentication/getNumberOfEmp"]}}</h2>
              <div class="small text-white">
                <i class="fas fa-angle-right"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-danger text-white mb-4">
            <div class="card-body"><h5 style="color:white;"> <b-icon-arrow-up></b-icon-arrow-up> Notifications</h5> </div>
            <div
              class="card-footer d-flex align-items-center justify-content-between"
            >
              <h2>{{notifications}}</h2>
              <div class="small text-white">
                <i class="fas fa-angle-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm">
          <GChart :type="type" :data="chartData" :options="chartOptions" />
        </div>
        <div class="col-sm">
          <BarChart />
        </div>
      </div>
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
	},
  data() {
      return {
          current_date: '',
          notifications: 0,

          //
          type: 'LineChart',
          chartOptions: {
            title: "Master Account History of Values",
            curveType: 'function',
            legend: { position: 'top' },
            width: 800,
            height: 600,
          },
          chartData: [
            ['Year', 'Share Value']
         ]

      }
    },
};
</script>
