<template>
<div class="container" >
  <div class="row justify-content-center" id="apps">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 style="margin-top: 10px;display: inline-block;"><b>Create Itinerary</b></h5>
        </div>
        <div class="card-body">
          <form-wizard title="" subtitle="">
            <tab-content title="Form Data">
              <v-layout wrap>
                <v-flex xs6 style="padding: 10px">
                  <v-text-field label="Code Tour" v-model="code" readonly required name="code" ></v-text-field>
                  <input type="hidden" name="id" v-model="id">
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-text-field label="Name*" v-model="name" required name="name" @blur="$v.name.$touch()" :error-messages="nameErrors"></v-text-field>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-select
                    v-model="destination"
                    label="Destination*"
                    item-text="text"
                    item-value="value"
                    @blur="$v.destination.$touch()"
                  ></v-select>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-select
                    v-model="additional"
                    label="Additional*"
                    item-text="text"
                    item-value="value"
                    @blur="$v.additional.$touch()"
                  ></v-select>
                </v-flex>
                <v-flex xs12 style="padding: 10px">
                  <text-editor @textContent="textContent"></text-editor>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <h5>Photo</h5>
                  <vue-dropify message="Upload Image By Click Here"></vue-dropify> 
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <h5>Upload PDF</h5>
                  <vue-dropify message="Upload PDF By Click Here"></vue-dropify> 
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <h5>Carousel</h5>
                  <vue-dropify message="Upload Carousel By Click Here"></vue-dropify> 
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <h5>Flyer</h5>
                  <vue-dropify message="Upload Flyer By Click Here"></vue-dropify> 
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <h5>Add Detail Schedule</h5>
                  <div v-for="index in addDetailSchedule">
                    <v-layout wrap border style="padding: 10px">
                      <v-flex xs2 class="text-center">
                        <v-chip color="primary" class="white--text" >Day {{index}}</v-chip>
                        <v-btn v-if="index == addDetailSchedule" small  class="mx-1" fab dark color="primary" @click="addSchedule">
                          <v-icon dark>add</v-icon>
                        </v-btn>
                        <v-btn v-if="index == addDetailSchedule" small  class="mx-1" fab dark color="red" @click="removeSchedule">
                          <v-icon dark>remove</v-icon>
                        </v-btn>
                      </v-flex>
                      <v-flex xs4 class="pa-2">
                        <v-text-field label="Caption"></v-text-field>
                        <v-text-field label="B/L/D"></v-text-field>
                      </v-flex>
                      <v-flex xs6>
                        <v-textarea auto-grow label="Caption"></v-textarea>
                      </v-flex>
                    </v-layout>
                  </div>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <h5>Add Flight Detail</h5>
                  <div v-for="index in addFlightDetail">
                    <v-layout wrap border style="padding: 10px">
                      <v-flex xs4 class="text-center pa-2" >
                        <v-text-field label="No Flight"></v-text-field>
                      </v-flex>
                      <v-flex xs4 class="text-center pa-2">
                        <v-text-field label="B/L/D"></v-text-field>
                        <v-btn v-if="index == addFlightDetail" small  class="mx-1" fab dark color="primary" @click="addFlight">
                          <v-icon dark>add</v-icon>
                        </v-btn>
                        <v-btn v-if="index == addFlightDetail" small  class="mx-1" fab dark color="red" @click="removeFlight">
                          <v-icon dark>remove</v-icon>
                        </v-btn>
                      </v-flex>
                      <v-flex xs4 class="text-center pa-2">
                        <v-text-field label="Time Departure"></v-text-field>
                        <v-text-field label="Time Arrival"></v-text-field>
                      </v-flex>
                    </v-layout>
                  </div>
                </v-flex>
              </v-layout>
            </tab-content>
            <tab-content title="Form Detail">
              <v-layout wrap>
                <v-flex xs6 style="padding: 10px" class="px-12">
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
                        v-model="dateStart"
                        label="Date Start"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="dateStart" @input="menu = false"></v-date-picker>
                  </v-menu>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
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
                        v-model="dateEnd"
                        label="Date End"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="dateEnd" @input="menu1 = false"></v-date-picker>
                  </v-menu>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-text-field label="Adult Price" v-money="money" v-model="adultPrice"  required name="adultPrice" ></v-text-field>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-text-field label="Child No Bed Price" v-money="money" v-model="CnBPrice"  required name="CnBPrice" ></v-text-field>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-text-field label="Child With Bed Price" v-money="money" v-model="CwBPrice"  required name="CwBPrice" ></v-text-field>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-text-field label="Infant Price" v-money="money" v-model="infantPrice"  required name="infantPrice" ></v-text-field>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-text-field label="Agent Com Price" v-money="money" v-model="agentPrice"  required name="agentPrice" ></v-text-field>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-text-field label="Tips Price" v-money="money" v-model="tipsPrice"  required name="tipsPrice" ></v-text-field>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-text-field label="Visa Price" v-money="money" v-model="visaPrice"  required name="visaPrice" ></v-text-field>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-text-field label="Apt Tax & Fuel Surcharge" v-money="money" v-model="aptPrice"  required name="aptPrice" ></v-text-field>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-text-field label="Seat" v-model="seat"  required name="seat" type="number" ></v-text-field>
                </v-flex>
                <v-flex xs6 style="padding: 10px">
                  <v-btn
                    :loading="loading"
                    :disabled="loading"
                    color="primary"
                    class="ma-2 white--text"
                    @click="loader = 'loading'"
                  >
                    Append
                    <v-icon right dark>check_circle</v-icon>
                  </v-btn>
                </v-flex>
                <v-flex xs12 style="padding: 10px">
                  <v-data-table
                    :headers="itineraryHeaders"
                    :items="itineraryItems"
                    class="elevation-1"
                  >
                    <template v-slot:items="props">
                      <td>{{ props.item.name }}</td>
                      <td class="text-xs-right">{{ props.item.calories }}</td>
                      <td class="text-xs-right">{{ props.item.fat }}</td>
                      <td class="text-xs-right">{{ props.item.carbs }}</td>
                      <td class="text-xs-right">{{ props.item.protein }}</td>
                      <td class="text-xs-right">{{ props.item.iron }}</td>
                    </template>
                  </v-data-table>
                </v-flex>
              </v-layout>
            </tab-content>
            <tab-content title="Finish">
            Yuhuuu! This seems pretty damn simple
            </tab-content>
          </form-wizard>
        </div>
      </div>
    </div>
  </div>
