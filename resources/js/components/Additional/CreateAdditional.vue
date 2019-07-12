<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialogs" persistent max-width="600px">
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
                  <v-text-field ref="price" label="Price*" v-model="price" required name="price" @blur="$v.price.$touch()" :error-messages="priceErrors" v-money="money" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-textarea
                    name="note"
                    label="Note"
                    v-model="note"
                  ></v-textarea>
                </v-flex>
                <v-flex xs12>
                  <vue-dropify ref="tes"></vue-dropify>
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
  import {VMoney} from 'v-money'
  export default {
  	directives: {money: VMoney},
  	mounted(){
  		let accounting = document.createElement('script')
    	accounting.setAttribute('src', './js/accounting/accounting.js')
    	document.head.appendChild(accounting)
  },
    data: () => ({
      id: '',
      name: '',
      price: '',
      note: '',
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
      text: 'Hello, I\'m a snackbar',
      money: {
        decimal: '.',
        thousands: ',',
        precision: 0,
        masked: false /* doesn't work with directive */
      }
    }),
    validations: {
      name: { required },
      price: { required },
    },
    computed:{
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.required && errors.push('Name is required.')
        return errors
      },
      priceErrors () {
        const errors = []
        if (!this.$v.price.$dirty) return errors
        !this.$v.price.required && errors.push('price is required.')
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
        if (this.idData.length == 1) {
          this.id = this.idData[0].id
          this.name = this.idData[0].name
          this.$refs.price.$el.getElementsByTagName('input')[0].value = accounting.formatNumber(this.idData[0].price);
          this.price = accounting.formatNumber(this.idData[0].price)
          this.note = this.idData[0].note
        }else{
          this.id =  '';
          this.name =  '';
          this.price =  '';
          this.note =  '';
        }    
      },
      price:function(){
      	console.log(this.price)
      }
    },
    methods:{
      saveAndCloseDialog(param){
        if (param == 'close') {
          this.dialogs = false;
          this.$emit('closeDialog',this.dialogs)
          if (this.idData.length != 0) {
            this.id = this.idData[0].id
						this.name = this.idData[0].name
						this.$refs.price.$el.getElementsByTagName('input')[0].value = 0;
						this.price = this.idData[0].price
						this.note = this.idData[0].note
          }else{
						this.id =  '';
						this.name =  '';
						this.price =  '';
						this.note =  '';
          }
        }else{
          this.$v.$touch()
          if (this.$v.$anyError == true) {
            return false;
          }

          let formData = new FormData();

          formData.append('id',this.id)
          formData.append('name',this.name)
          formData.append('price',this.price.replace(/[^0-9\-]+/g,""))
          formData.append('note',this.note)
          formData.append('gambar',this.$refs.tes.images)
          axios.post( '/api/additional/save',
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
                this.id =  '';
								this.name =  '';
								this.$refs.price.$el.getElementsByTagName('input')[0].value = 0;
								this.price =  '';
								this.note =  '';
                this.imageData =  null;
                this.$refs.tes.images = [];
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
      }
    }
  }
</script>