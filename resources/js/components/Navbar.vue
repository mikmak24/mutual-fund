<template>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<img id="sidebarCollapse" src="../assets/images/logo/gogreen.png" />
			<button
				class="btn btn-dark d-inline-block d-lg-none ml-auto"
				type="button"
				data-toggle="collapse"
				data-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent"
				aria-expanded="false"
				aria-label="Toggle navigation"
			>
				<i class="fa fa-bars"></i>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="nav navbar-nav ml-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">HOME</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">ABOUT</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">SETTINGS</a>
					</li>
					<li class="nav-item">
						<b-button @click="logout()" variant="dark" right>
							<b-icon icon="person-fill"></b-icon> Logout: {{ username }}
						</b-button>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</template>

<script>
export default {
	data() {
		return {
			username: "",
			token: ""
		};
	},
	mounted() {
		this.username = this.$store.getters[
			"authentication/getUserCredential"
		].username;
		this.token = this.$store.getters["authentication/getUserCredential"].token;
	},
	methods: {
		logout() {
			this.$store
				.dispatch("authentication/logout")
				.then(response => {})
				.catch(error => {});
		}
	}
};
</script>
