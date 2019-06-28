<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialogs" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Group Menu</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <form id="saveData">
              <v-layout wrap>
                <v-flex xs12>
                  <v-text-field label="Name" v-model="name" required :counter="20" name="name" @blur="$v.name.$touch()" :error-messages="nameErrors"></v-text-field>
                  <input type="hidden" name="id" v-model="id">
                </v-flex>
                <v-flex xs12>
                  <v-textarea
                    name="note"
                    label="Note"
                    v-model="note"
                  ></v-textarea>
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
  export default {
    data: () => ({
      id: '',
      name: '',
      note: '',
      dialogs:false,
      nameRules: [
        v => !!v || 'Name is required',
        v => v.length <= 20 || 'Name must be less than 10 characters'
      ],
      snackbar: false,
      color: 'success',
      mode: '',
      timeout: 6000,
      text: 'Hello, I\'m a snackbar'
    }),
    validations: {
      name: { required, maxLength: maxLength(20) },
    },
    computed:{
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.maxLength && errors.push('Name must be at most 10 characters long')
        !this.$v.name.required && errors.push('Name is required.')
        return errors
      },
    },
    props:{
      dialog: false,
      idData:Array,
    },
    watch:{
      dialog:function(){
        this.dialogs = this.dialog
      },
      idData:function(){
        if (this.idData.length == 1) {
          this.id = this.idData[0].id
          this.name = this.idData[0].name
          this.note = this.idData[0].note
        }else{
          this.id = ''
          this.name = ''
          this.note = ''
        }
      }
    },
    methods:{
      saveAndCloseDialog(param){
        if (param == 'close') {
          this.dialogs = false;
          this.$emit('closeDialog',this.dialogs)
          if (this.idData.length != 0) {
            this.name = this.idData[0].name
            this.note = this.idData[0].note
            this.id = this.idData[0].id
          }else{
            this.name = ''
            this.note = ''
            this.id = ''
          }
          
        }else{
          this.$v.$touch()
          if (this.$v.$anyError == true) {
            return false;
          }

          axios
            .post('/api/destination/save',$('#saveData').serialize())
            .then(response => {
              this.snackbar =  true;
              this.text =  response.data.message;
              if (response.data.status == 1) {
                this.color = 'success'
                this.name = ''
                this.note = ''
                this.id = ''
              }else{
                this.color = 'error'
              }
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