<template>
	<nav id="sidebar">
		<div >
			<div  style="background-color: white; width: 300px; height: 90px;">
			<img class="pl-5 pt-4" src="../assets/images/logo/gogreen.png" />

			</div>

			<hr />
			<hr />
			<div class="p-4">
			<h5 style="color: white; font-family:verdana;">ADMINISTRATION</h5>
			<br/>
			<ul class="nav flex-column">
				<li class="nav-item pd-10">
					<router-link to="/dashboard" class="nav-link active" href="#">
						<h6 style="color: white">
							<b-icon icon="box-arrow-right" variant="light"></b-icon> Dashboard
						</h6>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/uploadcontribution" class="nav-link active" href="#">
						<h6 style="color: white">
							<b-icon icon="file-earmark" variant="light"></b-icon> Upload Monthly
							Contribution
						</h6>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/employeelist" class="nav-link active" href="#">
						<h6 style="color: white">
							<b-icon icon="list" variant="light"></b-icon> List of Employees
						</h6>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/contributionlist" class="nav-link active" href="#">
						<h6 style="color: white">
							<b-icon icon="list" variant="light"></b-icon> List of All Contributions
						</h6>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/ss" class="nav-link active" href="#">
						<h6 style="color: white">
							<b-icon icon="file-bar-graph" variant="light"></b-icon> Reports
						</h6>
					</router-link>
				</li>
				
			</ul>
			<br />
			<h5 style="color: white; font-family:verdana;">Employees</h5>
						<br/>

			<ul class="nav flex-column">
				<li class="nav-item pd-10">
					<router-link to="/dashboard" class="nav-link active" href="#">
						<h6 style="color: white">
							<b-icon icon="box-arrow-right" variant="light"></b-icon> Dashboard
						</h6>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/uploadcontribution" class="nav-link active" href="#">
						<h6 style="color: white">
							<b-icon icon="file-earmark" variant="light"></b-icon> Upload Monthly
							Contribution
						</h6>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/employeelist" class="nav-link active" href="#">
						<h6 style="color: white">
							<b-icon icon="list" variant="light"></b-icon> List of Employees
						</h6>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/ss" class="nav-link active" href="#">
						<h6 style="color: white">
							<b-icon icon="file-bar-graph" variant="light"></b-icon> Reports
						</h6>
					</router-link>
				</li>
			</ul>

			</div>

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
