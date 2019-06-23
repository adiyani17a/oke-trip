<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialogs" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Destination</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12>
                <v-text-field label="Name" v-model="name" required :counter="20" @blur="$v.name.$touch()" :error-messages="nameErrors"></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-textarea
                  name="input-7-1"
                  label="Note"
                  v-model="note"
                ></v-textarea>
              </v-flex>
            </v-layout>
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
  </v-layout>
</template>
<script>

  import { required, maxLength, email } from 'vuelidate/lib/validators'
  export default {
    data: () => ({
      name: '',
      note: '',
      dialogs:false,
      nameRules: [
        v => !!v || 'Name is required',
        v => v.length <= 20 || 'Name must be less than 10 characters'
      ],
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
    },
    watch:{
      dialog:function(){
        this.dialogs = this.dialog
      }
    },
    methods:{
      saveAndCloseDialog(param){
        if (param == 'close') {
          this.dialogs = false;
          this.$emit('closeDialog',this.dialogs)
        }else{
          this.$v.$touch()
          if (this.$v.$anyError == true) {
            return false;
          }
          this.$emit('closeDialog',this.dialogs)
        }
      }
    }
  }
</script>