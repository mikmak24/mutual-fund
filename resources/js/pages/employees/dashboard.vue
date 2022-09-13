<template>
	<div class="wrapper d-flex align-items-stretch">
		<Sidebar />
		<!-- Page Content  -->
		<div id="content">
			<Navbar />
			<div class="p-4 p-md-5">
				<b-card-group deck>
					<b-card
						border-variant="primary"
						header="Number of times you Contributed"
						header-bg-variant="primary"
						header-text-variant="white"
						align="center"
					>
						<b-card-text
							><h6 style="color: blue;">
								{{ $store.getters["monthlycontribution/gettotalMonthContr"] }}
							</h6></b-card-text
						>
					</b-card>

					<b-card
						border-variant="success"
						header="Total Amount Contributed"
						header-bg-variant="success"
						header-text-variant="white"
						align="center"
					>
						<b-card-text
							><h6 style="color: green;">
								${{ $store.getters["monthlycontribution/gettotalEmployeeContr"] }}
							</h6></b-card-text
						>
					</b-card>

					<b-card
						border-variant="info"
						header="Total Contribution By Employer"
						header-bg-variant="info"
						header-text-variant="white"
						align="center"
					>
						<b-card-text
							><h6 style="color: skyblue;">
								${{ $store.getters["monthlycontribution/gettotalEmployerContr"] }}
							</h6></b-card-text
						>
					</b-card>

					<b-card
						border-variant="danger"
						header="Personal Contribution Amount"
						header-bg-variant="danger"
						header-text-variant="white"
						align="center"
					>
						<b-card-text
							><h6 style="color: red;">
								{{ $store.getters["monthlycontribution/getmonthlyContribution"] }}% -
								per month
							</h6></b-card-text
						>
					</b-card>
				</b-card-group>
				<br />
				<b-jumbotron >
					<template #lead>
						<h1 style="color:black;"><b>PERSONAL COMPANY SHARE: </b></h1>

						<h3 style="color:red;" v-if="showValue">
							${{
								$store.getters["monthlycontribution/gettotalEmployeeContr"] +
									$store.getters["monthlycontribution/gettotalEmployerContr"]
							}}
						</h3>
						<h3 v-if="showString">
							********************
						</h3>
					</template>

					<hr class="my-4" />

                    <b-button v-if="showValue"  @click="clickShowString()" variant="outline-dark">HIDE</b-button>
					<b-button v-if="showString" @click="clickShowValue()" variant="outline-dark" size="sm" class="mb-2">
                        <b-icon icon="eye-fill" aria-hidden="true"></b-icon> SHOW
                    </b-button>
				</b-jumbotron>

				<b-card-group deck>
					<b-card
						overlay
						:img-src="require('../../assets/images/account.jpg')"
						img-alt="Card Image"
						text-variant="black"
					>
						
					</b-card>

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
			console.log(array)
		});
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

			//
			type: 'LineChart',
			chartOptions: {
				title: "You're Contribution every month",
				curveType: 'function',
				legend: { position: 'top' },
				width: 800,
				height: 600,
			},
			chartData: [
				[
					'Year', 
					'Contribution'
				]
			]
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

	}
};
</script>
