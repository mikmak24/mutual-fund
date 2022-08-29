<template>
	<div class="wrapper d-flex align-items-stretch">
		<Sidebar />
		<!-- Page Content  -->
		<div id="content" class="p-4 p-md-5">
			<Navbar />
                    <h2 class="mb-4">Dashboard</h2>

			<div class="row">
				<div class="col-xl-3 col-md-6">
					<div class="card bg-primary text-white mb-4">
						<div class="card-body">Primary Card</div>
						<div
							class="card-footer d-flex align-items-center justify-content-between"
						>
							<a class="small text-white stretched-link" href="#">View Details</a>
							<div class="small text-white"><i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-warning text-white mb-4">
						<div class="card-body">Warning Card</div>
						<div
							class="card-footer d-flex align-items-center justify-content-between"
						>
							<a class="small text-white stretched-link" href="#">View Details</a>
							<div class="small text-white"><i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-success text-white mb-4">
						<div class="card-body">Success Card</div>
						<div
							class="card-footer d-flex align-items-center justify-content-between"
						>
							<a class="small text-white stretched-link" href="#">View Details</a>
							<div class="small text-white"><i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-danger text-white mb-4">
						<div class="card-body">Danger Card</div>
						<div
							class="card-footer d-flex align-items-center justify-content-between"
						>
							<a class="small text-white stretched-link" href="#">View Details</a>
							<div class="small text-white"><i class="fas fa-angle-right"></i></div>
						</div>
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

export default {
	name: "Dashboard",
	components: {
    Navbar,
    Sidebar,
    Footer
},
	mounted() {
   	this.$store.dispatch("masteraccount/fetch");
	}
};
</script>
