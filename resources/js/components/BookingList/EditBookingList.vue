<template>
	<div class="container">
		<v-layout row>
	      	<v-flex xs12>
		        <v-card tile flat class="p-3">
		          	<v-text-field
				      v-model="guest_leader.party_name"
				      label="Party Name"
				      @blur="$v.guest_leader.party_name.$touch()" :error-messages="partyNameErrors"
				    ></v-text-field>

				    <v-text-field
				      v-model="guest_leader.telp"
				      label="Telp"
				      @blur="$v.guest_leader.telp.$touch()" :error-messages="telpErrors"
				    ></v-text-field>
		        </v-card>

		        <v-card tile flat class="p-3" v-for="(item,i) in items.booking_d" v-bind:key="item.dt">
		          	<table class="table ">
		          		<tr>
		          			<td colspan="2"><h4 class="py-4">Room {{ i+1 }}</h4></td>
		          			<td colspan="2">
		          				<v-select
			          			  :items="bedOptions"
			          			  v-model="room.bed"
			          			  label="Select Bed"
			          			></v-select>
		          			</td>
		          			<td colspan="2" class="text-center">
		          				<v-btn color="primary" class="px-2"><i class="fa fa-plus"></i>&nbsp;Infant</v-btn>
		          			</td>
		          		</tr>
		          		<tr v-for="(pax,i) in item.booking_pax">
		          			<td>Nama</td>
		          			<td>
		          				<input type="text" class="form-control" name="">
		          			</td>
		          		</tr>
		          	</table>
		        </v-card>
	        </v-flex>
	    </v-layout>
	</div>
</template>
<script type="text/javascript">
  	import { required, maxLength, email } from 'vuelidate/lib/validators'
    import VueDropify from 'vue-dropify';
	export default{
		name:'EditBookingList',
		components: {
	      'vue-dropify': VueDropify
	    },
		data(){
			return{
				items:[],
	            total:3,
	            pricing:[],
	            bedOptions:[
	            	'Single Bed',
	            	'Double Bed',
	            	'Twin Bed',
	            	'Triple Bed',
	            	'Double/Twin + CnB',
	            	'Double/Twin + CwB',
	            ],
	            count:{
	            	adult:0,
	            	child:0,
	            	infant:0,
	            },
				apiReady:false,
				error:false,
				guest_leader:{
					party_name:null,
					telp:null,
				},
				room:{
					name:[],
					bed:[],
				}
			}
		},
		validations:{
			guest_leader:{
				party_name:{
					required
				},
				telp:{
					required
				},
			},
			room:{
				name:{
					$each:{
						$each:{
							required
						}
					}
				}
			}
		},
		computed:{
			partyNameErrors() {
			    const errors = []
		        if (!this.$v.guest_leader.party_name.$dirty) return errors
		        !this.$v.guest_leader.party_name.required && errors.push('Party Name is required.')
		        return errors
			},
			telpErrors() {
			    const errors = []
		        if (!this.$v.guest_leader.telp.$dirty) return errors
		        !this.$v.guest_leader.telp.required && errors.push('Telp is required.')
		        return errors
			},
	    },
		mounted(){
	        console.log('Intialize Main Page...')
	        console.log(this.$v);
	        let breadcrumb = '<router-link to="/booking-list">Booking List Detail</router-link>';
	        $('#crumb').html(breadcrumb);
	        Vue.filter('currency', function(val){
	          return accounting.formatNumber(val)
	        })
	        axios.get('/api/get-token')
	            .then(response => {
	                axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.access_token;

	            })
	            .catch(error => {
	                console.log(error)
	                this.errored = true
	            })
	            .finally(() => this.apiReady = true)
		},
		watch:{
			apiReady(){
				this.callingApi();
			},
		},
		methods:{
			callingApi(){
	            axios.get('/api/booking-list/edit?id='+this.$route.params.id)
	                .then(response => {
	                	this.items = response.data.data.data;
            			this.pricing = response.data.data.invoice_list;
            			this.total = response.data.data.data.total;
        				for (var i1 = 0; i1 < this.items.payment_history.length; i1++) {
        					this.pricing.push({
			  		  			type:'Payment',
			  		  			name:this.items.payment_history[i1].code,
			  		  			nominal:this.items.payment_history[i1].total_payment,
			  		  			value: 1,
			  		  			chargePerAmount: this.items.payment_history[i1].total_payment,
			  		  		});

        					this.total -= this.items.payment_history[i1].total_payment;
        				}

    					this.items.paid = 0;
						for (var i = 0; i < this.items.booking_d.length; i++) {
							for (var i1 = 0; i1 < this.items.booking_d[i].booking_pax.length; i1++) {
    							if (this.items.booking_d[i].booking_pax[i1].type == 'Adult') {
									this.count.adult += 1;
								}else if(this.items.booking_d[i].booking_pax[i1].type == 'Child No Bed' || this.items.booking_d[i].booking_pax[i1].type == 'Child With Bed'){
									this.count.child += 1;
								}else if(this.items.booking_d[i].booking_pax[i1].type == 'Infant'){
									this.count.infant += 1;
								}
    						}
						}
						console.log(this.items);
	                })
	                .catch(error => {
	                    console.log(error)
	                    this.error = true
	                })
	                .finally(() => this.loadingDataTable = true, this.isLoading = false)
			},
			changeImage(param,id,id_booking,dt){

			}
		}
	}
</script>