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
                  <v-text-field label="Slug*" v-model="slug" required name="slug" @blur="$v.slug.$touch()" :error-messages="slugErrors"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field label="Icon*" v-model="icon" required name="icon" @blur="$v.icon.$touch()" :error-messages="iconErrors"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field label="Url*" v-model="url" required name="url" @blur="$v.url.$touch()" :error-messages="urlErrors"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-select
                    v-model="groupMenuId"
                    :items="options"
                    label="Group Menu*"
                    item-text="text"
                    item-value="value"
                    @blur="$v.groupMenuId.$touch()"
                    :error-messages="groupMenuErrors"
                  ></v-select>
                  <input type="hidden" v-model="groupMenuId" class="group_menu_id" name="group_menu_id">
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
      slug: '',
      icon: '',
      url: '',
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
      name: { required, maxLength: maxLength(20) },
      slug: { required },
      url: { required },
      groupMenuId: { required },
      icon: { required },
    },
    computed:{
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.maxLength && errors.push('Name must be at most 10 characters long')
        !this.$v.name.required && errors.push('Name is required.')
        return errors
      },
      slugErrors () {
        const errors = []
        if (!this.$v.slug.$dirty) return errors
        !this.$v.slug.required && errors.push('Slug is required.')
        return errors
      },
      urlErrors () {
        const errors = []
        if (!this.$v.url.$dirty) return errors
        !this.$v.url.required && errors.push('Url is required.')
        return errors
      },
      groupMenuErrors () {
        const errors = []
        if (!this.$v.groupMenuId.$dirty) return errors
        !this.$v.groupMenuId.required && errors.push('Group Menu is required.')
        return errors
      },
      iconErrors () {
        const errors = []
        !this.$v.icon.required && errors.push('Icon is required.')
        return errors
      },
    },
    props:{
      dialog: false,
      idData:Array,
      options:Array,
    },
    watch:{
      dialog:function(){
        this.dialogs = this.dialog
      },
      idData:function(){
        if (this.idData.length == 1) {
          this.id = this.idData[0].id
          this.name = this.idData[0].name
          this.slug = this.idData[0].slug
          this.url = this.idData[0].url
          this.groupMenuId = this.idData[0].group_menu_id
          this.icon = this.idData[0].icon
        }else{
          this.id = ''
          this.name = ''
          this.slug = ''
          this.url = ''
          this.groupMenuId = null
          this.icon = ''
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
            this.slug = this.idData[0].slug
            this.url = this.idData[0].url
            this.id = this.idData[0].id
            this.groupMenuId = this.idData[0].group_menu_id
            this.icon = this.idData[0].icon
          }else{
            this.name = ''
            this.slug = ''
            this.url = ''
            this.id = ''
            this.groupMenuId = null
            this.icon = ''
          }
        }else{
          this.$v.$touch()
          if (this.$v.$anyError == true) {
            return false;
          }

          axios
            .post('/api/menu-list/save',$('#saveData :input').serialize())
            .then(response => {
              this.snackbar =  true;
              this.text =  response.data.message;
              if (response.data.status == 1) {
                this.color = 'success'
                this.name = ''
                this.slug = ''
                this.url = ''
                this.groupMenuId = null
                this.id = ''
                this.icon = ''
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