<template>
<!-- <nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand"><img src="../assets/images/logo/gogreen.png" /></a>
    <b-button variant="outline-dark">
        <b-icon icon="person-fill"></b-icon> Logout
    </b-button>
  </div>
</nav> -->

<div>
  <b-navbar type="light" variant="light">
    <b-navbar-toggle target="nav-text-collapse"></b-navbar-toggle>

    <b-navbar-brand><img src="../assets/images/logo/gogreen.png" /></b-navbar-brand>

    <b-collapse id="nav-text-collapse" is-nav>
      <b-navbar-nav>
        <b-nav-text>PH Retirement Portal</b-nav-text>
      </b-navbar-nav>
    </b-collapse>

    
         <b-button variant="outline-dark" right>
        <b-icon icon="person-fill"></b-icon> Logout
    </b-button>
   

  </b-navbar>
</div>


</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
