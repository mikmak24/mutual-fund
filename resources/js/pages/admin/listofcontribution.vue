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
          <FlashMessage :position="'right bottom'" />
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h5 class="">
              <b-icon icon="file-earmark" variant="dark"></b-icon>
              List of Contributions
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
                    <p style="color: red;">${{row.item.employee_contribution}}</p>
                  </template>
                  <template #cell(employer_contribution)="row">
                    <p style="color: red;">${{row.item.employer_contribution}}</p>
                  </template>
                  <template #cell(employee_gained)="row">
                    <p style="color: red;">${{row.item.employee_gained}}</p>
                  </template>
                <template #cell(actions)="row">
                  <b-button
                    variant="info"
                    size="sm"
                    @click="info(row.item, row.index, $event.target)"
                    class="mr-1"
                  >
                    SHOW DETAILS
                  </b-button>
                  <b-button size="sm" @click="row.toggleDetails"
                  variant="warning"
                  >
                   EDIT Contribution
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
      this.items = this.$store.getters["monthlycontribution/getArrayOfContributions"];
      this.totalRows = this.$store.getters["monthlycontribution/getArrayOfContributions"].length;
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
            key: 'employee_contribution',
            label: 'Employee Contribution',
            sortable: true
          },
          {
            key: 'employer_contribution',
            label: 'Employer Contribution',
            sortable: true,
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
    }
}
</script>
