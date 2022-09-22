<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <!-- Page Content  -->
    <div id="content">
      <Navbar />

      <div class="p-4 p-md-5">
        <h2 class="mb-4">List of Employees</h2>

        <FlashMessage :position="'right top'" />

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
                <b-form-checkbox value="username"
                  >Eclipse Username</b-form-checkbox
                >
                <b-form-checkbox value="total_employee_contr"
                  >Employee Contribution</b-form-checkbox
                >
                <b-form-checkbox value="total_employer_contr"
                  >Employer Contribution</b-form-checkbox
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
                <p style="color: red">${{row.item.total_employee_contr}}</p>
              </template>
              <template #cell(total_employer_contr)="row">
                <p style="color: red">${{row.item.total_employer_contr}}</p>
              </template>
              <template #cell(total_employee_shares)="row">
                <p style="color: red">${{row.item.total_employee_shares}}</p>
              </template>
              <template #cell(actions)="row">
                 <b-button size="sm" 
                  @click="showBreakdownModal(row.item, row.index, $event.target)"
                  variant="info"
                  >
                  <b-icon-eye></b-icon-eye>
                    Breakdown of Contribution
                </b-button>

                <b-button size="sm" 
                  @click="showModifyModal(row.item, row.index, $event.target)"
                  variant="warning"
                  >
                  <b-icon-eye></b-icon-eye>
                   Show Employee Details
                </b-button>
              </template>

              <template #row-details="row">
                <b-card
                  border-variant="warning"
                  header="Employee Investment Value"
                  header-bg-variant="transparent"
                >
                  <b-card-text>{{row.item}}</b-card-text>
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
      </div>

      <b-modal
         header-bg-variant="info"
          header-text-variant="dark"
          ref="my-modal"
          id="modal-lg"
          size="lg"
      >
        <b-card-group deck>
          
            <b-card
              style="color: black; font-size: 20px;"
               border-variant="info"
               header-bg-variant="info"
              header-text-variant="white"
               align="center"
               header="Eclipse Username" class="text-center">
              <h3>{{form.username}}</h3>
            </b-card>

        </b-card-group>
        <br>
        <b-card-group deck>
          
            <b-card
              style="font-size: 20px;"
              border-variant="info"
              header-bg-variant="info"
              header-text-variant="white"
              align="center"
              header="Total Employee Share in the Company" class="text-center">
              <h3>${{form.total_employee_shares}}</h3>
            </b-card>

        </b-card-group>
         
         <br>
         <b-card-group deck>

            <b-card 
              style="color: black;"
              border-variant="info"
              header-bg-variant="transparent"
              align="center"
              header="Employee Total Individual Contribution" class="text-center">
              <h3>${{form.employee_contribution}}</h3>
            </b-card>

            <b-card 
              style="color: black;"
              border-variant="info"
              header-bg-variant="transparent"
              align="center"
              header="Employer Total Contribution" class="text-center">
              <h3>${{form.employer_contribution}}</h3>
            </b-card>

        </b-card-group>
        <hr>
        <b-card-group deck>
          
            <b-card
              v-if="form.status === 1"
              style="font-size: 20px;"
              bg-variant="success"
              header-bg-variant="success"
              header-text-variant="white"
              align="center"
              class="text-center">
              <h5 style="color:white;"><b>ACTIVE</b><br>since ~ {{form.created_at}}
              </h5>
              <b-button @click="updateEmployeeStatus(0, form.username)" variant="outline-light">ACTIVE -> INACTIVE</b-button>

            </b-card>

             <b-card
              v-if="form.status === 0"
              style="font-size: 20px;"
              bg-variant="danger"
              header-bg-variant="danger"
              header-text-variant="white"
              align="center"
              class="text-center">
              <h5 style="color:white;"><b>INACTIVE</b><br>since ~ {{form.updated_at}}
              </h5>
              <b-button @click="updateEmployeeStatus(1, form.username)" variant="outline-light">INACTIVE -> ACTIVE</b-button>
            </b-card>

        </b-card-group>

      </b-modal>
      
        <b-modal
         header-bg-variant="info"
          header-text-variant="dark"
          ref="my-modal-breakdown"
          id="modal-lg"
          size="lg"
        >
        <h2>Breakdown of Contribution for {{form.username}}</h2>
        <b-list-group>
          <b-list-group-item variant="secondary" button>{{indvContribution}}</b-list-group-item>
        </b-list-group>
        
        </b-modal>


    </div>
  </div>
</template>

<script>
import Navbar from '../../components/Navbar'
import Sidebar from '../../components/Sidebar'
import Footer from '../../components/Footer'
import moment from 'moment'

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
        color: '#000000'
      });

      this.$store.dispatch("employees/fetch")
      .then(response => {
          loader.hide()
          this.items = response;
          this.totalRows = response.length;

      })
      
    },
    data() {
      return {
        form: {
          id: 0,
          total_employee_shares: '',
          date_of_contribution: '',
          employee_contribution: 0,
          employer_contribution: 0,
          username: '',
          uploaded_by: '',
          status: '',
          created_at: '',
          updated_at: ''
        },
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
            key: 'total_employee_contr',
            label: 'Total Employee Contribution',
            sortable: true
          },
          {
            key: 'total_employer_contr',
            label: 'Total Employer Contribution',
            sortable: true,
            // variant: 'danger'
          },
          {
            key: 'total_employee_shares',
            label: 'Total Employee Shares',
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
        items: [],
        indvContribution: []

      }
    },
    methods: {
      info(item, index, button) {
        console.log(button)
      },

      showModifyModal(item, index, button){
        this.form.total_employee_shares = item.total_employee_shares
        this.form.username = item.username
        this.form.employee_contribution = item.total_employee_contr
        this.form.employer_contribution = item.total_employer_contr
        this.form.status = item.is_active
        this.form.created_at = moment(String(item.created_at)).format('LLLL')
        this.form.updated_at = moment(String(item.updated_at)).format('LLLL')
        // this.form.id = item.id
        this.$refs['my-modal'].show()
      },

      showBreakdownModal(item, index, button){
        this.form.total_employee_shares = item.total_employee_shares
        this.form.username = item.username
        this.form.employee_contribution = item.total_employee_contr
        this.form.employer_contribution = item.total_employer_contr
        this.form.status = item.is_active
        this.form.created_at = moment(String(item.created_at)).format('LLLL')
        this.form.updated_at = moment(String(item.updated_at)).format('LLLL')
        
        this.$store.dispatch("monthlycontribution/fetchIndvContribution", {
            'username': item.username
        })
        .then(response => {
           this.indvContribution = response
        })

        this.$refs['my-modal-breakdown'].show()
      },


      updateEmployeeStatus(is_active, username){
        this.$refs['my-modal'].hide()
        let loader = this.$loading.show({
            // Optional parameters
            container: this.fullPage ? null : this.$refs.formContainer,
            canCancel: true,
            onCancel: this.onCancel,
            loader: 'spinner',
            color: '#000000'
        });

        this.$store.dispatch("employees/updateEmployeeStatus", {
          'is_active': is_active,
          'username': username
          
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
                    title: 'Change Active Status',
                    message: 'Employess active status has been changed successfully-- Reloading screen',
                    icon: false,
                  });
                  this.fetchEmployee()
              } 
            })
            .catch((error) => {
            
            });
      },

      fetchEmployee(){
        this.$store.dispatch("employees/fetch")
          .then(response => {
            this.items = response;
            this.totalRows = response.length;
        })
      }
    }
}
</script>
