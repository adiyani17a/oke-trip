<template>
	<div class="container">
		<v-dialog
	      v-model="showModalProcess"
	      max-width="290"
	    >
	      <v-card>
	        <v-card-title class="headline">Process Data?</v-card-title>

	        <v-card-text>
	          Your Action Cant Be Undone
	        </v-card-text>

	        <v-card-actions>
	          <div class="flex-grow-1"></div>

	          <v-btn
	          	v-if="!loadingProcess"
	            color="green darken-1"
	            @click="showModalProcess = false"
	            class="white--text"
	          >
	            No
	          </v-btn>

	          <v-btn
	          	v-if="loadingProcess"
	            color="green darken-1"
	            class="white--text"
	          	>
	            <i class="fa fa-spin fa-spinner"></i>
	          </v-btn>
	          <v-btn
	          	v-if="!loadingProcess"
	            color="green darken-1"
	            @click="saveData"
	            class="white--text"
	          	>
	            Yes
	          </v-btn>
	        </v-card-actions>
	      </v-card>
	    </v-dialog>
		<div class="row"  v-if="!formReady">
			<div class="col-sm-12 display-4 text-center pink--text">
				<i class="fas fa-circle-notch fa-spin"></i>
			</div>
		</div>
		<div class="row" v-if="formReady">
			<div class="col-sm-12">
				<v-text-field
				  label="Party Name"
				  v-model="guest_leader.party_name"
				  class="input-group--focused"
				 @blur="$v.guest_leader.party_name.$touch()" 
				 :error-messages="partyNameErrors"
				></v-text-field>
				<v-text-field
				  label="Telp"
				  class="input-group--focused"
				  v-model="guest_leader.telp"
				  @blur="$v.guest_leader.telp.$touch()" 
				 :error-messages="telpErrors"
				></v-text-field>
				<v-text-field
				  label="Remark"
				  class="input-group--focused"
				  v-model="remark"
				  @blur="$v.remark.$touch()" 
				 :error-messages="remarkErrors"
				></v-text-field>
				<v-select
                  v-model="users_id"
                  label="Agent"
                  :items="userOptions"
                  item-text="name"
                  item-value="id"
                  @blur="$v.users_id.$touch()" 
                  :error-messages="usersErrors"
                  >
                </v-select>
			</div>
			
			<div class="col-sm-4">
				<v-text-field
				  label="Total Adult"
				  class="input-group--focused"
				  v-model="total_adult"
				  readonly
				></v-text-field>
			</div>
			<div class="col-sm-4">
				<v-text-field
				  label="Total Child"
				  class="input-group--focused"
				  v-model="total_child"
				  readonly
				></v-text-field>
			</div>
			<div class="col-sm-4">
				<v-text-field
				  label="Total Infant"
				  class="input-group--focused"
				  v-model="total_infant"
				  readonly
				></v-text-field>
			</div>
			<div class="col-sm-12">
				<table class="table table-bordered">
					<thead>
						<th>Item</th>
						<th>Cost</th>
						<th>Qty</th>
						<th>Price</th>
					</thead>
					<tbody>
						<tr class="item" v-for="(item,idx) in pricing" v-if="item.nominal != 0">
					      <td>{{ item.name }}</td>
					      <td class="text-right"><span v-if="item.type == 'Agent Com' || item.type == 'Staff Com'">-</span>&nbsp;{{ item.chargePerAmount | currency}}</td>
					      <td>{{ item.value }}</td>
					      <td class="text-right"><span v-if="item.type == 'Agent Com' || item.type == 'Staff Com'">-</span>&nbsp;{{ item.nominal | currency}}</td>
					    </tr>
					</tbody>
					<thead>
						<tr>
							<td colspan="3">Total:</td>
							<td colspan="1">{{ total | currency }}</td>
						</tr>
					</thead>
				</table>
			</div>
			<div class="col-sm-3">
				<v-btn color="success" @click="addRoom(room.bed.length)"><i class="fa fa-plus"></i>&nbsp;Room</v-btn>
			</div>
			<div class="col-sm-3">
				<v-btn color="primary" @click="showModalProcess = true;saveDataParam = 'Confirm'"><i class="fa fa-check"></i>&nbsp;Approve</v-btn>
			</div>
			<div class="col-sm-3">
				<v-btn color="warning" @click="showModalProcess = true;saveDataParam = 'Rejected'"><i class="fas fa-ban"></i>&nbsp;Reject</v-btn>
			</div>
			<div class="col-sm-3">
				<v-btn color="default" @click="$router.push({name:'BookingList'})">Back</v-btn>
			</div>
			<div class="col-sm-12">
				<hr>
			</div>
			<div class="col-sm-12">
				<div class="card" v-for="(item,i) in room.bed">
					<div class="card-header">
						<h3 class="pull-left py-2">Room {{ i+1 }}</h3>
						<div class="row">
							<div class="col-sm-6">
								<v-btn class="pull-right" color="error" v-if="i != 0" @click="removeRoom(i)"><i class="fa fa-times"></i>&nbsp;Remove Room</v-btn>
								<v-btn class="pull-right" color="primary" @click="addInfant(i)"><i class="fa fa-plus" ></i>&nbsp;Infant</v-btn>
							</div>
							<div class="col-sm-6">
								<v-select
								  :items="bedOptions"
								  label="Select Bed"
								  v-model="room.bed[i]"
								  @change="changeBed(i)"
								></v-select>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row" v-for="(item1,i1) in room.name[i]">
							<div class="col-sm-6">
								<v-text-field
								  label="Name"
								  v-model="room.name[i][i1]"
								  class="input-group--focused"
								  @blur="$v.room.name.$each[i].$each[i1].$touch()" 
				 				  :error-messages="roomNameErrors(i,i1)"
								></v-text-field>
								<v-menu
			                      v-model="room.menu_birth_date[i][i1]"
			                      :close-on-content-click="false"
			                      :nudge-right="40"
			                      transition="scale-transition"
			                      offset-y
			                      full-width
			                      min-width="1px"
			                    >
			                      <template v-slot:activator="{ on }">
			                        <v-text-field
			                          v-model="room.birth_date[i][i1]"
			                          label="Birth Date"
			                          prepend-icon="event"
			                          readonly
			                          v-on="on"
			              			  @blur="$v.room.birth_date.$each[i].$each[i1].$touch()" 
				 				      :error-messages="roomBirthDateErrors(i,i1)"
			                        ></v-text-field>
			                      </template>
			                      <v-date-picker v-model="room.birth_date[i][i1]" @input="room.menu_birth_date[i][i1] = false"></v-date-picker>
			                    </v-menu>
								<v-text-field
								  v-model="room.passport[i][i1]"
								  label="Passport"
								  class="input-group--focused"
								  @blur="$v.room.passport.$each[i].$each[i1].$touch()" 
				 				  :error-messages="roomPassportErrors(i,i1)"
								></v-text-field>
								<v-menu
			                      v-model="room.menu_expired_at[i][i1]"
			                      :close-on-content-click="false"
			                      :nudge-right="40"
			                      transition="scale-transition"
			                      offset-y
			                      full-width
			                      min-width="1px"
			                    >
			                      <template v-slot:activator="{ on }">
			                        <v-text-field
			                          v-model="room.expired_at[i][i1]"
			                          label="Passport Expired"
			                          prepend-icon="event"
			                          readonly
			                          v-on="on"
			                          @blur="$v.room.expired_at.$each[i].$each[i1].$touch()" 
				 				  	  :error-messages="roomExpiredAtErrors(i,i1)"
			                        ></v-text-field>
			                      </template>
			                      <v-date-picker v-model="room.expired_at[i][i1]" @input="room.menu_expired_at[i][i1] = false"></v-date-picker>
			                    </v-menu>
			                    <v-text-field
								  label="Issuing"
								  class="input-group--focused"
								  v-model="room.issuing[i][i1]"
								  @blur="$v.room.issuing.$each[i].$each[i1].$touch()" 
				 				  :error-messages="roomIssuingErrors(i,i1)"
								></v-text-field>
								<v-btn class="pull-right" color="error" v-if="room.type[i][i1] == 'Infant'" @click="removeInfant(i,i1)"><i class="fa fa-times"></i>&nbsp;Remove Infant</v-btn>
							</div>
							<div class="col-sm-6">
								<v-select
								  :items="gender"
								  v-model="room.gender[i][i1]"
								  label="Select Gender"
								  @blur="$v.room.gender.$each[i].$each[i1].$touch()" 
				 				  :error-messages="roomGenderErrors(i,i1)"
								></v-select>
								<v-text-field
								  label="Birth Place"
								  v-model="room.birth_place[i][i1]"
								  class="input-group--focused"
								  @blur="$v.room.birth_place.$each[i].$each[i1].$touch()" 
				 				  :error-messages="roomBirthPlaceErrors(i,i1)"
								></v-text-field>
								<v-text-field
								  label="Note"
								  v-model="room.note[i][i1]"
								  class="input-group--focused"
								  @blur="$v.room.note.$each[i].$each[i1].$touch()" 
				 				  :error-messages="roomNoteErrors(i,i1)"
								></v-text-field>
								<div class="final preview_div satu row">
									<div class="preview_image col-sm-12">
										<img :src="$root.url_image+room.passport_image[i][i1]" style="width: 100%;height: 200px;border: 1px solid hotpink" :id="'passport_image_preview_'+i+'_'+i1">
									</div>
									<div class="file-upload upl_3 col-sm-12 py-3" v-bind:class="{ active: room.imageActive[i][i1] }">
										<div class="file-select">
											<div class="file-select-button fileName" >Passport</div>
											<div class="file-select-name noFile">passport_{{ i }}_{{ i1 }}</div>
											<input type="file" class="chooseFile" :id="'passport_image_'+i+'_'+i1" name="fc" @change="uploadImage(i,i1)">
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="d-inline" v-for="(additional,i2) in additional">
									<v-checkbox v-model="room.additional[i][i1][i2]"  :label="additional.additional.name" :value="additional.additional.id" @change="countingData"></v-checkbox> 
								</div>
								<hr>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<v-snackbar
	      v-model="snackbar"
	      :color="color"
	      :multi-line="mode === 'multi-line'"
	      :timeout="timeout"
	      :vertical="mode === 'vertical'"
	    >
	      {{ text }}
	      <v-btn
	        dark
	        flat
	        @click="snackbar = false"
	      >
	        Close
	      </v-btn>
	    </v-snackbar>
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
	            total:0,
	            data:0,
	            pricing:[],
	            formReady:false,
	            additional:[],
	            total_adult:0,
	            total_infant:0,
	            total_child:0,
	            snackbar: false,
		        color: 'success',
		        mode: '',
		        text:'',
		        timeout: 6000,
	            bedOptions:[
	            	'Single Bed',
	            	'Double Bed',
	            	'Twin Bed',
	            	'Triple Bed',
	            	'Double/Twin + CnB',
	            	'Double/Twin + CwB',
	            ],
	            gender:[
	            	'male',
	            	'female'
	            ],
	            userOptions:[],
	            count:{
	            	adult:0,
	            	child:0,
	            	infant:0,
	            },
				apiReady:false,
				error:false,
				loadingProcess:false,
				showModalProcess:false,
				saveDataParam:null,
				remark:null,
				users_id:null,
				guest_leader:{
              		total_adult:0,
	              	total_child:0,
	              	total_infant:0,
	              	total_room:0,
	              	party_name:null,
	              	telp:null,
	            },
				room:{
					bed:[],
              		total_bed:[],
              		name:[],
              		birth_date:[],
              		passport:[],
              		passport_image:[],
              		expired_at:[],
              		issuing:[],
              		gender:[],
              		birth_place:[],
              		note:[],
              		additional:[],
              		type:[],
              		menu_birth_date:[],
              		menu_expired_at:[],
              		imageActive:[],
              		type:[],
				}
			}
		},
		validations:{
			remark:{
				required
			},
			users_id:{
				required
			},
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
				},
				birth_date:{
					$each:{
						$each:{
							required
						}
					}
				},
				passport:{
					$each:{
						$each:{
							required
						}
					}
				},
				expired_at:{
					$each:{
						$each:{
							required
						}
					}
				},
				issuing:{
					$each:{
						$each:{
							required
						}
					}
				},
				gender:{
					$each:{
						$each:{
							required
						}
					}
				},
				birth_place:{
					$each:{
						$each:{
							required
						}
					}
				},
				note:{
					$each:{
						$each:{
							required
						}
					}
				},
				passport_image:{
					$each:{
						$each:{
							required
						}
					}
				},
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
			remarkErrors () {
		        const errors = []
				console.log(this.$v)
		        if (!this.$v.remark.$dirty) return errors
		        !this.$v.remark.required && errors.push('Remark is required.')
		        return errors
		    },
			usersErrors(){
				const errors = []
				console.log(this.$v.users_id)
		        if (!this.$v.users_id.$dirty) return errors
		        !this.$v.users_id.required && errors.push('Agen is required.')
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
	                	const data = response.data.data.data;
 			
        				this.guest_leader.party_name = data.name;
        				this.guest_leader.telp = data.telp;
        				this.additional = data.itinerary_detail.itinerary.itinerary_additional
        				this.data = data.itinerary_detail;
        				this.remark = data.remark;
        				this.users_id = data.users_id;

        				response.data.data.user.forEach((d,i) => {
        					this.userOptions.push({name:d.name,id:d.id});
        				});
        				data.booking_d.forEach((d,i) => {
	                    	this.room.bed.splice(i, 1,d.bed);
	                    	this.room.name.splice(i, 1,[]);
	                    	this.room.birth_date.splice(i, 1,[]);
	                    	this.room.menu_birth_date.splice(i, 1,[]);
	                    	this.room.passport.splice(i, 1,[]);
	                    	this.room.expired_at.splice(i, 1,[]);
	                    	this.room.menu_expired_at.splice(i, 1,[]);
	                    	this.room.issuing.splice(i, 1,[]);
	                    	this.room.gender.splice(i, 1,[]);
	                    	this.room.birth_place.splice(i, 1,[]);
	                    	this.room.note.splice(i, 1,[]);
	                    	this.room.passport_image.splice(i, 1,[]);
	                    	this.room.imageActive.splice(i, 1,[]);
	                    	this.room.additional.splice(i, 1,[]);
	                    	this.room.type.splice(i, 1,[]);
	                    	d.booking_pax.forEach((d1,i1) => {
		                    	this.room.name[i].splice(i1, 1,d1.name);
		                    	this.room.birth_date[i].splice(i1, 1,d1.birth_date);
	                    		this.room.menu_birth_date[i].splice(i1, 1,false);
	                    		this.room.passport[i].splice(i1, 1,d1.passport);
	                    		this.room.expired_at[i].splice(i1, 1,d1.exp_date);
	                    		this.room.menu_expired_at[i].splice(i1, 1,false);
	                    		this.room.issuing[i].splice(i1, 1,d1.issuing);
	                    		this.room.gender[i].splice(i1, 1,d1.gender);
	                    		this.room.birth_place[i].splice(i1, 1,d1.birth_place);
	                    		this.room.note[i].splice(i1, 1,d1.remark);
	                    		this.room.passport_image[i].splice(i1, 1,d1.passport_image);
	                    		this.room.imageActive[i].splice(i1, 1,true);
	                    		this.room.type[i].splice(i1, 1,d1.type);
	                    		this.room.additional[i].splice(i1, 1,[]);
	                    		this.additional.forEach((d2,i2)=>{
	                				this.room.additional[i][i1].splice(i2, 1,0);
		        					d1.booking_additional.forEach((d3,i3) =>{
		        						if (d2.additional_id == d3.additional_id) {
	                						this.room.additional[i][i1].splice(i2, 1,d3.additional_id);
		        						}
		        					})
		        				});
	        				});

	        				this.countingData();
        				});
	                })
	                .catch(error => {
	                    console.log(error)
	                    this.error = true
	                })
	                .finally(() => this.formReady = true)
			},
			addRoom(i){
				var date = new Date();
				date = [
				  date.getFullYear(),
				  ('0' + (date.getMonth() + 1)).slice(-2),
				  ('0' + date.getDate()).slice(-2)
				].join('-');

				this.room.bed.splice(i, 1,'Single Bed');
            	this.room.name.splice(i, 1,[]);
            	this.room.birth_date.splice(i, 1,[]);
            	this.room.menu_birth_date.splice(i, 1,[]);
            	this.room.passport.splice(i, 1,[]);
            	this.room.expired_at.splice(i, 1,[]);
            	this.room.menu_expired_at.splice(i, 1,[]);
            	this.room.issuing.splice(i, 1,[]);
            	this.room.gender.splice(i, 1,[]);
            	this.room.birth_place.splice(i, 1,[]);
            	this.room.note.splice(i, 1,[]);
            	this.room.passport_image.splice(i, 1,[]);
            	this.room.imageActive.splice(i, 1,[]);
            	this.room.additional.splice(i, 1,[]);
            	this.room.type.splice(i, 1,[]);

            	this.room.name[i].splice(0, 1,null);
            	this.room.birth_date[i].splice(0, 1,date);
        		this.room.menu_birth_date[i].splice(0, 1,false);
        		this.room.passport[i].splice(0, 1,null);
        		this.room.expired_at[i].splice(0, 1,date);
        		this.room.menu_expired_at[i].splice(0, 1,false);
        		this.room.issuing[i].splice(0, 1,null);
        		this.room.gender[i].splice(0, 1,null);
        		this.room.birth_place[i].splice(0, 1,null);
        		this.room.note[i].splice(0, 1,null);
        		this.room.passport_image[i].splice(0, 1,null);
        		this.room.imageActive[i].splice(0, 1,true);
        		this.room.type[i].splice(0, 1,'Adult');
        		this.room.additional[i].splice(0, 1,[]);
        		this.additional.forEach((d2,i2)=>{
    				this.room.additional[i][0].splice(i2, 1,0);
				});

	        	this.countingData();
			},
			addInfant(i){
				console.log(this.room.name);
				var date = new Date();
				date = [
				  date.getFullYear(),
				  ('0' + (date.getMonth() + 1)).slice(-2),
				  ('0' + date.getDate()).slice(-2)
				].join('-');

        		const last_position =  this.room.name[i].length;

        		for (var i1 = last_position; i1 < last_position+1; i1++) {
    				this.room.name[i].splice(i1, 1,null);
                	this.room.birth_date[i].splice(i1, 1,date);
            		this.room.menu_birth_date[i].splice(i1, 1,false);
            		this.room.passport[i].splice(i1, 1,null);
            		this.room.expired_at[i].splice(i1, 1,date);
            		this.room.menu_expired_at[i].splice(i1, 1,false);
            		this.room.issuing[i].splice(i1, 1,null);
            		this.room.gender[i].splice(i1, 1,null);
            		this.room.birth_place[i].splice(i1, 1,null);
            		this.room.note[i].splice(i1, 1,null);
            		this.room.passport_image[i].splice(i1, 1,null);
            		this.room.imageActive[i].splice(i1, 1,true);
            		this.room.type[i].splice(i1, 1,'Infant');
            		this.room.additional[i].splice(i1, 1,[]);

                    this.additional.forEach((d2, i2) => {
                        this.room.additional[i][i1].splice(i2, 1, 0);
                    });
				}
	        	this.countingData();
			},
			removeInfant(i,i1){
				this.room.name[i].splice(i1, 1);
            	this.room.birth_date[i].splice(i1, 1);
        		this.room.menu_birth_date[i].splice(i1, 1);
        		this.room.passport[i].splice(i1, 1);
        		this.room.expired_at[i].splice(i1, 1);
        		this.room.menu_expired_at[i].splice(i1, 1);
        		this.room.issuing[i].splice(i1, 1);
        		this.room.gender[i].splice(i1, 1);
        		this.room.birth_place[i].splice(i1, 1);
        		this.room.note[i].splice(i1, 1);
        		this.room.passport_image[i].splice(i1, 1);
        		this.room.imageActive[i].splice(i1, 1);
        		this.room.type[i].splice(i1, 1);
        		this.room.additional[i].splice(i1, 1);
	        	this.countingData();
			},
			removeRoom(i){

				this.room.name.splice(i, 1);
				this.room.bed.splice(i, 1);
            	this.room.birth_date.splice(i, 1);
        		this.room.menu_birth_date.splice(i, 1);
        		this.room.passport.splice(i, 1);
        		this.room.expired_at.splice(i, 1);
        		this.room.menu_expired_at.splice(i, 1);
        		this.room.issuing.splice(i, 1);
        		this.room.gender.splice(i, 1);
        		this.room.birth_place.splice(i, 1);
        		this.room.note.splice(i, 1);
        		this.room.passport_image.splice(i, 1);
        		this.room.imageActive.splice(i, 1);
        		this.room.type.splice(i, 1);
        		this.room.additional.splice(i, 1);
	        	this.countingData();
			},
			changeBed(i){
				let total_person = 0;
				if (this.room.bed[i] == 'Single Bed') {
					total_person = 1
        		}else if (this.room.bed[i] == 'Double Bed') {
					total_person = 2
        		}else if (this.room.bed[i] == 'Twin Bed') {
					total_person = 2
        		}else if (this.room.bed[i] == 'Triple Bed') {
					total_person = 3
        		}else if (this.room.bed[i] == 'Double/Twin + CnB') {
					total_person = 3
        		}else if (this.room.bed[i] == 'Double/Twin + CwB') {
					total_person = 3
        		}

        		var date = new Date();
				date = [
				  date.getFullYear(),
				  ('0' + (date.getMonth() + 1)).slice(-2),
				  ('0' + date.getDate()).slice(-2)
				].join('-');


        		const last_position =  this.room.name[i].length;

        		let temp_infant = [];
        		for (var i1 = 0; i1 < this.room.name[i].length; i1++) {
        			if (this.room.type[i][i1] == 'Infant') {
        				temp_infant.push({
        					name: this.room.name[i][i1],
		                	birth_date: this.room.birth_date[i][i1],
		            		menu_birth_date: this.room.menu_birth_date[i][i1],
		            		passport: this.room.passport[i][i1],
		            		expired_at: this.room.expired_at[i][i1],
		            		menu_expired_at: this.room.menu_expired_at[i][i1],
		            		issuing: this.room.issuing[i][i1],
		            		gender: this.room.gender[i][i1],
		            		birth_place: this.room.birth_place[i][i1],
		            		note: this.room.note[i][i1],
		            		passport_image: this.room.passport_image[i][i1],
		            		imageActive: this.room.imageActive[i][i1],
		            		type: this.room.type[i][i1],
		            		additional: this.room.additional[i][i1],
        				})
        			}
        		}


        		for (var i1 = (last_position-temp_infant.length); i1 < (total_person); i1++) {
    				this.room.name[i].splice(i1, 1,null);
                	this.room.birth_date[i].splice(i1, 1,date);
            		this.room.menu_birth_date[i].splice(i1, 1,false);
            		this.room.passport[i].splice(i1, 1,null);
            		this.room.expired_at[i].splice(i1, 1,date);
            		this.room.menu_expired_at[i].splice(i1, 1,false);
            		this.room.issuing[i].splice(i1, 1,null);
            		this.room.gender[i].splice(i1, 1,null);
            		this.room.birth_place[i].splice(i1, 1,null);
            		this.room.note[i].splice(i1, 1,null);
            		this.room.passport_image[i].splice(i1, 1,null);
            		this.room.imageActive[i].splice(i1, 1,true);
            		this.room.type[i].splice(i1, 1,null);
            		this.room.additional[i].splice(i1, 1,[]);

                    this.additional.forEach((d2, i2) => {
                        this.room.additional[i][i1].splice(i2, 1, 0);
                    });
				}


				if (this.room.bed[i] == 'Double Bed' || this.room.bed[i] == 'Twin Bed') {
					this.room.type[i].splice(0, 1, 'Adult')
					this.room.type[i].splice(1, 1, 'Adult')
				}else if (this.room.bed[i] == 'Triple Bed'){
					this.room.type[i].splice(0, 1, 'Adult')
					this.room.type[i].splice(1, 1, 'Adult')
					this.room.type[i].splice(2, 1, 'Adult')
				}else if (this.room.bed[i] == 'Double/Twin + CnB' ){
					this.room.type[i].splice(0, 1, 'Adult')
					this.room.type[i].splice(1, 1, 'Adult')
					this.room.type[i].splice(2, 1, 'Child No Bed')
				}else if ( this.room.bed[i] == 'Double/Twin + CwB'){
					this.room.type[i].splice(0, 1, 'Adult')
					this.room.type[i].splice(1, 1, 'Adult')
					this.room.type[i].splice(2, 1, 'Child With Bed')
				}else{
					this.room.type[i].splice(0, 1, 'Adult')
				}

				if (this.room.name[i] != undefined) {
        			if (this.room.name[i].length > total_person) {
            			this.room.name[i].splice(total_person,this.room.name[i].length);
	              		// this.room_validate.name[i].splice(total_person,this.room_validate.name[i].length);
            		}
        		}

        		if (this.room.additional[i] != undefined) {
        			if (this.room.additional[i].length > total_person) {
            			this.room.additional[i].splice(total_person,this.room.additional[i].length);
	              		// this.room_validate.name[i].splice(total_person,this.room_validate.name[i].length);
            		}
        		}

        		if (this.room.type[i] != undefined) {
        			if (this.room.type[i].length > total_person) {
            			this.room.type[i].splice(total_person,this.room.type[i].length);
	              		// this.room_validate.name[i].splice(total_person,this.room_validate.name[i].length);
            		}
        		}

        		if (this.room.birth_date[i] != undefined) {
        			if (this.room.birth_date[i].length > total_person) {
		            	this.room.birth_date[i].splice(total_person,this.room.birth_date[i].length);
	              		// this.room_validate.date_birth[i].splice(total_person,this.room_validate.date_birth[i].length);
            		}
        		}


        		if (this.room.passport[i] != undefined) {
        			if (this.room.passport[i].length > total_person) {
            			this.room.passport[i].splice(total_person,this.room.passport[i].length);
	              		// this.room_validate.passport[i].splice(total_person,this.room_validate.passport[i].length);
            		}
        		}


        		if (this.room.expired_at[i] != undefined) {
        			if (this.room.expired_at[i].length > total_person) {
	              		this.room.expired_at[i].splice(total_person,this.room.expired_at[i].length);
	              		// this.room_validate.expired_at[i].splice(total_person,this.room_validate.expired_at[i].length);
            		}
        		}


        		if (this.room.issuing[i] != undefined) {
        			if (this.room.issuing[i].length > total_person) {
	              		this.room.issuing[i].splice(total_person,this.room.issuing[i].length);
	              		// this.room_validate.issuing[i].splice(total_person,this.room_validate.issuing[i].length);
            		}
        		}


        		if (this.room.gender[i] != undefined) {
        			if (this.room.gender[i].length > total_person) {
	              		this.room.gender[i].splice(total_person,this.room.gender[i].length);
	              		// this.room_validate.gender[i].splice(total_person,this.room_validate.gender[i].length);
            			
            		}
        		}


        		if (this.room.birth_place[i] != undefined) {
        			if (this.room.birth_place[i].length > total_person) {
	              		this.room.birth_place[i].splice(total_person,this.room.birth_place[i].length);
	              		// this.room_validate.place_birth[i].splice(total_person,this.room_validate.place_birth[i].length);
            		}
        		}


        		if (this.room.note[i] != undefined) {
        			if (this.room.note[i].length > total_person) {
	              		this.room.note[i].splice(total_person,this.room.note[i].length);
	              		// this.room_validate.note[i].splice(total_person,this.room_validate.note[i].length);
            		}
        		}


        		if (this.room.passport_image[i] != undefined) {
        			if (this.room.passport_image[i].length > total_person) {
          		  		this.room.passport_image[i].splice(total_person,this.room.passport_image[i].length);
            		}
        		}

        		temp_infant.forEach((d,i1) =>{
        			this.room.name[i].splice(i1+total_person, 1,d.name);
                	this.room.birth_date[i].splice(i1+total_person, 1,d.birth_date);
            		this.room.menu_birth_date[i].splice(i1+total_person, 1,d.menu_birth_date);
            		this.room.passport[i].splice(i1+total_person, 1,d.passport);
            		this.room.expired_at[i].splice(i1+total_person, 1,d.expired_at);
            		this.room.menu_expired_at[i].splice(i1+total_person, 1,d.menu_expired_at);
            		this.room.issuing[i].splice(i1+total_person, 1,d.issuing);
            		this.room.gender[i].splice(i1+total_person, 1,d.gender);
            		this.room.birth_place[i].splice(i1+total_person, 1,d.birth_place);
            		this.room.note[i].splice(i1+total_person, 1,d.note);
            		this.room.passport_image[i].splice(i1+total_person, 1,d.passport_image);
            		this.room.imageActive[i].splice(i1+total_person, 1,d.imageActive);
            		this.room.type[i].splice(i1+total_person, 1,d.type);
            		this.room.additional[i].splice(i1+total_person, 1,d.additional);
        		});
	        	this.countingData();
			},
			uploadImage(i,i1){
				var input = $('#passport_image_'+i+'_'+i1);
				if (input[0] != undefined) {
	                this.room.passport_image[i][i1] = input[0].files[0];
				}
	                
                if (this.room.passport_image[i][i1] != undefined) {
                	var image = window.URL.createObjectURL(this.room.passport_image[i][i1]);
	                $('#passport_image_preview_'+i+'_'+i1).attr('src',image);
                }
	        },
	        countingData(){
	        	this.total_adult=0;
	        	this.total_child=0;
	        	this.total_infant=0;
	        	this.room.type.forEach((d,i) =>{
	        		this.room.type[i].forEach((d1,i1) =>{
	        			if (d1 == 'Adult') {
	            			this.total_adult += 1;
	            		}else if(d1 == 'Child No Bed' || d1 == 'Child With Bed'){
	            			this.total_child += 1;
	            		}else if(d1 == 'Infant'){
	            			this.total_infant += 1;
	            		}
	        		});
	        	})


	        	this.pricing = [];
	        	this.total = 0;

  		  		this.pricing.push({
  		  			type:'Adult',
  		  			name:'Adult',
  		  			nominal:0,
  		  			value: 0,
  		  			chargePerAmount: this.data.adult_price,
  		  		});

  		  		this.pricing.push({
  		  			type:'Child No Bed',
  		  			name:'Child No Bed',
  		  			nominal:0,
  		  			value: 0,
  		  			chargePerAmount: this.data.child_price,
  		  		});

  		  		this.pricing.push({
  		  			type:'Child With Bed',
  		  			name:'Child With Bed',
  		  			nominal:0,
  		  			value: 0,
  		  			chargePerAmount: this.data.child_bed_price,
  		  		});

  		  		this.pricing.push({
  		  			type:'Infant',
  		  			name:'Infant',
  		  			nominal:0,
  		  			value: 0,
  		  			chargePerAmount: this.data.infant_price,
  		  		});

  		  		this.pricing.push({
  		  			type:'Agent Com',
  		  			name:'Agent Com',
  		  			nominal:0,
  		  			value: 0,
  		  			chargePerAmount: this.data.agent_com,
  		  		});

  		  		this.pricing.push({
  		  			type:'Staff Com',
  		  			name:'Staff Com',
  		  			nominal:0,
  		  			value: 0,
  		  			chargePerAmount: this.data.staff_com,
  		  		});

  		  		this.pricing.push({
  		  			type:'Tips',
  		  			name:'Tips',
  		  			nominal:0,
  		  			value: 0,
  		  			chargePerAmount: this.data.agent_tip,
  		  		});

  		  		this.pricing.push({
  		  			type:'Visa',
  		  			name:'Visa',
  		  			nominal:0,
  		  			value: 0,
  		  			chargePerAmount: this.data.agent_visa,
  		  		});

  		  		this.pricing.push({
  		  			type:'Apt Tax And Surcharge',
  		  			name:'Apt Tax And Surcharge',
  		  			nominal:0,
  		  			value: 0,
  		  			chargePerAmount: this.data.agent_tax,
  		  		});

  		  		for (var i = 0; i < this.data.itinerary.itinerary_additional.length; i++) {
  		  			this.pricing.push({
	  		  			type:this.data.itinerary.itinerary_additional[i].additional_id,
  		  				name:this.data.itinerary.itinerary_additional[i].additional.name,
	  		  			nominal:0,
	  		  			value: 0,
  		  				chargePerAmount: this.data.itinerary.itinerary_additional[i].additional.price,
	  		  		});
  		  		}


  		  		for (var i = 0; i < this.pricing.length; i++) {
  		  			for (var i1 = 0; i1 < this.room.type.length; i1++) {
		        		for (var i2 = 0; i2 < this.room.type[i1].length; i2++) {
		        			if (this.room.type[i1][i2] == this.pricing[i].type) {
		        				if (this.room.type[i1][i2] == 'Adult') {
		          		  			this.pricing[i].nominal += this.data.adult_price;
			        			}else if (this.room.type[i1][i2] == 'Child No Bed'){
		          		  				this.pricing[i].nominal += this.data.child_price;
			        			}else if (this.room.type[i1][i2] == 'Child With Bed'){
		          		  				this.pricing[i].nominal += this.data.child_bed_price;
			        			}else if (this.room.type[i1][i2] == 'Infant') {
		          		  			this.pricing[i].nominal += this.data.infant_price;
			        			}

	          		  			this.pricing[i].value += 1;
		        			}else if(this.pricing[i].type == 'Agent Com'){
		        				if (this.data.agent_com != 0) {
		        					this.pricing[i].value += 1;
	          		  				this.pricing[i].nominal += this.data.agent_com;
		        				}
		        			}else if(this.pricing[i].type == 'Staff Com'){
		        				if (this.data.staff_com != 0) {
		        					this.pricing[i].value += 1;
		          		  			this.pricing[i].nominal += this.data.staff_com;
		        				}
		        			}else if(this.pricing[i].type == 'Tips'){
	          		  			if (this.data.agent_tip != 0) {
		        					this.pricing[i].value += 1;
		          		  			this.pricing[i].nominal += this.data.agent_tip;
		        				}
		        			}else if(this.pricing[i].type == 'Visa'){
		        				if (this.data.agent_visa != 0) {
		        					this.pricing[i].value += 1;
		          		  			this.pricing[i].nominal += this.data.agent_visa;
		        				}
		        			}else if(this.pricing[i].type == 'Apt Tax And Surcharge'){
		        				if (this.data.agent_tax != 0) {
		        					this.pricing[i].value += 1;
		          		  			this.pricing[i].nominal += this.data.agent_tax;
		        				}
		        			}
		        		}
		        	}

		        	for (var i1 = 0; i1 < this.room.additional.length; i1++) {
	        			for (var i2 = 0; i2 < this.room.additional[i1].length; i2++) {
	        				for (var i3 = 0; i3 < this.room.additional[i1][i2].length; i3++) {
	        					if (this.pricing[i].type == this.room.additional[i1][i2][i3]) {
		        					for (var i4 = 0; i4 < this.data.itinerary.itinerary_additional.length; i4++) {
					  		  			if (this.room.additional[i1][i2][i3] == this.data.itinerary.itinerary_additional[i4].additional_id) {
			          		  				this.pricing[i].nominal += this.data.itinerary.itinerary_additional[i4].additional.price;
	          		  						this.pricing[i].value += 1;
					  		  			}
					  		  		}
		        				}
	        				}
	        			}
	        		}

	        		if (this.pricing[i].type == 'Agent Com' || this.pricing[i].type == 'Staff Com') {
		        		this.total -= this.pricing[i].nominal;
	        		}else{

		        		this.total += this.pricing[i].nominal;
	        		}
  		  		}


  		  		console.log(this.total);
	        },
			roomNameErrors(i,i1){
				const errors = []
		        if (!this.$v.room.name.$each[i].$each[i1].$dirty) return errors
		        !this.$v.room.name.$each[i].$each[i1].required && errors.push('Name is required.')
		        return errors
			},
			roomBirthDateErrors(i,i1){
				const errors = []
		        if (!this.$v.room.birth_date.$each[i].$each[i1].$dirty) return errors
		        !this.$v.room.birth_date.$each[i].$each[i1].required && errors.push('Birth Date is required.')
		        return errors
			},
			roomPassportErrors(i,i1){
				const errors = []
		        if (!this.$v.room.passport.$each[i].$each[i1].$dirty) return errors
		        !this.$v.room.passport.$each[i].$each[i1].required && errors.push('Passport is required.')
		        return errors
			},
			roomExpiredAtErrors(i,i1){
				const errors = []
		        if (!this.$v.room.expired_at.$each[i].$each[i1].$dirty) return errors
		        !this.$v.room.expired_at.$each[i].$each[i1].required && errors.push('Expired At is required.')
		        return errors
			},
			roomIssuingErrors(i,i1){
				const errors = []
		        if (!this.$v.room.issuing.$each[i].$each[i1].$dirty) return errors
		        !this.$v.room.issuing.$each[i].$each[i1].required && errors.push('Issuing is required.')
		        return errors
			},
			roomGenderErrors(i,i1){
				const errors = []
		        if (!this.$v.room.gender.$each[i].$each[i1].$dirty) return errors
		        !this.$v.room.gender.$each[i].$each[i1].required && errors.push('Gender is required.')
		        return errors
			},
			roomBirthPlaceErrors(i,i1){
				const errors = []
		        if (!this.$v.room.birth_place.$each[i].$each[i1].$dirty) return errors
		        !this.$v.room.birth_place.$each[i].$each[i1].required && errors.push('Birth Place is required.')
		        return errors
			},
			roomNoteErrors(i,i1){
				const errors = []
		        if (!this.$v.room.note.$each[i].$each[i1].$dirty) return errors
		        !this.$v.room.note.$each[i].$each[i1].required && errors.push('Note is required.')
		        return errors
			},
			roomNoteErrors(i,i1){
				const errors = []
		        if (!this.$v.room.note.$each[i].$each[i1].$dirty) return errors
		        !this.$v.room.note.$each[i].$each[i1].required && errors.push('Note is required.')
		        return errors
			},
			saveData(){
           	 	let formData = new FormData();
           	 	this.loadingProcess = true;
           	 	if (this.$v.$invalid) {
           	 		this.$v.$touch()
           	 		this.snackbar = true;
		            this.text = 'Please fill all requirement form';
           	 		this.color = 'warning';
           	 		this.loadingProcess = false;
        			return false;
        		}
           	 	console.log('tes');

      

	            formData.append('room',  JSON.stringify(this.room))

	            for (var i = 0; i < this.room.passport_image.length; i++) {
	            	for (var i1 = 0; i1 < this.room.passport_image[i].length; i1++) {
	            		formData.append('passport_image['+i+']['+i1+']', this.room.passport_image[i][i1]);
	            	}
	            }

	            formData.append('guest_leader', JSON.stringify(this.guest_leader))
	            formData.append('pricing', JSON.stringify(this.pricing))
	            formData.append('data', JSON.stringify(this.data))
	            formData.append('remark', this.remark)
	            formData.append('total', this.total)
	            formData.append('id_user', this.users_id)
	            formData.append('status',this.saveDataParam);
	            formData.append('id',this.$route.params.id);
	            formData.append('total_adult',this.total_adult);
	            formData.append('total_child',this.total_child);
	            formData.append('total_infant',this.total_infant);

	            axios.post('/api/booking-list/update',
	                    formData, {
	                        headers: {
	                            'Content-Type': 'multipart/form-data'
	                        }
	                    }
	                )
	                .then(response => {
		                this.snackbar = true;
		                this.text = response.data.message;
		                if (response.data.status == 1) {
		                    this.color = 'success'
		                    this.loadingProcess = false
		                    this.showModalProcess = false
		                } else {
		                    this.color = 'error'
		                }
	                })
	                .catch(error => {
		                this.snackbar = true;
		                this.text = error;
		                this.color = 'error'
		                this.loadingProcess = false
	                    this.showModalProcess = false
	                })
			}
		}
	}
</script>