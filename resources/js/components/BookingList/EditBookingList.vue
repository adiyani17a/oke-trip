<template>
	<div class="container">
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
				<v-btn color="success" @click="addRoom(room.bed.length)"><i class="fa fa-plus"></i>&nbsp;Room</v-btn>
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
									<v-checkbox v-model="room.additional[i][i1][i2]"  :label="additional.additional.name" :value="additional.additional.id"></v-checkbox>
								</div>
								<hr>
							</div>
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
	            total:3,
	            pricing:[],
	            formReady:false,
	            additional:[],
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
	            count:{
	            	adult:0,
	            	child:0,
	            	infant:0,
	            },
				apiReady:false,
				error:false,
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
			}
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
        		this.room.type[i].splice(0, 1,null);
        		this.room.additional[i].splice(0, 1,[]);
        		this.additional.forEach((d2,i2)=>{
    				this.room.additional[i][0].splice(i2, 1,0);
				});

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

        		console.log(this.room);
			},
			uploadImage(i,i1){
                var input = $('#passport_image_'+i+'_'+i1);
                this.room.passport_image[i][i1] = input[0].files[0];
                var image = window.URL.createObjectURL(this.room.passport_image[i][i1]);
                $('#passport_image_preview_'+i+'_'+i1).attr('src',image);
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
			}
		}
	}
</script>