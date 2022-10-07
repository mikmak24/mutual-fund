<template>
<div>
<section class="vh-100" style="background-color: #80acc2;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="https://picsum.photos/500/800/?image=1031"
                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
                <form @submit="onSubmit" v-if="show">
                  <div class="d-flex align-items-center mb-3 pb-1">
                    <img src="../assets/images/logo/gogreen.png" />  
                  </div>
                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">PH Retirement Portal</h5>
                  <p style="color: red;">Please use your Eclipse Login</p>
                  <div class="form-outline mb-4">
                    <input type="text" v-model="form.username" id="form2Example17" class="form-control form-control-lg" />
                    <label class="form-label" for="form2Example17">Eclipse Username</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" v-model="form.password" class="form-control form-control-lg" />
                    <label class="form-label" for="form2Example27">Password</label>
                  </div>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                  </div>

                
                  <a href="#!" class="small text-muted">Terms of use.</a>
                  <a href="#!" class="small text-muted">Privacy policy</a>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</div>
    
</template>

<script>
export default {
    mounted() {
	  },
    data() {
      return {
        form: {
          username: '',
          password: '',
        },
        show: true
      }
    },
    methods:{
        onSubmit(event) {
            event.preventDefault()

             let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                    loader: 'spinner',
                    color: '#54e375'
                });

            this.$store.dispatch("authentication/signIn", this.form)
            .then(response => {
              if(response.status == 'ERROR'){
                  loader.hide()
                  this.flashMessage.setStrategy('single');
                  this.flashMessage.error({
                    title: 'INVALID CREDENTIALS',
                    message: 'Username or Password doesnt match any account in Eclipse',
                    icon: false,
                  });

              } else if (response.status == 'SUCCESS'){
                  loader.hide()
                  if(response.isAdmin == 1){
                    this.$router.replace("/dashboard");
                  } else {
                    this.$store.dispatch("monthlycontribution/fetchEmpDashboardCardDetails");
                    this.$router.replace("/empdashboard");
                  }
                
              } 
           
            })
            .catch((error) => {
            
            });
           
        }
    }
}
</script>