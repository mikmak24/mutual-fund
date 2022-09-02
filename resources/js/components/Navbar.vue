<template>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			 <b-button size="s" id="sidebarCollapse"  class="mb-2 mt-2">
      <b-icon icon="arrow-left-circle-fill" aria-label="Help"></b-icon>
    </b-button>
			<h4  class="ml-3"><b>PH Retirement Portal</b></h4>
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
					<li v-if="isAdmin == 1" class="nav-item">
						<router-link to="/masteraccount" class="nav-link active" href="#">
							<h6 style="color: dark">
								<b-icon icon="exclamation-triangle-fill" variant="warning"></b-icon>
								Master Account
							</h6>
						</router-link>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"><b-icon icon="gear-fill" aria-hidden="true"></b-icon> Settings</a>
					</li>
					<li class="nav-item">
						<b-button variant="dark" @click="logout()"  right>
							<b-icon  icon="person-fill"></b-icon> Logout: {{ username }}
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
			token: "",
			isAdmin: "",
			fullPage: false

		};
	},
	mounted() {
		this.username = this.$store.getters[
			"authentication/getUserCredential"
		].username;
		this.token = this.$store.getters["authentication/getUserCredential"].token;

		this.isAdmin = this.$store.getters[
			"authentication/isAdmin"
		];
	},
	methods: {
		logout() {

			let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
        	});

			if(this.isAdmin == 0){
				this.$store.dispatch("monthlycontribution/removeState")
			}

			this.$store
				.dispatch("authentication/logout")
				.then(response => {
					loader.hide()
                    this.$router.replace("/");
				})
				.catch(error => {});
		}
	}
};
</script>
