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
                  <v-text-field label="Email*" v-model="email"  required name="email" @blur="$v.email.$touch()" :error-messages="emailErrors"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-autocomplete
                    v-model="city_id"
                    :items="cityOptions"
                    item-text="name"
                    label="City*"
                    item-value="value"
                  >
                  </v-autocomplete>
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
      address: '',
      phone: '',
      city_id: '',
      menu: false,
      menu1: false,
      placeholderCity:'Select City',
      image:[],
      text: 'Hello, I\'m a snackbar'
    }),
    validations: {
      name: { required },
      address: { required },
      phone: { required },
      email: { required,email },
      city_id: { required },
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
      emailErrors () {
        const errors = []
        if (!this.$v.email.$dirty) return errors
        !this.$v.email.email && errors.push('Must be valid e-mail')
        !this.$v.email.required && errors.push('Email is required.')
        return errors
      },
      cityErrors () {
        const errors = []
        if (!this.$v.city_id.$dirty) return errors
          this.placeholderCity = 'City is required'
        !this.$v.city_id.required && errors.push('City is required.') 
        return errors
      }
    },
    props:{
      dialog: false,
      idData:Array,
      cityOptions:Array,
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
            this.email = this.idData[0].email
            this.city_id = this.idData[0].city_id
            let feature = 'company';
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
            this.email = ''
            this.city_id = '';
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
          formData.append('email',this.email)
          formData.append('city_id',this.city_id)
          formData.append('image',this.image)
          axios.post( '/api/company/save',
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