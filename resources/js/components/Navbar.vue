<template>
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: black;">
		<div class="container-fluid">
			 <b-button size="s" id="sidebarCollapse"  class="mb-2 mt-2">
      <b-icon icon="arrow-left-circle"  aria-label="Help"></b-icon>
    </b-button>
			<h4  class="ml-3" style="color: white; padding-top: 12px"><b>PH Retirement Portal</b></h4>
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
					<li v-if="isAdmin == 1" class="nav-item">
						<router-link to="/masteraccount" class="nav-link active" href="#">
							<h6 style="color: dark">
								<b-icon icon="cash-coin" variant="warning"></b-icon>
								Master Account
							</h6>
						</router-link>
					</li>
					<li v-if="isAdmin == 1" class="nav-item">
						<router-link to="/requestlist" class="nav-link active" href="#">
							<h6 style="color: dark">
								<b-icon icon="bell-fill" variant="danger"></b-icon> 
								Employee Request ({{notifications}})
							</h6>
						</router-link>
					</li>

					<li v-if="isAdmin != 1" class="nav-item">
						<router-link to="/requestlist" class="nav-link active" href="#">
							<h6 style="color: dark">
								<b-icon icon="bell-fill" variant="danger"></b-icon> 
								Notifications (2)
							</h6>
						</router-link>
					</li>
					
					<li class="nav-item">
						<b-button variant="light" @click="logout()"  right>
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
			fullPage: false,
			notifications: 0
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

		this.$store.dispatch("monthlycontribution/countContributionRequest").then(response => {
			this.notifications = response.count
		});
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
