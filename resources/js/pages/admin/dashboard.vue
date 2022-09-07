<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <!-- Page Content  -->
    <div id="content">
      <Navbar />
	  <div  class="p-2 p-md-3">

      <div class="row">
        <div class="col-sm">

            <b-card
        border-variant="info"
        header="ADMIN DASHBOARD"
        header-bg-variant="info"
        header-text-variant="white"
        style="font-size: 25px;"
      >
      
      <h5> <b-icon-calendar2-date></b-icon-calendar2-date> Date Today: {{current_date}} </h5>
      <h5> <b-icon-currency-dollar ></b-icon-currency-dollar> Dollar as the moment: {{$store.getters["authentication/getCurrentDollar"]}} </h5>
      <h5> <b-icon-person-circle ></b-icon-person-circle> Number of Employees: {{$store.getters["authentication/getNumberOfEmp"]}} </h5>
      </b-card>
        
        </div>


      </div>
      <br>

      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card bg-primary text-white mb-4">
            <div class="card-body">Primary Card</div>
            <div
              class="card-footer d-flex align-items-center justify-content-between"
            >
              <a class="small text-white stretched-link" href="#"
                >View Details</a
              >
              <div class="small text-white">
                <i class="fas fa-angle-right"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-warning text-white mb-4">
            <div class="card-body">Warning Card</div>
            <div
              class="card-footer d-flex align-items-center justify-content-between"
            >
              <a class="small text-white stretched-link" href="#"
                >View Details</a
              >
              <div class="small text-white">
                <i class="fas fa-angle-right"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-success text-white mb-4">
            <div class="card-body">Success Card</div>
            <div
              class="card-footer d-flex align-items-center justify-content-between"
            >
              <a class="small text-white stretched-link" href="#"
                >View Details</a
              >
              <div class="small text-white">
                <i class="fas fa-angle-right"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-danger text-white mb-4">
            <div class="card-body">Danger Card</div>
            <div
              class="card-footer d-flex align-items-center justify-content-between"
            >
              <a class="small text-white stretched-link" href="#"
                >View Details</a
              >
              <div class="small text-white">
                <i class="fas fa-angle-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm">
          <LineChart />
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
import LineChart from '../../components/charts/LineChart'
import BarChart from '../../components/charts/BarChart'


export default {
	name: "Dashboard",
	components: {
		Navbar,
		Sidebar,
		Footer,
		LineChart,
		BarChart
	},
	mounted() {
    var currentDate = new Date();
    this.current_date = currentDate

   	this.$store.dispatch("masteraccount/fetch");
	},
  data() {
      return {
          current_date: ''
      }
    },
};
</script>
