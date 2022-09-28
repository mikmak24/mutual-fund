<template>
  <div>
    <nav
      class="navbar navbar-expand-lg navbar-dark"
      style="background-color: black"
    >
      <div class="container-fluid">
        <b-button size="s" id="sidebarCollapse" class="mb-2 mt-2">
          <b-icon icon="arrow-left-circle" aria-label="Help"></b-icon>
        </b-button>
        <h4 class="ml-3" style="color: white; padding-top: 12px">
          <b>PH Retirement Portal</b>
        </h4>
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
              <b-button
                @click="showNotificationModal()"
                variant="danger"
                style="margin-right: 5px"
              >
                <b-icon-bell-fill></b-icon-bell-fill>
                Notifications ({{$store.getters["authentication/getNumberOfNotf"]
                }})
              </b-button>
            </li>

            <li class="nav-item">
              <b-button variant="light" @click="logout()" right>
                <b-icon icon="person-fill"></b-icon> Logout: {{ username }}
              </b-button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <b-modal ref="my-modal-notification" id="modal-lg">
      <div
        v-for="(list, index) in notfList"
        :key="list.id"
        style="padding-bottom: 8px"
      >
        <b-card
          v-if="list.is_read === 0"
          bg-variant="primary"
          text-variant="white"
        >
          <p>
            <b-icon
              style="margin-right: 10px"
              icon="bell-fill"
              class="rounded-circle bg-danger p-2"
              variant="light"
            ></b-icon>
            {{list.message}}
          </p>
          <p>- {{ moment(list.created_at).format('LLLL')}}</p>
          <b-button size="sm" @click="markAsRead(list)" variant="success">Mark as Read</b-button>
        </b-card>

        <b-card v-else bg-variant="primary" text-variant="white">
          <p>
            <b-icon
              style="margin-right: 10px"
              icon="bell-fill"
              class="rounded-circle bg-secondary p-2"
              variant="light"
            ></b-icon>
            {{list.message}}
          </p>
          <p>- {{ moment(list.created_at).format('LLLL')}}</p>
        </b-card>
      </div>

      <template #modal-footer>
        <div class="w-100"></div>
      </template>

      <template #modal-header>
        <div class="w-100">
          <h4><b-icon-bell-fill></b-icon-bell-fill> NOTIFICATIONS</h4>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
export default {
	data() {
		return {
			username: "",
			token: "",
			isAdmin: "",
			fullPage: false,
			notifications: 0,
			notfList: []
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

		this.$store.dispatch("employees/fetchNotifications").then(response => {
			this.notfList = response

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
		},

		showNotificationModal(){
			this.$refs['my-modal-notification'].show()
		},


		markAsRead(list){
			console.log(list.id)
			this.$store.dispatch("employees/markAsReadNotf", {
            'id': list.id,
			})
			.then(response => {
				this.fetchNotifications()
			})

		},

		fetchNotifications(){
			this.$store.dispatch("employees/fetchNotifications").then(response => {
				this.notfList = response
			});
		}

		
	}
};
</script>
