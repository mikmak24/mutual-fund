<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <!-- Page Content  -->
    <div id="content">
      <Navbar />

      <div class="p-4 p-md-5">
        <h2 class="mb-4">List of Employees</h2>

        <FlashMessage :position="'right bottom'" />

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
                <!-- <b-button
                    variant="info"
                    size="sm"
                    @click="info(row.item, row.index, $event.target)"
                    class="mr-1"
                  >
                    SHOW DETAILS
                  </b-button> -->
                <b-button
                  size="sm"
                  @click="showModifyModal(row.item, row.index, $event.target)"
                  variant="warning"
                >
                  Modify Contribution
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
        ref="my-modal"
        id="modal-lg"
        size="lg"
        title="Modify Contribution"
      >
        <b-form-group
          id="input-group-1"
          label="Total Employee Shares"
          label-for="input-1"
          description="We'll never share you're total contribution value with anyone else."
        >
          <b-form-input
            id="input-1"
            v-model="form.total_employee_shares"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group id="input-group-2" label="Your Name:" label-for="input-2">
          <b-form-input
            id="input-2"
            placeholder="Enter name"
            required
          ></b-form-input>
        </b-form-group>
      </b-modal>
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
          total_employee_shares: '',
          name: '',
          food: null,
          checked: []
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
        items: []

      }
    },
    methods: {
      info(item, index, button) {
        console.log(button)
        // this.infoModal.title = `Row index: ${index}`
        // this.infoModal.content = JSON.stringify(item, null, 2)
        // this.$root.$emit('bv::show::modal', this.infoModal.id, button)
      },

      showModifyModal(item, index, button){
        this.form.total_employee_shares = item.total_employee_shares
        this.$refs['my-modal'].show()
      }
    }
}
</script>
