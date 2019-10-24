<template>
  <div class="container">
    <div class="row justify-content-center" id="apps">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 style="margin-top: 10px;display: inline-block;"><b>Carousel</b></h5>
            <v-btn  color="warning pull-right" @click="$router.push({ name: 'Carousel' })">Back
              <v-icon dark right>fas fa-home</v-icon>
            </v-btn>
          </div>
          <div class="card-body">
            <v-layout wrap class="px-5 py-5">
              <v-flex xs12 style="padding: 10px" class="row">
                <div v-for="index in 3" class="col-sm-4">
                  <h5>Carousel {{ index }}</h5>
                  <vue-dropify :id="'carousel_'+index" :multiple="false" @change="changeImage('carousel',index)" ref="carousel" message="Upload Carousel By Click Here"></vue-dropify> 
                  <v-text-field label="Note" v-model="note[index-1]" required name="note[]" ></v-text-field>
                </div>
              </v-flex>
              <v-flex xs12>
                <v-btn color="blue darken-1 white--text" text @click="saveAndCloseDialog()">Save</v-btn>
              </v-flex>
            </v-layout>
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
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import { validationMixin } from 'vuelidate'
  import { required, maxLength, email } from 'vuelidate/lib/validators'
  import VueDropify from 'vue-dropify';
  import {VMoney} from 'v-money'
  export default {
      directives: {
          money: VMoney
      },
      mixins: [validationMixin],
      mounted() {
          console.log('Intialize Main Page...')
          let breadcrumb = '<router-link to="/carousel">Carousel</router-link>';
          $('#crumb').html(breadcrumb);
          axios
              .get('/api/get-token')
              .then(response => {
                  axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.access_token;
              })
              .catch(error => {
                  console.log(error)
                  this.errored = true
              })
              .finally(() => this.apiReady = true)
      },
      components: {
          'vue-dropify': VueDropify
      },
      data: () => ({
          snackbar: false,
          color: 'primary',
          mode: '',
          timeout: 3000,
          carousel: [],
          note: [],
          text: '',
          apiReady:false,
      }),
      watch:{
        apiReady(){
          if (this.apiReady == true) {
            this.callingApi();
          }
        }
      },
      methods: {
          callingApi() {
            axios.get('/api/carousel')
                .then(response => {
                    this.$refs.carousel[0].images.push(response.data.data.carousel_1);
                    this.$refs.carousel[1].images.push(response.data.data.carousel_2);
                    this.$refs.carousel[2].images.push(response.data.data.carousel_3);
                    this.note.push(response.data.data.note_1);
                    this.note.push(response.data.data.note_2);
                    this.note.push(response.data.data.note_3);
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => this.apiReady = true)
          },
          changeImage: function(param, index) {
              var input = $('#carousel_' + index).find('input');
              this.carousel[index - 1] = input[0].files[0];
          },
          saveAndCloseDialog() {

              let formData = new FormData();

              formData.append('id', this.id)
              for (var i = 0; i < this.note.length; i++) {
                  formData.append('note_' + [i + 1], this.note[i]);
              }

              for (var i = 0; i < this.carousel.length; i++) {
                  formData.append('carousel_' + [i + 1], this.carousel[i]);
              }

              axios.post('/api/carousel/save',
                      formData, {
                          headers: {
                              'Content-Type': 'multipart/form-data'
                          }
                      }
                  )
                  .then(response => {
                      this.dialogSave = false;
                      this.snackbar = true;
                      this.text = response.data.message;
                      if (response.data.status == 1) {
                          this.color = 'success';
                          this.text = response.data.message;
                      } else {
                          this.color = 'error'
                          this.text = response.data.message;
                      }

                      this.imageReady = false;
                  })
                  .catch(error => {
                      this.snackbar = true;
                      this.text = error;
                      this.errored = true
                  })
                  .finally(() => this.$emit('closeDialog', this.dialogs))

          },
      }
  }
</script>

<style type="text/css">
  .upload-btn-wrapper {
    position: relative;
    overflow: hidden;
    display: inline-block;
  }

  .btn {
    border: 2px solid gray;
    color: gray;
    background-color: white;
    padding: 8px 20px;
    border-radius: 8px;
    font-size: 20px;
    font-weight: bold;
  }

  .upload-btn-wrapper input[type=file] {
    font-size: 100px;
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
  }
</style>