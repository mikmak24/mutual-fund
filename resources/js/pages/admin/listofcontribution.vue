<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <!-- Page Content  -->
    <div id="content">
      <Navbar />
      <div class="p-4 p-md-5">
        <FlashMessage :position="'right top'" />
        <div
          class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
        >
          <h3 class="">
            <b-icon icon="file-earmark" variant="dark"></b-icon>
            List of Contributions
          </h3>
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
              <template #cell(employee_contribution)="row">
                <p style="color: blue">${{row.item.employee_contribution}}</p>
              </template>
              <template #cell(employer_contribution)="row">
                <p style="color: blue">${{row.item.employer_contribution}}</p>
              </template>
              <template #cell(employee_gained)="row">
                <p style="color: red">${{row.item.employee_gained}}</p>
              </template>
              <template #cell(percentage_employee_contr)="row">
                <p style="color: green">{{calculatePercentageEarned(row.item.employee_contribution)}}%</p>
              </template>

              <template #cell(percentage_employer_contr)="row">
                <p style="color: green">{{calculatePercentageEarned(row.item.employer_contribution)}}%</p>
              </template>
              <template #cell(actions)="row">
                <!-- <b-button
                    variant="info"
                    size="sm"
                    @click="info(row.item, row.index, $event.target)"
                    class="mr-1"
                  >
                    SHOW DETAILS
                  </b-button> -->
                <b-button size="sm" 
                  variant="warning"
                  @click="showModifyModal(row.item, row.index, $event.target)"
                  >
                  <b-icon-eye></b-icon-eye>
                   Modify Contribution
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
      </div>

      <b-modal
        header-text-variant="dark"
        ref="my-modal"
        id="modal-lg"
        size="lg"
      >
        <h6 style="color: red">Uploaded Initially By: {{form.uploaded_by }}</h6>
        <hr />

        <b-form-group
          id="input-group-1"
          label="Total Employee Shares (As of the moment...)"
          label-for="input-1"
          description="We'll never share you're total contribution value with anyone else."
        >
          <b-form-input
            id="input-1"
            v-model="form.total_employee_shares"
            readonly
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="input-group-2"
          label="Employee Contribution :"
          label-for="input-2"
        >
          <b-form-input
            id="input-2"
            v-model="form.employee_contribution"
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="input-group-2"
          label="Employer Contribution :"
          label-for="input-2"
        >
          <b-form-input
            id="input-2"
            v-model="form.employer_contribution"
          ></b-form-input>
        </b-form-group>
        <b-button @click="updateContribution()" variant="outline-success"><b-icon-save2></b-icon-save2> Save Changes</b-button>
        <b-button @click="showContributionHistory(form.id, form.username)"
          variant="outline-warning"><b-icon-eye></b-icon-eye> View History</b-button>

           <template #modal-footer>
            <div class="w-100"></div>
          </template>

          <template #modal-header>
            <div class="w-100">
              <h4><b-icon-calendar></b-icon-calendar>  For the month of: {{ form.date_of_contribution }}</h4>
            </div>
          </template>
      </b-modal>

       <b-modal
        header-bg-variant="info"
        header-text-variant="dark"
        ref="my-modal-showContributionHistory"
        id="modal-lg"
        size="xl"
      >

       <h3 style="font-family: monospace">Changes on this contribution of: {{form.username}}</h3>
           <b-table striped hover :items="items2" :fields="fields2">
              <template #cell(created_at)="row">
                <p style="color: red">{{convertDate(row.item.created_at)}}</p>
              </template>
              <template #cell(employee_contribution)="row">
                <p v-if="row.item.employee_contribution_change === 1" style="color: green">${{row.item.employee_contribution}}</p>
                <p v-else >${{row.item.employee_contribution}}</p>
              </template>
              <template #cell(employer_contribution)="row">
                <p v-if="row.item.employer_contribution_change === 1" style="color: green">${{row.item.employer_contribution}}</p>
                <p v-else >${{row.item.employer_contribution}}</p>
              </template>
           </b-table>
        

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
      this.$store.dispatch("monthlycontribution/fetch")
      .then(response => {
          loader.hide()
          this.items = response;
          this.totalRows = response.length;

          this.$store.dispatch("employees/fetchTotalEmployeeContribution")
          .then(response => {
              this.total_employees_contribution = response
          })

      })
    },
    data() {
      return {
        total_employees_contribution: 0,
        form: {
          id: 0,
          username: '',
          total_employee_shares: '',
          date_of_contribution: '',
          employee_contribution: 0,
          employer_contribution: 0,
          uploaded_by: ''
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
            key: 'employee_contribution',
            label: 'Employee Contribution',
            sortable: true
          },
          {
            key: 'percentage_employee_contr',
            label: '% of Employee Contribution.',
            sortable: true
          },
          {
            key: 'employer_contribution',
            label: 'Employer Contribution',
            sortable: true,
          },
          {
            key: 'percentage_employer_contr',
            label: '% of Employer Contribution.',
            sortable: true
          },
          {
            key: 'employee_gained',
            label: 'Employee Gained',
            sortable: true,
          },
          {
            key: 'date_of_contribution',
            label: 'For the month of',
            sortable: true,
            // variant: 'danger'
          },
           {
            key: 'uploaded_by',
            label: 'Uploaded by',
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
        items2: [],
        fields2: [
          {
             key: 'employee_contribution_id',
             label: 'Employee Contribution Id',
             sortable: true
          },
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
             label: 'Employer Gained',
             sortable: true
          },
          {
             key: 'updated_by',
             label: 'Updated by',
             sortable: true
          },
          {
             key: 'created_at',
             label: 'Updated At',
             sortable: true
          }
        ],

      }
    },
    methods: {
      calculatePercentageEarned(total){
          let val = (total / this.total_employees_contribution) * 100
          return val.toFixed(2)
      },
      updateContribution() {
           let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                    loader: 'spinner',
                    color: '#54e375'
                });
         this.$store.dispatch("monthlycontribution/updateContribution",[this.form])
            .then(response => {
              loader.hide()
              this.$refs['my-modal'].hide()

              if(response.status == 'ERROR'){
                  this.flashMessage.setStrategy('single');
                  this.flashMessage.error({
                    title: 'INVALID',
                    message: 'There was an error updating your contribution. Please contact your administration.',
                    icon: false,
                  });

              } else if (response.status == 'SUCCESS'){

                 this.flashMessage.setStrategy('single');
                  this.flashMessage.success({
                    message: 'The Contribution Value has been updated Successfully',
                    icon: false,
                  });

                  this.$store.dispatch("monthlycontribution/fetch")
                    .then(response => {
                        this.items = response;
                        this.totalRows = response.length;
                  })
              }

            })
            .catch((error) => {

            });
      },
      showModifyModal(item, index, button){
        this.form.total_employee_shares = item.employee_gained
        this.form.date_of_contribution = item.date_of_contribution
        this.form.employee_contribution = item.employee_contribution
        this.form.employer_contribution = item.employer_contribution
        this.form.uploaded_by = item.uploaded_by
        this.form.id = item.id
        this.form.username = item.username

        this.$refs['my-modal'].show()
      },
      showContributionHistory(id, username){
        this.items2 = []
        let loader = this.$loading.show({
          // Optional parameters
          container: this.fullPage ? null : this.$refs.formContainer,
          canCancel: true,
          onCancel: this.onCancel,
          loader: 'spinner',
          color: '#000000'
        });
        this.$refs['my-modal-showContributionHistory'].show()

        this.$store.dispatch("employees/fetchContributionHistory", {
            'id': id,
            'username': username
        })
        .then(response => {
          loader.hide()
           this.items2 = response
        })

      },
      convertDate(date){
        return moment(date).format('LLLL')
      }

    }
}
</script>
