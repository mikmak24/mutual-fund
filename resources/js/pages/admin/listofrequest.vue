<template>
	<div class="wrapper d-flex align-items-stretch">
		<Sidebar />
		<!-- Page Content  -->
		<div id="content" class="p-4 p-md-5">
				<Navbar />

        <main
          role="main"
          style="margin-left: 1%"
         
        >
          <FlashMessage :position="'right top'" />
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h5 class="">
              <b-icon icon="file-earmark" variant="dark"></b-icon>
              List of Employee Contribution Request
            </h5>
          </div>

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
                    <b-button :disabled="!filter" @click="filter = ''"
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
                  <b-form-checkbox value="username"
                    >Eclipse Username</b-form-checkbox
                  >
                  <b-form-checkbox value="requested_amount"
                    >Requested Amount</b-form-checkbox
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
                <template #cell(total_employee_contr)="row">
                  <p style="color: red;">${{row.item.total_employee_contr}}</p>
                </template>
                <template #cell(total_employer_contr)="row">
                  <p style="color: red;">${{row.item.total_employer_contr}}</p>
                </template>
                <template #cell(total_employee_shares)="row">
                  <p style="color: red;">${{row.item.total_employee_shares}}</p>
                </template>
                <template #cell(actions)="row">
                  <b-button
                    variant="success"
                    size="sm"
                    @click="acceptChange(row.item, row.index, $event.target)"
                    class="mr-1"
                  >
                    Accept
                  </b-button>
                  <b-button size="sm" 
                    @click="declineChange(row.item, row.index, $event.target)"
                  variant="danger"
                  >
                   Decline
                  </b-button>
                </template>

                <template #row-details="row">
                  <b-card>
                    <ul>
                      <li v-for="(value, key) in row.item" :key="key">
                        {{ key }}: {{ value }}
                      </li>
                    </ul>
                  </b-card>
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
        </main>
		
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
      this.items = this.$store.getters["employees/getArrayEmployeeRequest"];
      this.totalRows = this.$store.getters["employees/getArrayEmployeeRequest"].length;
    },
    data() {
      return {

        perPage: 10,
        pageOptions: [5, 10, 15, { value: 100, text: "Show a lot" }],
        totalRows: 1,
        currentPage: 1,
        filter: null,
        filterOn: [],
         fields: [
          {
            key: 'username',
            label: 'Eclipse Username',
            sortable: true
          },
          {
            key: 'requested_amount',
            label: 'Requested Amount to Change',
            sortable: true
          },
          {
            key: 'status',
            label: 'Status',
            sortable: true,
            // variant: 'danger'
          },
          {
            key: 'date_of_request',
            label: 'Date of Request',
            sortable: true,
            // variant: 'danger'
          },
          {
            key: 'approved_by',
            label: 'Approved By',
            sortable: true,
            // variant: 'danger'
          },
          {
            key: 'actions',
            label: 'Action',
            sortable: true,
            // variant: 'danger'
          }
        ],
        items: []

      }
    },
    methods: {

      
      acceptChange(item, index, button) {

          let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                    loader: 'spinner',
                    color: '#54e375'
                });

        this.$store.dispatch("employees/acceptEmpContribution", {
          'id':item.id,
          'username':item.username,
          'value':item.requested_amount
        })
            .then(response => {
              loader.hide()

              if(response.status == 'ERROR'){
                  this.flashMessage.setStrategy('single');
                  this.flashMessage.error({
                    title: 'INVALID',
                    message: 'There was an error requesting to update your contribution. Please contact your administration.',
                    icon: false,
                  });

              } else if (response.status == 'SUCCESS'){
                 this.flashMessage.setStrategy('single');
                  this.flashMessage.success({
                    title: 'Change Contribution Accepted',
                    message: 'The request has been accepted -- Reloading screen',
                    icon: false,
                  });

                  this.$store.dispatch("employees/fetchEmployeeRequest").then(response => {
                    this.items =response
                    this.totalRows = response.length;


                  })

              } 
             
            })
            .catch((error) => {
            
            });
      },

      declineChange(item, index, button) {

          let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                    loader: 'spinner',
                    color: '#54e375'
                });

        this.$store.dispatch("employees/declineEmpContribution", {
          'id':item.id,
          'username':item.username,
          'value':item.requested_amount
        })
            .then(response => {
              loader.hide()

              if(response.status == 'ERROR'){
                  this.flashMessage.setStrategy('single');
                  this.flashMessage.error({
                    title: 'INVALID',
                    message: 'There was an error requesting to update your contribution. Please contact your administration.',
                    icon: false,
                  });

              } else if (response.status == 'SUCCESS'){
                 this.flashMessage.setStrategy('single');
                  this.flashMessage.success({
                    title: 'Change Contribution Accepted',
                    message: 'The request has been Declined -- Reloading screen',
                    icon: false,
                  });

                   this.$store.dispatch("employees/fetchEmployeeRequest").then(response => {
                    this.items =response
                    this.totalRows = response.length;


                  })
              } 
             
            })
            .catch((error) => {
            
            });
      },
    }
}
</script>
