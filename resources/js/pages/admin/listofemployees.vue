<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <!-- Page Content  -->
    <div id="content">
      <Navbar />
      <div class="p-4 p-md-5">
        <FlashMessage :position="'right top'" />
          
    <div class="mt-3">
    <b-card-group deck class="mb-3">
       <b-card
          header="Employees Total Contributions"
          header-text-variant="white"
          header-tag="header"
          header-bg-variant="dark"
          style="max-width: 50rem;"
           align="center"
        >
          <h2>${{total_employees_contribution}}</h2>
        </b-card>

      <b-card
          header="Total Number of Employees"
          header-text-variant="white"
          header-tag="header"
          header-bg-variant="success"
          style="max-width: 50rem;"
           align="center"
        >
          <h2>{{$store.getters["authentication/getNumberOfEmp"]}}</h2>
        </b-card>
    </b-card-group>
  </div>
  <br>
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
                <p style="color: blue">${{row.item.total_employee_contr}}</p>
              </template>
              <template #cell(total_employer_contr)="row">
                <p style="color: blue">${{row.item.total_employer_contr}}</p>
              </template>
              <template #cell(total_contribution)="row">
                <p style="color: blue">${{row.item.total_contribution}}</p>
              </template>
              <template #cell(total_employee_gained)="row">
                <p style="color: green">{{calculatePercentageEarned(row.item.total_contribution)}}%</p>

              </template>
              <template #cell(total_employee_get)="row">
                <p style="color: red">${{calculateAmountEarned(row.item.total_contribution)}}</p>
              </template>

              <template #cell(percentage_employee_contr)="row">
                <p style="color: green">{{calculateEmployeeContributionPercentage(row.item.total_employee_contr)}}%</p>
              </template>

              <template #cell(percentage_employer_contr)="row">
                <p style="color: green">{{calculateEmployerContributionPercentage(row.item.total_employer_contr)}}%</p>
              </template>

              <template #cell(actions)="row">
                
                  <b-button size="sm" 
                  @click="showModifyModal(row.item, row.index, $event.target)"
                  variant="info"
                  >
                    <b-icon icon="person-fill"></b-icon>
                    Employee Details
                 </b-button>

                 <b-button size="sm" 
                  @click="showBreakdownModal(row.item, row.index, $event.target)"
                  variant="danger"
                  >
                  <b-icon-eye></b-icon-eye>
                    Breakdown of Contributions
                </b-button>

                <b-button size="sm" 
                  @click="showBreakdownOfGainsAndLoss(row.item, row.index, $event.target)"
                  variant="success"
                  >
                  <b-icon-eye></b-icon-eye>
                    Breakdown of Gains and Loss
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
              header="Total Amount of Employee Share in the Company" class="text-center">
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
          header-text-variant="dark"
          ref="my-modal-breakdown"
          id="modal-lg"
          size="lg"
        >
           <b-table striped hover :items="items2" :fields="fields2">
              <template #cell(employee_contribution)="row">
                <p style="color: red">${{row.item.employee_contribution}}</p>
              </template>
              <template #cell(employer_contribution)="row">
                <p style="color: red">${{row.item.employer_contribution}}</p>
              </template>
              <template #cell(employee_gained)="row">
                <p style="color: red">${{row.item.employee_gained}}</p>
              </template>


           </b-table>
            <template #modal-footer>
              <div class="w-100"></div>
            </template>

            <template #modal-header>
              <div class="w-100">
                <h4><b-icon-record-fill></b-icon-record-fill> Contribution Breakdown</h4>
              </div>
            </template>
        </b-modal>

          <b-modal
          header-text-variant="dark"
          ref="my-modal-breakdown-gains"
          id="modal-lg"
          size="lg"
        >
           <b-table striped hover :items="items3" :fields="fields3">
              <template #cell(status)="row">
                <p v-if="row.item.status === 'increases'" style="color: green"><b-icon-arrow-up-square-fill></b-icon-arrow-up-square-fill></p>
                <p v-else style="color: red"><b-icon-arrow-down-square-fill></b-icon-arrow-down-square-fill></p>
              </template>
              <template #cell(percentage)="row">
                <p>{{row.item.percentage}}%</p>
              </template>
           </b-table>
            <template #modal-footer>
              <div class="w-100"></div>
            </template>

            <template #modal-header>
              <div class="w-100">
                <h4><b-icon-record-fill></b-icon-record-fill>Gains and Loss Breakdown</h4>
              </div>
            </template>
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
        container: this.fullPage ? null : this.$refs.formContainer,
        canCancel: true,
        onCancel: this.onCancel,
        loader: 'spinner',
        color: '#000000'
      });

      this.$store.dispatch("employees/fetch")
      .then(response => {
          this.items = response;
          this.totalRows = response.length;
      })

      this.$store.dispatch("employees/fetchTotalEmployeeContribution")
      .then(response => {
          console.log(response)
          this.total_employees_contribution = response.employee_gained_sum
          this.total_employee_contribution  = response.employee_contribution_sum
          this.total_employer_contribution  = response.employer_contribution_sum
      })

      this.$store.dispatch("masteraccount/fetch")
      .then(response => {
          loader.hide()
          this.master_account_amount = response[0]['master_account_amount']
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
            label: 'Employee Contribution',
            sortable: true
          },
          {
            key: 'percentage_employee_contr',
            label: '% of Employee Contribution.',
            sortable: true
          },
          {
            key: 'total_employer_contr',
            label: 'Employer Contribution',
            sortable: true,
            // variant: 'danger'
          },
          {
            key: 'percentage_employer_contr',
            label: '% of Employer Contribution.',
            sortable: true
          },
          {
            key: 'total_contribution',
            label: 'Total Contribution',
            sortable: true,
            // variant: 'danger'
          },
          {
            key: 'total_employee_gained',
            label: '$ of shares owned by the Employee',
            sortable: true,
            // variant: 'danger'
          },
          {
            key: 'total_employee_get',
            label: 'Total Amount of Employee Shares',
            sortable: true,
            // variant: 'danger'
          },
          {
            key: 'actions',
            label: '',
            sortable: true,
            // variant: 'danger'
          },
          
        ],
        items: [],
        indvContribution: [],
        fields2: [
          {
             key: 'employee_contribution',
             label: 'Employee Contribution',
             sortable: true
          },
          {
             key: 'employer_contribution',
             label: 'Employer Contribution',
             sortable: true
          },
          {
             key: 'employee_gained',
             label: 'Employee Gained',
             sortable: true
          },
          {
             key: 'uploaded_by',
             label: 'Uploaded by',
             sortable: true
          },
          {
             key: 'date_of_contribution',
             label: 'Period',
             sortable: true
          }
        ],
        fields3: [
          {
             key: 'id',
             label: 'Id',
             sortable: true
          },
          {
             key: 'amount',
             label: 'Amount Gain/Loss',
             sortable: true
          },
          {
             key: 'amount_total',
             label: 'Amount Total from Contribution',
             sortable: true
          },
          {
             key: 'percentage',
             label: 'Percentage',
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
        items2: [],
        items3: [],
        master_account_amount: 0,
        total_employees_contribution: 0,
        total_employee_contribution: 0,
        total_employer_contribution: 0
      } 
    },
    methods: {
      info(item, index, button) {
        console.log(button)
      },
      
      calculatePercentageEarned(total){
          let val = (total / this.total_employees_contribution) * 100
          return val.toFixed(2)
      },

      calculateAmountEarned(total){
          let percentage = this.calculatePercentageEarned(total)
          return ((percentage / 100) * this.master_account_amount).toFixed(2)
      },

      calculateEmployeeContributionPercentage(total){
          let val = (total / this.total_employee_contribution) * 100
          return val.toFixed(2)
      },

      calculateEmployerContributionPercentage(total){
          let val = (total / this.total_employer_contribution) * 100
          return val.toFixed(2)
      },

      showModifyModal(item, index, button){
        this.form.total_employee_shares = this.calculateAmountEarned(item.total_contribution)
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
         this.items2 = []
         let loader = this.$loading.show({
          // Optional parameters
          container: this.fullPage ? null : this.$refs.formContainer,
          canCancel: true,
          onCancel: this.onCancel,
          loader: 'spinner',
          color: '#000000'
        });
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
          loader.hide()
           this.items2 = response
        })

        this.$refs['my-modal-breakdown'].show()
      },

      showBreakdownOfGainsAndLoss(item, index, button){
         this.items3 = []
         let loader = this.$loading.show({
          // Optional parameters
          container: this.fullPage ? null : this.$refs.formContainer,
          canCancel: true,
          onCancel: this.onCancel,
          loader: 'spinner',
          color: '#000000'
        });
        this.form.username = item.username
        
        this.$store.dispatch("monthlycontribution/fetchGainsandLoss", {
            'username': item.username
        })
        .then(response => {
          loader.hide()
           this.items3 = response
        })

        this.$refs['my-modal-breakdown-gains'].show()
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
