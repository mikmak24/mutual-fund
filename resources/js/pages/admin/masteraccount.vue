<template>
	<div class="wrapper d-flex align-items-stretch">
		<Sidebar />
		<!-- Page Content  -->
		<div id="content">
            			<Navbar />

          <div  class="p-4 p-md-5">
            <FlashMessage :position="'right top'"/>
            <div>
            <b-jumbotron bg-variant="warning" text-variant="white" border-variant="dark">
                <template #header>Master Account Value</template>
                <template #lead>
                    <p>*Currency: DOLLAR ($) </p>
                    <div class="form-group">
                        <input style="color:black; font-size: 30px;" v-if="showString" value="*********************" class="form-control">
                        <input style="color:black; font-size: 30px;" v-if="showValue" type="number" v-model="value" class="form-control">
                    </div>
                        <b-button v-if="showString" @click="clickShowValue()" variant="outline-dark">SHOW</b-button>
                        <b-button v-if="showValue"  @click="clickShowString()" variant="outline-dark">HIDE</b-button>

                         <b-button v-if="showValue" type="submit" variant="success" @click="updateMasterAccount()">
                            <b-icon icon="save"></b-icon> Save Changes
                        </b-button>

                </template>               
            </b-jumbotron>
            </div>
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
            showValue: false
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
                    })
              } 
           
            })
            .catch((error) => {
            
            });

        }
		
	}
};
</script>
