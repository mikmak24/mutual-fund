<template>
	<div class="wrapper d-flex align-items-stretch">
		<Sidebar />
		<!-- Page Content  -->
		<div id="content" class="p-4 p-md-5">
			<main role="main" style="margin-left: 1%">
			<Navbar />
            <FlashMessage :position="'right top'"/>
            <div>
            <b-jumbotron bg-variant="info" text-variant="white" border-variant="dark">
                <template #header>Master Account Value</template>
                <template #lead>
                    <p>*Currency: DOLLAR ($) </p>
                    <div class="form-group">
                        <input style="color:red; font-size: 30px;" type="number" v-model="value" class="form-control">
                    </div>
                        <b-button type="submit" @click="updateMasterAccount()" variant="warning">Update Value of Master Account</b-button>
                </template>               
            </b-jumbotron>
            </div>
			</main>
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

        this.$store.dispatch("masteraccount/fetch")
        .then(res => {
           this.value = res[0].master_account_amount
        })
      .catch(err => console.log(err));

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

			json_data: [{}]
		};
	},
	methods: {

        updateMasterAccount(){

            this.$store.dispatch("masteraccount/updateMasterAccount",{'value':this.value})
            .then(response => {
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
