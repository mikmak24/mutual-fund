<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <!-- Page Content  -->
    <div id="content">
      <Navbar />
      <div class="p-4 p-md-5">
      
        <b-card-group deck>
          <div class="card" style="width: 18rem;">
            <img src="https://mdbcdn.b-cdn.net/img/new/standard/nature/182.webp" class="card-img-top" alt="Sunset Over the Sea"/>
            <div class="card-body">
              <p class="card-text">Your Total Personal Contribution: ${{ items.total_employee_contr }}</p>
            </div>
          </div>

          <div class="card" style="width: 18rem;">
            <img src="https://mdbcdn.b-cdn.net/img/new/standard/nature/182.webp" class="card-img-top" alt="Sunset Over the Sea"/>
            <div class="card-body">
              <p class="card-text">Your Employer Total Contribution: ${{ items.total_employer_contr }}</p>
            </div>
          </div>

           <div class="card" style="width: 18rem;">
            <img src="https://mdbcdn.b-cdn.net/img/new/standard/nature/182.webp" class="card-img-top" alt="Sunset Over the Sea"/>
            <div class="card-body">
              <p class="card-text">Total Contribution (Combined): ${{ items.total_contribution }}</p>
            </div>
          </div>
  
        </b-card-group>
        <br>
        <b-card-group deck>

          <b-card bg-variant="secondary" text-variant="white" header="Your Total Percentage of your share in the Company" class="text-center">
             <b-card-text>
                {{ (items.total_contribution / total_employees_contribution) * 100}}%
            </b-card-text>
          </b-card>

         
        </b-card-group>

        <br />
        <b-jumbotron>
          <template #lead>
            <h1 style="color: black"><b>PERSONAL COMPANY SHARE: </b></h1>

            <h3 style="color: red" v-if="showValue">
              {{ calculateAmountEarned(items.total_contribution)}}

            </h3>
            <h3 v-if="showString">********************</h3>
          </template>

          <hr class="my-4" />

          <b-button
            v-if="showValue"
            @click="clickShowString()"
            variant="outline-dark"
            >HIDE</b-button
          >
          <b-button
            v-if="showString"
            @click="clickShowValue()"
            variant="outline-dark"
            size="sm"
            class="mb-2"
          >
            <b-icon icon="eye-fill" aria-hidden="true"></b-icon> SHOW
          </b-button>
        </b-jumbotron>

        <b-card-group deck>
        

          <GChart :type="type" :data="chartData" :options="chartOptions" />
        </b-card-group>
      </div>
    </div>
  </div>
</template>

<script>
import { GChart } from 'vue-google-charts/legacy';

import Navbar from "../../components/Navbar";
import Sidebar from "../../components/Sidebar";
import Footer from "../../components/Footer";
// import LineChart from '../../components/charts/LineChart'

export default {
	name: "Dashboard",
	components: {
		Navbar,
		Sidebar,
		Footer,
		GChart
	},
	mounted() {
		var currentDate = new Date();
		this.current_date = currentDate;
	},
	mounted() {
		this.$store.dispatch("employees/fetchChartData").then(response => {

			let array = this.chartData
			for (let i = 0; i < response.length; i++) {
				array.push([response[i].year, response[i].employee_contribution])
			}
		});

    this.$store.dispatch("employees/fetchIndvDashboardDetails")
      .then(response => {
          this.items = response;
          console.log(this.items.total_employee_contr)
    })

     this.$store.dispatch("masteraccount/fetch")
      .then(response => {
          console.log(response[0]['master_account_amount'])
          this.master_account_amount = response[0]['master_account_amount']
      })

      this.$store.dispatch("employees/fetchTotalEmployeeContribution")
      .then(response => {
                  loader.hide()

          this.total_employees_contribution = response
      })


	},
	data() {
		return {
			monthly_contribution: 0,
			total_employee_contr: 0,
			total_employer_contr: 0,
			total_month_contr: 0,
			form: {
				contribution: ""
			},
			current_date: "",
			showString: true,
      showValue: false,
      master_account_amount: 0,
      total_employees_contribution: 0,
			type: 'LineChart',
			chartOptions: {
				title: "You're Contribution every month",
				curveType: 'function',
				legend: { position: 'top' },
				width: 800,
				height: 600,
			},
			chartData: [
				['Year', 'Contribution'],
				['Start Year: 2022', 0]
			],
      items: []
		};
	},
	methods: {
        clickShowValue(){
            this.showString = false
            this.showValue = true
        },

        clickShowString(){
            this.showString = true
            this.showValue = false
        },

         calculatePercentageEarned(total){
          let val = (total / this.total_employees_contribution) * 100
          return val.toFixed(2)
        },

        calculateAmountEarned(total){
            let percentage = this.calculatePercentageEarned(total)
            return ((percentage / 100) * this.master_account_amount).toFixed(2)
        },

	}
};
</script>
