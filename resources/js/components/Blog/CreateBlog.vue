<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialogs" persistent max-width="600px" style="z-index: 99999999999999999999999999 !important;">
      <v-card>
        <v-card-title>
          <span class="headline">{{ this.$route.name }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <form id="saveData">
              <v-layout wrap>
                <v-flex xs12>
                  <vue-dropify id="image" ref="tes" @change="changeImage()"></vue-dropify>
                  <input type="hidden" name="id" v-model="id">
                </v-flex>
                <v-flex xs12>
                  <v-text-field label="Head Line*" v-model="headLine" required name="headLine" @blur="$v.headLine.$touch()" :error-messages="headLineErrors"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field label="Summary*" :counter="200" maxlength="200" v-model="summary" required name="summary" @blur="$v.summary.$touch()" :error-messages="summaryErrors"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <text-editor :contentModel="contentModel" contentName="Blog" @textContent="textContent"></text-editor>
                </v-flex>
                <v-flex xs12>
                </v-flex>
              </v-layout>
            </form>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1 white--text" v-if="!loading" text @click="saveAndCloseDialog('close')">Close</v-btn>
          <v-btn color="blue darken-1 white--text" v-if="!loading" text @click="saveAndCloseDialog('save')">Save</v-btn>
          <v-btn color="blue darken-1 white--text" v-if="loading"><i class="fa fa-spinner fa-spin"></i></v-btn>
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
      image: '',
      content: '',
      headLine: '',
      summary: '',
      imageWidth:400,
      imageHeight:300,
      imageReady: false,
      contentModel:'',
      dialogs:false,
      loading:false,
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
      image: { required },
      content: { required },
      headLine: { required },
      summary: { required },
    },
    computed:{
      imageErrors () {
        const errors = []
        if (!this.$v.image.$dirty) return errors
        !this.$v.image.required && errors.push('Image is required.')
        return errors
      },
      contentErrors () {
        const errors = []
        if (!this.$v.content.$dirty) return errors
        !this.$v.content.required && errors.push('Content is required.')
        return errors
      },
      headLineErrors () {
        const errors = []
        if (!this.$v.headLine.$dirty) return errors
        !this.$v.headLine.required && errors.push('Head Line is required.')
        return errors
      },
      summaryErrors () {
        const errors = []
        if (!this.$v.summary.$dirty) return errors
        !this.$v.summary.required && errors.push('Summary is required.')
        return errors
      },
    },
    props:{
      dialog: false,
      idData:Array,
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
            this.image = this.idData[0].image
            this.content = this.idData[0].content
            this.contentModel = this.idData[0].content
            this.summary = this.idData[0].summary

            this.headLine = this.idData[0].head_line
            let feature = 'blog';
            axios.get('/api/convert-image-base-64?id=' + this.id + '&feature=' + feature)
                .then(response => {
                    this.$refs.tes.images = [];

                    this.$refs.tes.images.push(response.data);
                })
                .catch(error => {
                    console.log(error);
                })
        } else {
            this.id = '';
            this.image = '';
            this.content = '';
            this.contentModel='';
            this.headLine = '';
            this.$refs.tes.images = [];
            this.summary = '';
        }
      },
      saveAndCloseDialog(param){
        if (param == 'close') {
          this.dialogs = false;
          this.$emit('closeDialog',this.dialogs)
        }else{
          this.loading = true;
          this.$v.$touch()
          if (this.$v.$anyError == true) {
            return false;
        }

          let formData = new FormData();
          formData.append('id',this.id)
          formData.append('head_line',this.headLine)
          formData.append('content',this.content)
          formData.append('image',this.image)
          formData.append('summary',this.summary)
          axios.post( '/api/blog/save',
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
              this.loading = false;
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
      },
      textContent(content){
        this.content = content;
      }
    }
  }
</script>