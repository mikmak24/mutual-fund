<template>
	<div class="wrapper d-flex align-items-stretch">
		<Sidebar />
		<!-- Page Content  -->
		<div id="content" class="p-4 p-md-5">
			<Navbar />
            <h2 class="mb-4">Employee Dashboard</h2>

			    <b-card-group deck>
					<b-card
						border-variant="primary"
						header="Number of Month Contributed"
						header-bg-variant="primary"
						header-text-variant="white"
						align="center"
					>
						<b-card-text><h6 style="color: blue;">{{total_month_contr}}</h6></b-card-text>
					</b-card>

					<b-card
						border-variant="success"
						header="Total Amount Contributed"
						header-bg-variant="success"
						header-text-variant="white"
						align="center"
					>
						<b-card-text><h6 style="color: green;">${{total_employee_contr}}</h6></b-card-text>
					</b-card>

					<b-card
						border-variant="info"
						header="Total Contribution By Employer"
						header-bg-variant="info"
						header-text-variant="white"
						align="center"
					>
						<b-card-text><h6 style="color: skyblue;">${{total_employer_contr}}</h6></b-card-text>
					</b-card>

					<b-card
						border-variant="danger"
						header="Personal Contribution Amount"
						header-bg-variant="danger"
						header-text-variant="white"
						align="center"
					>
						<b-card-text><h6 style="color: red;">{{monthly_contribution}}% - per month</h6></b-card-text>
					</b-card>
				</b-card-group>
				<br>

	

			  <b-card-group deck>
				<b-card
				header="featured"
				header-tag="header"
				footer="Card Footer"
				footer-tag="footer"
				title="Title"
				>
				<b-card-text>Header and footers using props.</b-card-text>
				<b-button href="#" variant="primary">Go somewhere</b-button>
				</b-card>

				<b-card title="Title" header-tag="header" footer-tag="footer">
				<template #header>
					<h6 class="mb-0">Header Slot</h6>
				</template>
				<b-card-text>Header and footers using slots.</b-card-text>
				<b-button href="#" variant="primary">Go somewhere</b-button>
				<template #footer>
					<em>Footer Slot</em>
				</template>
				</b-card>
			</b-card-group>

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
	mounted() {
		this.$store.dispatch("monthlycontribution/fetchEmpDashboardCardDetails")
        .then(res => {
            console.log("-----------------")
			this.monthly_contribution = res[0].employee_monthly_contribution
			this.total_employee_contr = res[0].total_employee_contr ?? 0
			this.total_employer_contr = res[0].total_employer_contr ?? 0
			this.total_month_contr = res[0].total_month_contr
        })
      .catch(err => console.log(err));
	},
	 data() {
      return {
		monthly_contribution: 0,
		total_employee_contr: 0,
		total_employer_contr: 0,
		total_month_contr: 0,
		form: {
          contribution: '',
        },
      }
    },
};
</script>