</div>
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
          let breadcrumb = 'Itinerary <router-link to="/additional">/ Create</router-link>';
          $('#crumb').html(breadcrumb);
          let accounting = document.createElement('script')
          accounting.setAttribute('src', '/js/accounting/accounting.js')
          document.head.appendChild(accounting)
      },
      data: () => ({
        addDetailSchedule : 1,
        addFlightDetail : 1,
        code:'Tes',
        id:'1',
        name:'',
        dateStart:'',
        money: {
          decimal: '.',
          thousands: ',',
          precision: 0,
          masked: false /* doesn't work with directive */
        },
        adultPrice:'',
        minimalDP:'',
        CnBPrice:'',
        CwBPrice:'',
        infantPrice:'',
        agentPrice:'',
        tipsPrice:'',
        visaPrice:'',
        aptPrice:'',
        seat:'',
        dateStart: new Date().toISOString().substr(0, 10),
        dateEnd: new Date().toISOString().substr(0, 10),
        menu: false,
        menu1: false,
        loader: null,
        loading: false,
        itineraryItem:[],
        itineraryHeaders: [
          { text: 'Start Date', value: 'start_date' },
          { text: 'End Date', value: 'end_date' },
          { text: 'Adult Price', value: 'adult_price' },
          { text: 'CnB Price', value: 'cnb_price' },
          { text: 'CwB Price', value: 'cwb_price' },
          { text: 'Infant Price', value: 'infant_price' },
          { text: 'Minimal DP', value: 'minimal_dp' },
          { text: 'Agent Com', value: 'agent_com' },
          { text: 'Tips', value: 'tips' },
          { text: 'Apt Tax', value: 'apt_tax' },
          { text: 'Seat', value: 'seat' },
          { text: 'Action', value: 'action' },
        ],
        itineraryItems: [],
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
          },
          loader () {
            const l = this.loader
            this[l] = !this[l]

            setTimeout(() => (this[l] = false), 3000)

            this.loader = null
          },
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
          },
          textContent(content){
            this.term = content;
            console.log(this.term)
          },
          addSchedule(){
            this.addDetailSchedule++;
            console.log(this.addDetailSchedule)
          },
          removeSchedule(){
            if (this.addDetailSchedule != 1) {
              this.addDetailSchedule--;
            }
          },
          addFlight(){
            this.addFlightDetail++;
            console.log(this.addFlightDetail)
          },
          removeFlight(){
            if (this.addFlightDetail != 1) {
              this.addFlightDetail--;
            }
          }
      }
  }
</script>

<style>
  .custom-loader {
    animation: loader 1s infinite;
    display: flex;
  }
  @-moz-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @-webkit-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @-o-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
</style>