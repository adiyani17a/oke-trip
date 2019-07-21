<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialogs" hide-overlay transition="dialog-bottom-transition" fullscreen>
      <v-card>
        <v-card-title>
          <span class="headline">{{ this.$route.name }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <form id="saveData">
              <v-layout wrap>
                <v-flex xs6>
                  <v-text-field label="Code Tour*" v-model="code" required name="code" readonly></v-text-field>
                  <input type="hidden" name="id" v-model="id">
                </v-flex>
                <v-flex xs6>
                  <v-text-field label="Name*" v-model="name" required name="name" @blur="$v.name.$touch()" :error-messages="nameErrors"></v-text-field>
                </v-flex>
                <v-flex xs6>
                  <v-select
                    v-model="destination_id"
                    :items="destination"
                    label="Destination*"
                    item-text="text"
                    item-value="value"
                    @blur="$v.destination.$touch()"
                    :error-messages="destinationErrors"
                  ></v-select>
                </v-flex>
                <v-flex xs6>
                  <v-select
                    v-model="additional_id"
                    :items="additional"
                    label="Additional"
                    item-text="text"
                    item-value="value"
                  ></v-select>
                </v-flex>
                <v-flex xs6>
                  <v-text-field label="Flight By*" v-model="flightBy" required name="flight_by" @blur="$v.flightBy.$touch()" :error-messages="flightByErrors"></v-text-field>
                </v-flex>
                <v-flex xs6>
                  <v-textarea
                    name="highlight"
                    label="Highlight"
                    v-model="highLight"
                  ></v-textarea>
                </v-flex>
                <v-flex xs12>
                  <text-editor @textContent="textContent"></text-editor>
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
  Vue.component('text-editor', require('../textEditor.vue').default)

  export default {
      directives: {
          money: VMoney
      },
      mounted() {
          let accounting = document.createElement('script')
          accounting.setAttribute('src', './js/accounting/accounting.js')
          document.head.appendChild(accounting)
      },
      data: () => ({
          code: 'tes',
          id: '',
          name: '',
          destination_id: '',
          additional_id: '',
          flightBy: '',
          highLight: '',
          term: '',
          imageWidth: 400,
          imageHeight: 300,
          imageReady: false,
          dialogs: false,
          snackbar: false,
          color: 'success',
          mode: '',
          namaFitur: '',
          timeout: 6000,
          groupMenuId: null,
          text: 'Hello, I\'m a snackbar',
          money: {
              decimal: '.',
              thousands: ',',
              precision: 0,
              masked: false /* doesn't work with directive */
          }
      }),
      validations: {
          name: {
              required
          },
          price: {
              required
          },
          destination: {
              required
          },
          flightBy: {
              required
          },
      },
      computed: {
          nameErrors() {
              const errors = []
              if (!this.$v.name.$dirty) return errors
              !this.$v.name.required && errors.push('Name is required.')
              return errors
          },
          priceErrors() {
              const errors = []
              if (!this.$v.price.$dirty) return errors
              !this.$v.price.required && errors.push('price is required.')
              return errors
          },
          destinationErrors() {
              const errors = []
              if (!this.$v.destination.$dirty) return errors
              !this.$v.destination.required && errors.push('Destination is required.')
              return errors
          },
          flightByErrors() {
              const errors = []
              if (!this.$v.flightBy.$dirty) return errors
              !this.$v.flightBy.required && errors.push('Flight By is required.')
              return errors
          },
      },
      props: {
          dialog: false,
          idData: Array,
          destination: Array,
          additional: Array,
      },
      components: {
          'vue-dropify': VueDropify
      },
      watch: {
          dialog: function() {
              this.dialogs = this.dialog
              this.imageReady = true;
          },
          idData: function() {
              if (this.idData.length == 1) {
                  this.id = this.idData[0].id
                  this.name = this.idData[0].name
                  this.$refs.price.$el.getElementsByTagName('input')[0].value = accounting.formatNumber(this.idData[0].price);
                  this.price = accounting.formatNumber(this.idData[0].price)
                  this.note = this.idData[0].note
              } else {
                  this.id = '';
                  this.name = '';
                  this.price = '';
                  this.note = '';
              }
          }
      },
      methods: {
          saveAndCloseDialog(param) {
              if (param == 'close') {
                  this.dialogs = false;
                  this.$emit('closeDialog', this.dialogs)
                  if (this.idData.length != 0) {
                      this.id = this.idData[0].id
                      this.name = this.idData[0].name
                      this.$refs.price.$el.getElementsByTagName('input')[0].value = 0;
                      this.price = this.idData[0].price
                      this.note = this.idData[0].note
                  } else {
                      this.id = '';
                      this.name = '';
                      this.price = '';
                      this.note = '';
                  }
              } else {
                  this.$v.$touch()
                  if (this.$v.$anyError == true) {
                      return false;
                  }

                  let formData = new FormData();

                  formData.append('id', this.id)
                  formData.append('name', this.name)
                  formData.append('price', this.price.replace(/[^0-9\-]+/g, ""))
                  formData.append('note', this.note)
                  formData.append('gambar', this.$refs.tes.images)
                  axios.post('/api/additional/save',
                          formData, {
                              headers: {
                                  'Content-Type': 'multipart/form-data'
                              }
                          }
                      )
                      .then(response => {
                          this.snackbar = true;
                          this.text = response.data.message;
                          if (response.data.status == 1) {
                              this.color = 'success'
                              this.id = '';
                              this.name = '';
                              this.$refs.price.$el.getElementsByTagName('input')[0].value = 0;
                              this.price = '';
                              this.note = '';
                              this.imageData = null;
                              this.$refs.tes.images = [];
                          } else {
                              this.color = 'error'
                          }
                          this.imageReady = false;
                      })
                      .catch(error => {
                          console.log(error)
                          this.snackbar = true;
                          this.text = error;
                          this.errored = true
                      })
                      .finally(() => this.$emit('closeDialog', this.dialogs))
              }
          },textContent(content){
            this.term = content;
            console.log(this.term)
          }
      }
  }
</script>