<template>
	<div class="wrapper d-flex align-items-stretch">
		<Sidebar />
		<!-- Page Content  -->
		<div id="content" class="p-4 p-md-5">
			<main role="main" style="margin-left: 1%">
				<Navbar />
				<div class="row">
					<FlashMessage :position="'right top'" />

					<h5 class="">
						<b-icon icon="file-earmark" variant="dark"></b-icon>
						Upload Monthly Contribution
					</h5>

					<!-- <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader> -->
				</div>
				<b-form-datepicker
					id="example-datepicker"
					required
					v-model="date"
					class="mb-2"
				></b-form-datepicker>

				<b-form-file v-model="file" ref="file-input" class="mb-2"></b-form-file>
				<b-button variant="outline-primary" @click="uploadFiles()" class="mr-2">Upload File</b-button>
				<b-button variant="outline-dark" @click="clearFiles">Clear File</b-button>
				<download-excel
					class="btn btn-success"
					:data="json_data"
					:fields="json_fields"
					worksheet="My Worksheet"
					name="MonthlyContribution.xls"
				>
					Download Format - List of Employees 
				</download-excel>
				<p class="mt-2">
					Selected file: <b>{{ file ? file.name : "" }}</b>
				</p>

				<canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
			</main>
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
		this.$store.dispatch("monthlycontribution/downloadEmployees").then(response => {
        	this.json_data = response
        })
    },
	data() {
		return {
			date: "",
			file: null,
			json_fields: {
				Eclipse_ID: "username",
				Employee_Contribution: "employee_monthly_contribution",
				Employer_Contribution: "employer_cont",
				Employee_Salary: "employer_cont"

			},

			json_data: [{}]
		};
	},
	methods: {
		clearFiles() {
			this.$refs["file-input"].reset();
		},
		uploadFiles() {
			 let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                    loader: 'spinner',
                    color: '#54e375'
                });
			let formData = new FormData();
			formData.append("file", this.file);
			formData.append("date", this.date);
			this.$store
				.dispatch("monthlycontribution/uploadContribution", formData)
				.then(response => {
					loader.hide()
					if (response.status == "ERROR") {
						this.flashMessage.setStrategy("single");
						this.flashMessage.error({
							title: "INVALID FILE",
							message: "Please Upload a FILE",
							icon: false
						});
					} else if (response.status == "SUCCESS") {
						 this.$store.dispatch("employees/fetchEmployeeRequest");
						 this.$store.dispatch("monthlycontribution/fetch");
						 this.$store.dispatch("employees/fetch");
						this.flashMessage.setStrategy("single");
						this.flashMessage.success({
							title: "IMPORT SUCCESS",
							icon: false,
							message: "DATA HAS BEEN IMPORTED SUCCESSFULLY..."
						});
						this.clearFiles();
					}
				})
				.catch(error => {});
		}
	}
};
</script>
