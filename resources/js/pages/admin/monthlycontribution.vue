<template>
  <div>
    <Navbar />

    <div class="container-fluid">
      <div class="row">
        <Sidebar />
        <main role="main" style="margin-left: 1%">
          <FlashMessage :position="'right top'"/>

          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h5 class="">
              <b-icon icon="file-earmark" variant="dark"></b-icon>
              Upload Monthly Contribution
            </h5>

            <!-- <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader> -->


            <download-excel
              class="btn btn-primary"
              :data="json_data"
              :fields="json_fields"
              worksheet="My Worksheet"
              name="MonthlyContribution.xls"
            >
              Download Excel Format <a>here</a>
            </download-excel>
          </div>
          <b-form-datepicker
            id="example-datepicker"
            required
            v-model="date"
            class="mb-2"
          ></b-form-datepicker>

          <b-form-file
            v-model="file"
            ref="file-input"
            class="mb-2"
          ></b-form-file>
          <b-button @click="uploadFiles()" class="mr-2">Upload File</b-button>
          <b-button @click="clearFiles">Clear File</b-button>
          <p class="mt-2">
            Selected file: <b>{{ file ? file.name : '' }}</b>
          </p>

          <canvas
            class="my-4 w-100"
            id="myChart"
            width="900"
            height="380"
          ></canvas>
        </main>
      </div>
    </div>

    <Footer />
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
          "Eclipse_ID": "name",
          "Employee_Contribution": "employee_cont",
          "Employer_Contribution": "employer_cont",

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
              console.log("------------------------")
              console.log(response.status)
              if(response.status == 'ERROR'){
                  this.flashMessage.setStrategy('single');
                  this.flashMessage.error({
                    title: 'INVALID FILE',
                    message: 'Please Upload a FILE',
                    icon: false,
                  });

              } else if(response.status == 'SUCCESS'){
                this.flashMessage.setStrategy('single');
                this.flashMessage.success({
                  title: 'IMPORT SUCCESS',
                  icon: false,
                  message: 'DATA HAS BEEN IMPORTED SUCCESSFULLY...'
                });
                this.clearFiles()
              }
            })
            .catch((error) => {

            });
      }
    }
}
</script>
