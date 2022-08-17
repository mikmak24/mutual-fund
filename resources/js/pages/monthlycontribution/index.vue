<template>
   <div>
    <Navbar/>

    <div class="container-fluid">
      <div class="row">
        <Sidebar/>
        <main role="main" style="margin-left: 1%;" >
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h5 class="">
                <b-icon icon="file-earmark" variant="dark"></b-icon>
                Upload Monthly Contribution
            </h5>

          <download-excel
  class="btn btn-primary"
  :data="json_data"
  :fields="json_fields"
  worksheet="My Worksheet"
  name="filename.xls"
>
                            Download Excel Format <a>here</a>
</download-excel>
          </div>
          <b-form-datepicker id="example-datepicker" required v-model="date" class="mb-2"></b-form-datepicker>

          <b-form-file v-model="file" ref="file-input" class="mb-2"></b-form-file>
          <b-button @click="uploadFiles()" class="mr-2">Upload File</b-button>
          <b-button @click="clearFiles">Clear File</b-button>
          <p class="mt-2">Selected file: <b>{{ file ? file.name : '' }}</b></p>
          
          
        
          <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

          
        </main>
      </div>
    </div>

    <Footer/>
    </div>
</template>

<script>
import Navbar from '../../components/Navbar'
import Sidebar from '../../components/Sidebar'
import Footer from '../../components/Footer'

export default {
    name: 'Dashboard',
    components: {
        Navbar,
        Sidebar,
        Footer
    },
    data() {
      return {
        date: '',
        file: null,
        json_fields: {
          "Eclipse ID": "name",
          "Employee Contribution": "employee_cont",
          "Employer Contribution": "employer_cont",
        
        },

        json_data: [
          {
          
          },
        ]
      }
    },
    methods: {
      clearFiles() {
        this.$refs['file-input'].reset()
      },
      uploadFiles(){
          let formData = new FormData();
          formData.append('file', this.file);
          formData.append('date', this.date);
         this.$store.dispatch("monthlycontribution/uploadContribution", formData)
            .then(response => {
              if(response.status == 'ERROR'){
                  this.flashMessage.setStrategy('single');
                  this.flashMessage.error({
                    title: 'INVALID CREDENTIALS',
                    message: 'Username or Password doesnt match any account in Eclipse',
                    icon: false,
                  });

              } else {
                this.flashMessage.setStrategy('single');
                this.flashMessage.success({
                  title: 'LOGIN SUCCESSFUL',
                  icon: false,
                  message: 'Welcome Back...'
                });
                this.$router.replace("/dashboard");

              }
            })
            .catch((error) => {
            
            });
      }
    }
}
</script>
