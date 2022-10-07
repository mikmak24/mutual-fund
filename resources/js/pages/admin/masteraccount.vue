<template>
  <div class="wrapper d-flex align-items-stretch">
    <Sidebar />
    <!-- Page Content  -->
    <div id="content">
      <Navbar />

      <div class="p-4 p-md-5">
        <FlashMessage :position="'right top'" />
        <div>

          <div class="p-5 text-center bg-image rounded-3" style="background-image: url('https://images0.plumbersstock.com/content/master_account-1.jpeg'); height: 400px;">
  <div class="mask">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="text-white">
        <h1 class="mb-3"><b>Master Account Value</b></h1>
        <p>*Currency: DOLLAR ($)</p>
        <div class="form-group">
                <input
                  style="color: black; font-size: 30px"
                  v-if="showString"
                  value="*********************"
                  class="form-control"
                />
                <input
                  style="color: black; font-size: 30px"
                  v-if="showValue"
                  type="number"
                  v-model="value"
                  class="form-control"
                />
              </div>

            <p>  <b-button
                v-if="showString"
                @click="clickShowValue()"
                variant="outline-dark"
                size="sm"
                class="mb-2"
              >
                <b-icon icon="eye-fill" aria-hidden="true"></b-icon> SHOW
              </b-button>
              
              <b-button
                v-if="showValue"
                @click="clickShowString()"
                variant="outline-dark"
                >HIDE</b-button>

              <b-button
                v-if="showValue"
                type="submit"
                variant="success"
                @click="updateMasterAccount()"
              >
                <b-icon icon="save"></b-icon> Save Changes
              </b-button>
              
              
              </p>
        
      </div>
    </div>
  </div>
</div>
<br>
          <!-- <b-jumbotron
            bg-variant="warning"
            text-variant="white"
            border-variant="dark"
          >
            <template #header>Master Account Value</template>
            <template #lead>
              <p>*Currency: DOLLAR ($)</p>
              <div class="form-group">
                <input
                  style="color: black; font-size: 30px"
                  v-if="showString"
                  value="*********************"
                  class="form-control"
                />
                <input
                  style="color: black; font-size: 30px"
                  v-if="showValue"
                  type="number"
                  v-model="value"
                  class="form-control"
                />
              </div>
              <b-button
                v-if="showString"
                @click="clickShowValue()"
                variant="outline-dark"
                size="sm"
                class="mb-2"
              >
                <b-icon icon="eye-fill" aria-hidden="true"></b-icon> SHOW
              </b-button>
              <b-button
                v-if="showValue"
                @click="clickShowString()"
                variant="outline-dark"
                >HIDE</b-button
              >

              <b-button
                v-if="showValue"
                type="submit"
                variant="success"
                @click="updateMasterAccount()"
              >
                <b-icon icon="save"></b-icon> Save Changes
              </b-button>
            </template>
          </b-jumbotron> -->

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
                  <b-form-checkbox value="amount">Amount</b-form-checkbox>
                  <b-form-checkbox value="changed_by"
                    >Reason of Change</b-form-checkbox
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

              <template #cell(percentage)="row">
                <p v-if="row.item.status === 'increases'" style="color: green"><b-icon-arrow-up-square-fill></b-icon-arrow-up-square-fill>  {{row.item.percentage}}%</p>
                <p v-else style="color: red"><b-icon-arrow-down-square-fill></b-icon-arrow-down-square-fill>  {{row.item.percentage}}%</p>       
              </template>

               <template #cell(difference)="row">
                <p v-if="row.item.status === 'increases'" style="color: green"><b-icon-arrow-up-square-fill></b-icon-arrow-up-square-fill>  {{row.item.difference}}</p>
                <p v-else style="color: red"><b-icon-arrow-down-square-fill></b-icon-arrow-down-square-fill>  {{row.item.difference}}</p>       
              </template>
          
                <template #cell(actions)="row">
             
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
        </b-modal>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "../../components/Navbar";
import Sidebar from "../../components/Sidebar";
import Footer from "../../components/Footer";

export default {
	name: "Dashboard",
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
       this.$store.dispatch("masteraccount/fetch").then(response => {
           loader.hide()
            this.value = response[0].master_account_amount
            this.$store.dispatch("masteraccount/fetchMasterValueHistory").then(response => {
              
                this.items = response;
                this.totalRows = response.length;
            });
        })
    },
	data() {
		return {
			date: "",
			file: null,
			json_fields: {
				Eclipse_ID: "name",
				Employee_Contribution: "employee_cont",
				Employer_Contribution: "employer_cont",
				Employee_Salary: "employer_cont"
			},
            value: 0,
			json_data: [{}],
            showString: true,
            showValue: false,

            perPage: 10,
            pageOptions: [5, 10, 15, { value: 100, text: "Show a lot" }],
            totalRows: 1,
            currentPage: 1,
            filter: null,
            filterOn: [],
            fields: [
            {
                key: 'amount',
                label: 'Amount',
                sortable: true
            },
            {
                key: 'changed_by',
                label: 'Reason of Change',
                sortable: true
            },
            {
                key: 'percentage',
                label: 'Percentage (Gains/Loss)',
                sortable: true,
            },
            {
                key: 'difference',
                label: 'Difference (Gaines/Loss)',
                sortable: true,
            },
            {
                key: 'date_of_change',
                label: 'Date of Change',
                sortable: true,
            }
          
            ],
            items: []

		};
	},
	methods: {
        clickShowValue(){
            this.showString = false
            this.showValue = true
        },

        clickShowString(){
            this.showString = true
            this.showValue = false
        },

        updateMasterAccount(){
            let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                    loader: 'spinner',
                    color: '#000000'
            });
            this.$store.dispatch("masteraccount/updateMasterAccount",{'value':this.value})
            .then(response => {
              loader.hide()
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
                    title: 'Master Account Value',
                    message: 'The Value has been updated Successfully',
                    icon: false,
                  });

                 this.$store.dispatch("masteraccount/fetch")
                    .then(res => {
                    this.value = res[0].master_account_amount
                    this.$store.dispatch("masteraccount/fetchMasterValueHistory").then(response => {
                        this.items = response;
                        this.totalRows = response.length;
                    });
                    })
              }
            })
            .catch((error) => {

            });
        }
	}
};
</script>
