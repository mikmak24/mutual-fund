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

    <b-navbar-brand style="margin-left: 2%;"><img src="../assets/images/logo/gogreen.png" /><br> 
    <b-nav-text >PH Retirement Portal</b-nav-text>
    </b-navbar-brand>

    <b-collapse id="nav-text-collapse" is-nav>
      <b-navbar-nav>
        <!-- <b-nav-text >PH Retirement Portal - Logged in as: {{username}}</b-nav-text> -->
      </b-navbar-nav>
    </b-collapse>

    
    <b-button @click="logout()" variant="outline-dark" right>
    <b-icon icon="person-fill"></b-icon> Logout: {{username}}
    </b-button>
   
  </b-navbar>
</div>


</template>

<script>
  export default {
    data() {
      return {
        username: '',
        token: ''
      }
    },
    mounted() {
      this.username = this.$store.getters['authentication/getUserCredential'].username
      this.token = this.$store.getters['authentication/getUserCredential'].token

    },
    methods: {
      logout(){
          this.$store.dispatch("authentication/logout", {'token': this.token})
            .then((response) => {

            })
            .catch((error) => {
            
          });
      }
    }
  }
</script>
