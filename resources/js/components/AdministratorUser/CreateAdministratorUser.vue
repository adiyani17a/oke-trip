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
                  <v-text-field label="Email*" v-model="email" required name="email" @blur="$v.email.$touch()" :error-messages="emailErrors"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field label="Password*" v-model="password"  required name="password" @blur="$v.password.$touch()" :error-messages="passwordErrors"></v-text-field>
                </v-flex>
                <v-flex xs12 :if="imageReady == true">
                  <v-select
                    v-model="role"
                    :items="options"
                    label="Role*"
                    item-text="text"
                    item-value="value"
                    @blur="$v.role.$touch()"
                    :error-messages="roleErrors"
                  ></v-select>
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
      text: 'Hello, I\'m a snackbar'
    }),
    validations: {
      name: { required },
      email: { required, email },
      password: { required },
      role: { required },
    },
    computed:{
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.required && errors.push('Name is required.')
        return errors
      },
      emailErrors () {
        const errors = []
        if (!this.$v.email.$dirty) return errors
        !this.$v.email.email && errors.push('Must be valid e-mail')
        !this.$v.email.required && errors.push('Email is required.')
        return errors
      },
      passwordErrors () {
        const errors = []
        if (!this.$v.password.$dirty) return errors
        !this.$v.password.required && errors.push('Password is required.')
        return errors
      },
      roleErrors () {
        const errors = []
        if (!this.$v.role.$dirty) return errors
        !this.$v.role.required && errors.push('Role is required.')
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
          this.email = this.idData[0].email
          this.role = this.idData[0].role_id
          this.password =  this.idData[0].password;
          this.imageData = this.idData[0].image;
          let feature ='administrator-user';
          axios
            .get('/api/convert-image-base-64?id='+this.id+'&feature='+feature)
            .then(response => {
                this.$refs.tes.images = [];

                this.$refs.tes.images.push(response.data) ;
            })
            .catch(error => {
                console.log(error);
            })
        }else{
          this.id =  '';
          this.name =  '';
          this.email =  '';
          this.role =  '';
          this.imageData =  '';
          this.password =  '';
        }    
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
            this.email = this.idData[0].email
            this.role = this.idData[0].role_id
            this.password =  this.idData[0].password;
            this.imageData = this.idData[0].image;
          }else{
            this.id =  '';
            this.name =  '';
            this.email =  '';
            this.password =  '';
            this.role =  null;
            this.imageData =  '';
          }
        }else{
          this.$v.$touch()
          if (this.$v.$anyError == true) {
            return false;
          }

          let formData = new FormData();
          console.log(this.$refs.tes);
          return false;
          formData.append('id',this.id)
          formData.append('name',this.name)
          formData.append('email',this.email)
          formData.append('password',this.password)
          formData.append('role_id',this.role)
          formData.append('gambar',this.$refs.tes.images)
          axios.post( '/api/administrator-user/save',
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
                this.email =  '';
                this.role =  null;
                this.imageData =  null;
                this.$refs.tes.images = [];
                this.password =  '';
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