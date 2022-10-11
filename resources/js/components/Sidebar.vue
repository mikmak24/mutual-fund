<template>
  <nav id="sidebar">
    <div>
      <div style="background-color: white; width: 300px; height: 90px">
        <img class="pl-5 pt-4" src="../assets/images/logo/gogreen.png" />
      </div>

      <hr style="c" />
      <hr />
      <div class="p-4">
        <div v-if="isAdmin == 1">
          <h5 style="color: #000000; font-family: verdana">ADMINISTRATION</h5>
          <br />
          <ul class="nav flex-column">
            <li class="nav-item pd-10">
              <router-link to="/dashboard" class="nav-link active" href="#">
                <h6 style="color: #000000">
                  <b-icon icon="box-arrow-right" variant="dark"></b-icon>
                  Dashboard
                </h6>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link
                to="/uploadcontribution"
                class="nav-link active"
                href="#"
              >
                <h6 style="color: #000000">
                  <b-icon icon="file-earmark" variant="dark"></b-icon> Upload
                  Monthly Contribution
                </h6>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/employeelist" class="nav-link active" href="#">
                <h6 style="color: #000000">
                  <b-icon icon="list" variant="dark"></b-icon> Employee List
                </h6>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link
                to="/contributionlist"
                class="nav-link active"
                href="#"
              >
                <h6 style="color: #000000">
                  <b-icon icon="list" variant="dark"></b-icon> Contribution List
                </h6>
              </router-link>
            </li>

            <!-- <li class="nav-item">
						<router-link to="#" class="nav-link active" href="#">
							<h6 style="color: white">
								<b-icon icon="file-bar-graph" variant="light"></b-icon> Reports
							</h6>
						</router-link>
					</li> -->
          </ul>
        </div>

        <div v-if="isAdmin == 0 || isAdmin == null">
          <h5 style="color: #000000; font-family: verdana">Employees</h5>
          <br />

          <ul class="nav flex-column">
            <li class="nav-item pd-10">
              <router-link to="/empdashboard" class="nav-link active" href="#">
                <h6 style="color: #000000">
                  <b-icon icon="box-arrow-right" variant="dark"></b-icon>
                  Dashboard
                </h6>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link
                to="/empcontributionlist"
                class="nav-link active"
                href="#"
              >
                <h6 style="color: #000000">
                  <b-icon icon="person-fill" variant="dark"></b-icon> Personal
                  Contribution
                </h6>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/gainsandloss" class="nav-link active" href="#">
                <h6 style="color: #000000">
                  <b-icon icon="file-bar-graph" variant="dark"></b-icon> Gains
                  and Loss Breakdown
                </h6>
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
	data() {
		return {
			isAdmin: ""
		};
	},
	mounted() {
		this.isAdmin = this.$store.getters[
			"authentication/isAdmin"
		];
	}
};
</script>
<style scoped>
#font {
  font-family: sans-serif;
}
</style>
