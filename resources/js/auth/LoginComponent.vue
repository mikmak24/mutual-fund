<template>
<div>
    <FlashMessage :position="'right top'"/>
    <b-card no-body class="overflow-hidden" align-v="center" style="max-width: 50%; margin-left: 25%; margin-top: 10%;">
    <b-row no-gutters>
      <b-col md="6">
        <b-card-img src="https://picsum.photos/400/400/?image=309" alt="Image" class="rounded-0"></b-card-img>
      </b-col>
      <b-col md="6">
        <br><br><br><br>
        <b-card-body>
          <b-card-text>

            <div class="text-center"><img src="../assets/images/logo/gogreen.png" /></div>
            <p class="text-center"><b>PH Retirement Portal</b></p>
            <p class="text-center">Please use your Eclipse Login</p>

                <b-form @submit="onSubmit" v-if="show">     
                    <b-form-group         
                        id="input-group-1"
                        label="Username:"
                        label-for="input-1"
                        description="We'll never share your data with anyone else."
                    >
                        <b-form-input
                        id="input-1"
                        v-model="form.username"
                        type="text"
                        placeholder="Enter Username"
                        required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group class="mb-2" id="input-group-2" label="Password:" label-for="input-2">
                        <b-form-input
                        id="input-2"
                        type="password"
                        v-model="form.password"
                        placeholder="Enter Password"
                        required
                        ></b-form-input>
                    </b-form-group>

                    <b-button type="submit" variant="info">Submit</b-button>
                    <b-button type="reset" variant="danger">Reset</b-button>
                </b-form>
            </b-card-text>
        </b-card-body>
      </b-col>
    </b-row>
  </b-card>
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
                    this.$store.dispatch("employees/fetchEmployeeRequest");
                    this.$store.dispatch("monthlycontribution/fetch");
                    this.$store.dispatch("employees/fetch");
                    this.$router.replace("/dashboard");
                  } else {
                    this.$store.dispatch("monthlycontribution/fetchEmpDashboardCardDetails");
                    this.$store.dispatch("monthlycontribution/fetchEmployeeContribution")
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

<style>

</style>