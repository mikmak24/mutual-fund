<template>
	<nav id="sidebar">
		<div class="p-4 pt-5">
			<img class="ml-4" src="../assets/images/logo/gogreen-white.png" />
			<hr />
			<hr />

			<h5 style="color: white; font-family:verdana;">ADMINISTRATION</h5>
			<br/>
			<ul class="nav flex-column">
				<li class="nav-item pd-10">
					<router-link to="/dashboard" class="nav-link active" href="#">
						<h7 style="color: white">
							<b-icon icon="box-arrow-right" variant="light"></b-icon> Dashboard
						</h7>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/uploadcontribution" class="nav-link active" href="#">
						<h7 style="color: white">
							<b-icon icon="file-earmark" variant="light"></b-icon> Upload Monthly
							Contribution
						</h7>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/employeelist" class="nav-link active" href="#">
						<h7 style="color: white">
							<b-icon icon="list" variant="light"></b-icon> List of Employees
						</h7>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/ss" class="nav-link active" href="#">
						<h7 style="color: white">
							<b-icon icon="file-bar-graph" variant="light"></b-icon> Reports
						</h7>
					</router-link>
				</li>
			</ul>
			<br />
			<h5 style="color: white; font-family:verdana;">Employees</h5>
						<br/>

			<ul class="nav flex-column">
				<li class="nav-item pd-10">
					<router-link to="/dashboard" class="nav-link active" href="#">
						<h7 style="color: white">
							<b-icon icon="box-arrow-right" variant="light"></b-icon> Dashboard
						</h7>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/uploadcontribution" class="nav-link active" href="#">
						<h7 style="color: white">
							<b-icon icon="file-earmark" variant="light"></b-icon> Upload Monthly
							Contribution
						</h7>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/employeelist" class="nav-link active" href="#">
						<h7 style="color: white">
							<b-icon icon="list" variant="light"></b-icon> List of Employees
						</h7>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/ss" class="nav-link active" href="#">
						<h7 style="color: white">
							<b-icon icon="file-bar-graph" variant="light"></b-icon> Reports
						</h7>
					</router-link>
				</li>
			</ul>

		</div>
	</nav>
</template>

<script>
export default {
	mounted() {}
};
</script>
<style scoped>
#font {
	font-family:sans-serif;
}</style>
