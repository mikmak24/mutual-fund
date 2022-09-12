<template>
	<div class="wrapper d-flex align-items-stretch">
		<Sidebar />
		<!-- Page Content  -->
		<div id="content">
			<Navbar />
				  <div  class="p-4 p-md-5">

            <h2 class="mb-4">Employee Dashboard</h2>

			  <b-card-group deck>
			
				<b-card
					overlay
					:img-src="require('../../assets/images/account.jpg')"
					img-alt="Card Image"
					text-variant="black"
				>
				<p style="color: black; font-size: 20px;"><b-icon-calendar2-date></b-icon-calendar2-date> Date Today: {{current_date}} </p>
				<p style="color: black;  font-size: 20px;"><b-icon-currency-dollar ></b-icon-currency-dollar>Total shares in the Company: ${{$store.getters["monthlycontribution/gettotalEmployeeContr"] + $store.getters["monthlycontribution/gettotalEmployerContr"]}}</p>
				</b-card>

				<b-card
					overlay
					img-alt="Card Image"
					text-variant="black"
				>
					<h2><b-icon-currency-dollar ></b-icon-currency-dollar>Current Dollar Rate: <b>{{$store.getters["authentication/getCurrentDollar"]}}</b></h2>

				</b-card>

				</b-card-group>
				<br>

				  <b-card-group deck>
					<b-card
						border-variant="primary"
						header="Number of Month Contributed"
						header-bg-variant="primary"
						header-text-variant="white"
						align="center"
					>
						<b-card-text><h6 style="color: blue;">{{$store.getters["monthlycontribution/gettotalMonthContr"]}}</h6></b-card-text>
					</b-card>

					<b-card
						border-variant="success"
						header="Total Amount Contributed"
						header-bg-variant="success"
						header-text-variant="white"
						align="center"
					>
						<b-card-text><h6 style="color: green;">${{$store.getters["monthlycontribution/gettotalEmployeeContr"]}}</h6></b-card-text>
					</b-card>

					<b-card
						border-variant="info"
						header="Total Contribution By Employer"
						header-bg-variant="info"
						header-text-variant="white"
						align="center"
					>
						<b-card-text><h6 style="color: skyblue;">${{$store.getters["monthlycontribution/gettotalEmployerContr"]}}</h6></b-card-text>
					</b-card>

					<b-card
						border-variant="danger"
						header="Personal Contribution Amount"
						header-bg-variant="danger"
						header-text-variant="white"
						align="center"
					>
						<b-card-text><h6 style="color: red;">{{$store.getters["monthlycontribution/getmonthlyContribution"]}}% - per month</h6></b-card-text>
					</b-card>
				</b-card-group>
				<br>
		</div>
		</div>
	</div>
</template>

<script>
import Navbar from "../../components/Navbar";
import Sidebar from "../../components/Sidebar";
import Footer from "../../components/Footer";

export default {
	name: "Dashboard",
	components: {
    Navbar,
    Sidebar,
    Footer
},
	mounted(){
		var currentDate = new Date();
    	this.current_date = currentDate
	},
	// mounted() {
	// 	this.$store.dispatch("monthlycontribution/fetchEmpDashboardCardDetails").then(response => {
	// 		this.monthly_contribution = response[0].employee_monthly_contribution
	// 		this.total_employee_contr = response[0].total_employee_contr
	// 		this.total_employer_contr = response[0].total_employer_contr
	// 		this.total_month_contr = response[0].total_month_contr
	// 	});
	// },
	 data() {
      return {
		monthly_contribution: 0,
		total_employee_contr: 0,
		total_employer_contr: 0,
		total_month_contr: 0,
		form: {
          contribution: '',
        },
		current_date: ''

      }
    },
};
</script>
