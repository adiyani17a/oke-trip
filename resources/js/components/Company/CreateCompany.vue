<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialogs" persistent max-width="600px" style="z-index: 9999999999 !important;">
      <v-card>
        <v-card-title>
          <span class="headline">{{ this.$route.name }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <form id="saveData">
              <v-layout wrap>
                <v-flex xs12>
                  <v-text-field label="Name*" v-model="name" required name="name" @blur="$v.name.$touch()" :error-messages="nameErrors"></v-text-field>
                  <input type="hidden" name="id" v-model="id">
                </v-flex>
                <v-flex xs12>
                  <v-text-field label="Address*" v-model="address" required name="address" @blur="$v.address.$touch()" :error-messages="addressErrors"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field label="Phone*" v-model="phone"  required name="phone" @blur="$v.phone.$touch()" :error-messages="phoneErrors"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field label="Passport*" v-model="passport"  required name="passport" @blur="$v.passport.$touch()" :error-messages="passportErrors"></v-text-field>
                </v-flex>
                <v-flex xs12 style="padding: 10px">
                  <v-menu
                    v-model="menu1"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    full-width
                    min-width="1px"
                    >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="passportExpDate"
                        label="Passport Expired Date*"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                        @click="$v.passportExpDate.$touch()"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="passportExpDate" @input="menu1 = false"></v-date-picker>
                  </v-menu>
                </v-flex>
                <v-flex xs12>
                  <v-text-field label="Issuing*" v-model="issuing"  required name="issuing" @blur="$v.issuing.$touch()" :error-messages="issuingErrors"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-select
                    v-model="gender"
                    :items="genderOptions"
                    label="Gender*"
                    item-text="name"
                    item-value="value"
                    @blur="$v.gender.$touch()"
                    :error-messages="genderErrors"
                    ></v-select>
                </v-flex>
                <v-flex xs12 style="padding: 10px">
                  <v-menu
                    v-model="menu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    full-width
                    min-width="1px"
                    >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="birthDate"
                        label="Birth Date"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                        @click="$v.birthDate.$touch()"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="birthDate" @input="menu = false"></v-date-picker>
                  </v-menu>
                </v-flex>
                <v-flex xs12>
                  <v-text-field label="Birth Place*" v-model="birthPlace"  required name="birthPlace" @blur="$v.birthPlace.$touch()" :error-messages="birthPlaceErrors"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <vue-dropify id="image" ref="tes" @change="changeImage()"></vue-dropify>
                </v-flex>
              </v-layout>
            </form>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1 white--text" text @click="saveAndCloseDialog('close')">Close</v-btn>
          <v-btn color="blue darken-1 white--text" text @click="saveAndCloseDialog('save')">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
  </v-layout>
</template>
<script>
  import { required, maxLength, email } from 'vuelidate/lib/validators'
  import VueDropify from 'vue-dropify';
  export default {
    data: () => ({
      id: '',
      name: '',
      email: '',
      password: '',
      role: '',
      imageWidth:400,
      imageHeight:300,
      imageReady: false,
      dialogs:false,
      nameRules: [
        v => !!v || 'Name is required',
        v => v.length <= 20 || 'Name must be less than 10 characters'
      ],
      snackbar: false,
      color: 'success',
      mode: '',
      namaFitur: '',
      timeout: 6000,
      groupMenuId:null,
      name: '',
      address: '',
      phone: '',
      passport: '',
      passportExpDate: new Date().toISOString().substr(0, 10),
      issuing: '',
      gender: '',
      birthDate: new Date().toISOString().substr(0, 10),
      birthPlace: '',
      menu: false,
      menu1: false,
      image:[],
      genderOptions:[{
        name:'Male',
        value:'male',
      },{
        name:'Female',
        value:'female',
      }],
      text: 'Hello, I\'m a snackbar'
    }),
    validations: {
      name: { required },
      address: { required },
      phone: { required },
      passport: { required },
      passportExpDate: { required },
      issuing: { required },
      gender: { required },
      birthDate: { required },
      birthPlace: { required },
    },
    computed:{
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.required && errors.push('Name is required.')
        return errors
      },
      addressErrors () {
        const errors = []
        if (!this.$v.address.$dirty) return errors
        !this.$v.address.required && errors.push('Address is required.')
        return errors
      },
      phoneErrors () {
        const errors = []
        if (!this.$v.phone.$dirty) return errors
        !this.$v.phone.required && errors.push('Phone is required.')
        return errors
      },
      passportErrors () {
        const errors = []
        if (!this.$v.passport.$dirty) return errors
        !this.$v.passport.required && errors.push('Passport is required.')
        return errors
      },
      passportExpDateErrors () {
        const errors = []
        if (!this.$v.passportExpDate.$dirty) return errors
        !this.$v.passportExpDate.required && errors.push('Passport Expired Date is required.')
        return errors
      },
      issuingErrors () {
        const errors = []
        if (!this.$v.issuing.$dirty) return errors
        !this.$v.issuing.required && errors.push('Issuing is required.')
        return errors
      },
      genderErrors () {
        const errors = []
        if (!this.$v.gender.$dirty) return errors
        !this.$v.gender.required && errors.push('Gender is required.')
        return errors
      },
      birthDateErrors () {
        const errors = []
        if (!this.$v.birthDate.$dirty) return errors
        !this.$v.birthDate.required && errors.push('Birth date is required.')
        return errors
      },
      birthPlaceErrors () {
        const errors = []
        if (!this.$v.birthPlace.$dirty) return errors
        !this.$v.birthPlace.required && errors.push('Birth place is required.')
        return errors
      },
    },
    props:{
      dialog: false,
      idData:Array,
      options:Array,
    },
    components: {
      'vue-dropify': VueDropify
    },
    watch:{
      dialog:function(){
        this.dialogs = this.dialog
        this.imageReady = true;
      },
      idData:function(){
        this.removeOrAdd();
      }
    },
    methods:{
      removeOrAdd(){
        if (this.idData.length != 0) {
            this.id = this.idData[0].id
            this.name = this.idData[0].name
            this.address = this.idData[0].address
            this.phone = this.idData[0].phone
            this.passport = this.idData[0].passport
            this.passportExpDate = this.idData[0].passport_exp_date
            this.issuing = this.idData[0].issuing
            this.gender = this.idData[0].gender
            this.birthDate = this.idData[0].birth_date
            this.birthPlace = this.idData[0].birth_place
            let feature = 'tour-leader';
            axios
                .get('/api/convert-image-base-64?id=' + this.id + '&feature=' + feature)
                .then(response => {
                    this.$refs.tes.images = [];

                    this.$refs.tes.images.push(response.data);
                })
                .catch(error => {
                    console.log(error);
                })
        } else {
            this.id = '';
            this.name = ''
            this.address = ''
            this.phone = ''
            this.passport = ''
            this.passportExpDate = new Date().toISOString().substr(0, 10)
            this.issuing = ''
            this.gender = ''
            this.birthDate = new Date().toISOString().substr(0, 10)
            this.birthPlace = ''
            this.$refs.tes.images = [];
        }
      },
      saveAndCloseDialog(param){
        if (param == 'close') {
          this.dialogs = false;
          this.$emit('closeDialog',this.dialogs)
          
        }else{
          this.$v.$touch()
          if (this.$v.$anyError == true) {
            return false;
          }

          let formData = new FormData();
          formData.append('id',this.id)
          formData.append('name',this.name)
          formData.append('address',this.address)
          formData.append('phone',this.phone)
          formData.append('passport',this.passport)
          formData.append('passport_exp_date',this.passportExpDate)
          formData.append('issuing',this.issuing)
          formData.append('gender',this.gender)
          formData.append('birth_date',this.birthDate)
          formData.append('birth_place',this.birthPlace)
          formData.append('image',this.image)
          axios.post( '/api/tour-leader/save',
              formData,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              }
            )
            .then(response => {
              this.snackbar =  true;
              this.text =  response.data.message;
              if (response.data.status == 1) {
                this.color = 'success'
                this.removeOrAdd();
              }else{
                this.color = 'error'
              }
              this.imageReady = false;
              console.log(this.$refs.tes)
            })
            .catch(error => {
              console.log(error)
              this.snackbar =  true;
              this.text =  error;
              this.errored = true
            })
            .finally(() => this.$emit('closeDialog',this.dialogs))
        }
      },
      changeImage(){
        var input =  $('#image').find('input');
        this.image = input[0].files[0];  
      }
    }
  }
</script>