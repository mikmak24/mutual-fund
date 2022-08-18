<template>
  <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Administration</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column">
              <li class="nav-item">
                <router-link to="/dashboard" class="nav-link active" href="#">
                <b-icon icon="box-arrow-right" variant="dark"></b-icon>
                  <span style="color: black">Dashboard</span>
                </router-link>              
              </li>
              <li class="nav-item">
                <router-link to="/uploadcontribution" class="nav-link active" href="#">
                 <b-icon icon="file-earmark" variant="dark"></b-icon>
                  <span style="color: black">Upload Monthly Contribution</span>
                </router-link>
              </li>
               <li class="nav-item">
                <router-link to="/employeelist" class="nav-link active" href="#">
                 <b-icon icon="list" variant="dark"></b-icon>
                  <span style="color: black">List of Employees</span>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/ss" class="nav-link active" href="#">
                 <b-icon icon="file-bar-graph" variant="dark"></b-icon>
                  <span style="color: black">Reports</span>
                </router-link>
              </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Employees</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column">
              <li class="nav-item">
                <router-link to="/dashboard" class="nav-link active" href="#">
                <b-icon icon="box-arrow-right" variant="dark"></b-icon>
                  <span style="color: black">Dashboard</span>
                </router-link>              
              </li>
              <li class="nav-item">
                <router-link to="/ss" class="nav-link active" href="#">
                 <b-icon icon="file-earmark" variant="dark"></b-icon>
                  <span style="color: black">Upload Monthly Contribution</span>
                </router-link>
              </li>
               <li class="nav-item">
                <router-link to="/ss" class="nav-link active" href="#">
                 <b-icon icon="list" variant="dark"></b-icon>
                  <span style="color: black">List of Employees</span>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/ss" class="nav-link active" href="#">
                 <b-icon icon="file-bar-graph" variant="dark"></b-icon>
                  <span style="color: black">Reports</span>
                </router-link>
              </li>
            </ul>
          </div>
        </nav>
</template>

<script>
    export default {
        mounted() {
        }
    }
</script>
