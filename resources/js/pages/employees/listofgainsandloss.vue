<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <!-- Page Content  -->
    <div id="content">
      <Navbar />
      <FlashMessage :position="'right top'" />
      <div class="p-4 p-md-5">
        <b-row>
          <b-col>
            <b-form-group
              label="Filter"
              label-for="filter-input"
              label-cols-sm="3"
              label-align-sm="right"
              label-size="sm"
              class="mb-0"
            >
              <b-input-group size="sm">
                <b-form-input
                  id="filter-input"
                  v-model="filter"
                  type="search"
                  placeholder="Type to Search"
                ></b-form-input>

                <b-input-group-append>
                  <b-button
                    :disabled="!filter"
                    @click="filter = ''"
                    variant="primary"
                    >Clear</b-button
                  >
                </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </b-col>

          <b-col>
            <b-form-group
              label="Filter On"
              label-cols-sm="3"
              label-align-sm="right"
              label-size="sm"
              class="mb-0"
              v-slot="{ ariaDescribedby }"
            >
              <b-form-checkbox-group
                v-model="filterOn"
                :aria-describedby="ariaDescribedby"
                class="mt-1"
              >
                <b-form-checkbox value="percentage"
                  >Percentage</b-form-checkbox
                >
                  <b-form-checkbox value="date_of_change"
                  >Date of Change</b-form-checkbox
                >
                
              </b-form-checkbox-group>
            </b-form-group>
          </b-col>
        </b-row>
        <br />

        <b-row>
          <b-col>
            <b-table
              striped
              hover
              :items="items"
              :fields="fields"
              :current-page="currentPage"
              :per-page="perPage"
              :filter="filter"
              :filter-included-fields="filterOn"
            >
             <template #cell(status)="row">
                <p v-if="row.item.status === 'increases'" style="color: green"><b-icon-arrow-up-square-fill></b-icon-arrow-up-square-fill></p>
                <p v-else style="color: red"><b-icon-arrow-down-square-fill></b-icon-arrow-down-square-fill></p>
              </template>
              <template #cell(percentage)="row">
                <p>{{row.item.percentage}}%</p>
              </template>
              <template #cell(percentage)="row">
                <p>{{row.item.percentage}}%</p>
              </template>
            </b-table>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group
              label="Per page"
              label-for="per-page-select"
              label-cols-sm="6"
              label-cols-md="4"
              label-cols-lg="3"
              label-align-sm="left"
              label-size="sm"
              class="mb-0"
            >
              <b-form-select
                id="per-page-select"
                v-model="perPage"
                :options="pageOptions"
                size="sm"
              ></b-form-select>
            </b-form-group>
          </b-col>
          <b-col>
            <b-pagination
              v-model="currentPage"
              :total-rows="totalRows"
              :per-page="perPage"
              align="fill"
              size="sm"
              class="my-0"
            ></b-pagination>
          </b-col>
        </b-row>
      </div>

     
    </div>
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
    mounted() {
       let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                    loader: 'spinner',
                    color: '#000'
        });

        this.username = this.$store.getters[
          "authentication/getUserCredential"
        ].username;

       this.$store.dispatch("monthlycontribution/fetchGainsandLoss", {
            'username': this.username
        })
       .then(response => {
          loader.hide()
          this.items = response;
          this.totalRows = response.length;
       })
    },
    data() {
      return {
        username: "",
        infoModal: false,
        perPage: 10,
        pageOptions: [5, 10, 15, { value: 100, text: "Show a lot" }],
        totalRows: 1,
        currentPage: 1,
        filter: null,
        filterOn: [],
        fields: [
          {
             key: 'id',
             label: 'Id',
             sortable: true
          },
          {
             key: 'amount_total',
             label: 'Amount of Share in the Company',
             sortable: true
          },
          {
             key: 'percentage',
             label: 'Percentage taken',
             sortable: true
          },
          {
             key: 'status',
             label: 'Trend',
             sortable: true
          },
          {
             key: 'date_of_change',
             label: 'Date of Change',
             sortable: true
          }
        ],
        
        items: [],
        form: {
          contribution: '',
        },
      }
    },
    methods: {
      info(item, index, button) {
        console.log(button)
        this.infoModal =true

      }, 
    }
}
</script>
