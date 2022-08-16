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
          </div>
          <b-form-datepicker id="example-datepicker" v-model="date" class="mb-2"></b-form-datepicker>

          <b-form-file v-model="file" ref="file-input" class="mb-2"></b-form-file>
          <b-button @click="clearFiles" class="mr-2">Upload File</b-button>
          <b-button @click="file = null">Clear File</b-button>
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
        file: null,
        date: ''
      }
    },
    methods: {
      clearFiles() {
        this.$refs['file-input'].reset()
      }
    }
}
</script>
