<template>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<v-text-field
				  name="party_name"
				  label="Party Name"
				  class="input-group--focused"
				  single-line
				></v-text-field>
				<v-text-field
				  name="party_name"
				  label="Telp"
				  class="input-group--focused"
				  single-line
				></v-text-field>
				<v-btn color="success"><i class="fa fa-plus"></i>&nbsp;Room</v-btn>
			</div>
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3 class="pull-left py-2">Room 1</h3>
						<div class="row">
							<div class="col-sm-6">
								<v-btn class="pull-right" color="primary"><i class="fa fa-plus"></i>&nbsp;Infant</v-btn>
							</div>
							<div class="col-sm-6">
								<v-select
								  :items="bedOptions"
								  label="Select Bed"
								></v-select>
							</div>
						</div>
					</div>
					<div class="card-body row">
						<div class="col-sm-6">
							<v-text-field
							  label="Name"
							  class="input-group--focused"
							  single-line
							></v-text-field>
							<v-menu
		                      v-model="room.menu_birth_date"
		                      :close-on-content-click="false"
		                      :nudge-right="40"
		                      transition="scale-transition"
		                      offset-y
		                      full-width
		                      min-width="1px"
		                    >
		                      <template v-slot:activator="{ on }">
		                        <v-text-field
		                          v-model="room.date_birth"
		                          label="Birth Date"
		                          prepend-icon="event"
		                          readonly
		                          v-on="on"
		                        ></v-text-field>
		                      </template>
		                      <v-date-picker v-model="room.date_birth" @input="room.menu_birth_date = false"></v-date-picker>
		                    </v-menu>
							<v-text-field
							  label="Passport"
							  class="input-group--focused"
							  single-line
							></v-text-field>
							<v-menu
		                      v-model="room.menu_expired_at"
		                      :close-on-content-click="false"
		                      :nudge-right="40"
		                      transition="scale-transition"
		                      offset-y
		                      full-width
		                      min-width="1px"
		                    >
		                      <template v-slot:activator="{ on }">
		                        <v-text-field
		                          v-model="room.expired_at"
		                          label="Passport Expired"
		                          prepend-icon="event"
		                          readonly
		                          v-on="on"
		                        ></v-text-field>
		                      </template>
		                      <v-date-picker v-model="room.expired_at" @input="room.menu_expired_at = false"></v-date-picker>
		                    </v-menu>
		                    <v-text-field
							  label="Issuing"
							  class="input-group--focused"
							  single-line
							></v-text-field>
						</div>
						<div class="col-sm-6">
							<v-select
							  :items="gender"
							  label="Select Gender"
							></v-select>
							<v-text-field
							  label="Birth Place"
							  class="input-group--focused"
							  single-line
							></v-text-field>
							<v-text-field
							  label="Note"
							  class="input-group--focused"
							  single-line
							></v-text-field>
							<div class="final preview_div satu row">
								<div class="preview_image col-sm-12">
									<img style="width: 100%;height: 200px;border: 1px solid hotpink" id="passport_image_preview">
								</div>
								<div class="file-upload upl_3 col-sm-12 py-3">
									<div class="file-select">
										<div class="file-select-button fileName" >Passport</div>
										<div class="file-select-name noFile">Choose Passport</div>
										<input type="file" class="chooseFile" id="final" name="fc" @change="uploadImage()">
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<v-checkbox v-model="room.additional" label="FPG INSURANCE"></v-checkbox>
							<v-checkbox v-model="room.additional" label="PREMIUM MEAT"></v-checkbox>
							<hr>
						</div>
					</div>
				</div>
			</div>
		</div>
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
	            gender:[
	            	'Male',
	            	'Female'
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
					bed:[],
              		total_bed:[],
              		name:[],
              		date_birth:'2019-09-01',
              		passport:[],
              		passport_image:[],
              		expired_at:'2019-09-01',
              		issuing:[],
              		gender:[],
              		place_birth:[],
              		note:[],
              		additional:[],
              		type:[],
              		menu_birth_date:false,
              		menu_expired_at:false,
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

	        $('.chooseFile').bind('change', function() {
	            var filename = $(this).val();
	            var fsize = $(this)[0].files[0].size;
	            if (fsize > 5048576) //do something if file size more than 1 mb (1048576)
	            {
	                alert('Data To Big');
	                return false;
	            }
	            var parent = $(this).parents(".preview_div");
	            if (/^\s*$/.test(filename)) {
	                $(parent).find('.file-upload').removeClass('active');
	                $(parent).find(".noFile").text("No file chosen...");
	            } else {
	                $(parent).find('.file-upload').addClass('active');
	                $(parent).find(".noFile").text(filename.replace("C:\\fakepath\\", ""));
	            }
	        });

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
			uploadImage(){
                var input = $('#final');
                this.room.passport_image = input[0].files[0];
                var image = window.URL.createObjectURL(this.room.passport_image);
                $('#passport_image_preview').attr('src',image);
	        },
		}
	}
</script>