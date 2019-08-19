<template>
<div class="container" >
  <div class="row justify-content-center" id="apps">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 style="margin-top: 10px;display: inline-block;"><b>Create Itinerary</b></h5>
        </div>
        <div class="card-body">
          <form-wizard title="" subtitle="" @on-loading="setLoading" color="#007bff" error-color="red" finish-button-text="Save" @on-complete="onComplete">
            <tab-content title="Form Data" :before-change="beforeChange">
              <v-layout wrap>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Code Tour" v-model="form.code" readonly required name="code" ></v-text-field>
                  <input type="hidden" name="id" v-model="id">
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Name*" v-model="form.name" required name="name" @blur="$v.form.name.$touch()" :error-messages="nameErrors"></v-text-field>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-select
                    v-model="form.destination"
                    label="Destination*"
                    :items="destinationOptions"
                    item-text="name"
                    item-value="id"
                    multiple
                    @blur="$v.form.destination.$touch()"
                    :error-messages="destinationErrors"
                  ></v-select>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-select
                    v-model="form.additional"
                    label="Additional*"
                    item-text="name"
                    item-value="id"
                    :items="additionalOptions"
                    multiple
                    @blur="$v.form.additional.$touch()"
                    :error-messages="additionalErrors"
                  ></v-select>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Flight By*" v-model="form.flightBy" required name="flightBy" @blur="$v.form.flightBy.$touch()" :error-messages="flightByErrors"></v-text-field>
                </v-flex>
                <v-flex xs12 style="padding: 10px">
                  <text-editor @textContent="textContent"></text-editor>
                </v-flex>
                <v-flex xs12 style="padding: 10px" class="row">
                  <div v-for="index in 3" class="col-sm-4">
                    <h5>Carousel {{ index }}</h5>
                    <vue-dropify :id="'carousel_'+index" :multiple="false" @change="changeImage('carousel',index)" ref="carousel" message="Upload Carousel By Click Here"></vue-dropify> 
                    <v-text-field label="Note" v-model="note[index]"  required name="note[index]" ></v-text-field>
                  </div>
                </v-flex>
        
                <v-flex xs12 md6 style="padding: 10px">
                  <h5>Upload PDF</h5>
                  <vue-dropify id="pdf" multiple="false" @change="changeImage('pdf',1)" ref="pdf" message="Upload PDF By Click Here"></vue-dropify> 
                </v-flex>
                  
                <v-flex xs12 md6 style="padding: 10px">
                  <h5>Flyer</h5>
                  <vue-dropify id="flyer" multiple="false" @change="changeImage('flyer',1)" ref="flyer" message="Upload Flyer By Click Here"></vue-dropify> 
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
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
                        <v-text-field label="Title" v-model="title[index]"></v-text-field>
                        <v-text-field label="B/L/D" v-model="bld[index]"></v-text-field>
                      </v-flex>
                      <v-flex xs12 md6>
                        <v-textarea auto-grow label="Caption"  v-model="caption[index]"></v-textarea>
                      </v-flex>
                    </v-layout>
                  </div>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <h5>Add Flight Detail</h5>
                  <div v-for="index in addFlightDetail">
                    <v-layout wrap border style="padding: 10px">
                      <v-flex xs4 class="text-center pa-2" >
                        <v-text-field label="No Flight" v-model="flight[index]"></v-text-field>
                      </v-flex>
                      <v-flex xs4 class="text-center pa-2">
                        <v-text-field label="Route" v-model="route[index]" ></v-text-field>
                        <v-btn v-if="index == addFlightDetail" small  class="mx-1" fab dark color="primary" @click="addFlight">
                          <v-icon dark>add</v-icon>
                        </v-btn>
                        <v-btn v-if="index == addFlightDetail" small  class="mx-1" fab dark color="red" @click="removeFlight">
                          <v-icon dark>remove</v-icon>
                        </v-btn>
                      </v-flex>
                      <v-flex xs4 class="text-center pa-2">
                        <v-text-field label="Time Departure" v-model="departure[index]" ></v-text-field>
                        <v-text-field label="Time Arrival" v-model="arrival[index]" ></v-text-field>
                      </v-flex>
                    </v-layout>
                  </div>
                </v-flex>
              </v-layout>
            </tab-content>
            <tab-content title="Form Detail">
              <v-layout wrap>
                <v-flex xs12 md6 style="padding: 10px" class="px-12">
                  <v-menu
                    v-model="formDetail.menu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    full-width
                    min-width="1px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="formDetail.dateStart"
                        label="Date Start"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="formDetail.dateStart" @input="menu = false"></v-date-picker>
                  </v-menu>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-menu
                    v-model="formDetail.menu1"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    full-width
                    min-width="1px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="formDetail.dateEnd"
                        label="Date End"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="formDetail.dateEnd" @input="menu1 = false"></v-date-picker>
                  </v-menu>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Adult Price" v-money="money" ref="adultPrice" v-model="formDetail.adultPrice" :error-messages="adultPriceErrors"  required name="adultPrice" @blur="$v.formDetail.adultPrice.$touch()"></v-text-field>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Child No Bed Price" v-money="money" ref="CnBPrice" v-model="formDetail.CnBPrice" :error-messages="CnBPriceErrors"  required name="CnBPrice"  @blur="$v.formDetail.CnBPrice.$touch()"></v-text-field>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Child With Bed Price" v-money="money" ref="CwBPrice" v-model="formDetail.CwBPrice" :error-messages="CwBPriceErrors"  required name="CwBPrice" @blur="$v.formDetail.CwBPrice.$touch()"></v-text-field>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Infant Price" v-money="money" ref="infantPrice" v-model="formDetail.infantPrice" :error-messages="infantPriceErrors"  required name="infantPrice" @blur="$v.formDetail.infantPrice.$touch()" ></v-text-field>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Agent Com Price" v-money="money" ref="agentPrice" v-model="formDetail.agentPrice" :error-messages="agentPriceErrors"  required name="agentPrice" @blur="$v.formDetail.agentPrice.$touch()" ></v-text-field>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Tips Price" v-money="money" ref="tipsPrice" v-model="formDetail.tipsPrice" :error-messages="tipsPriceErrors"  required name="tipsPrice" @blur="$v.formDetail.tipsPrice.$touch()"></v-text-field>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Visa Price" v-money="money" ref="visaPrice" v-model="formDetail.visaPrice" :error-messages="visaPriceErrors"  required name="visaPrice" @blur="$v.formDetail.visaPrice.$touch()" ></v-text-field>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Apt Tax & Fuel Surcharge" v-money="money" ref="aptPrice" v-model="formDetail.aptPrice" :error-messages="aptPriceErrors"  required name="aptPrice" @blur="$v.formDetail.aptPrice.$touch()"></v-text-field>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="Seat" ref="seat" v-model="formDetail.seat" :error-messages="seatErrors"  required name="seat" type="number" @blur="$v.formDetail.seat.$touch()"></v-text-field>
                </v-flex>
                <v-flex xs12 md6 style="padding: 10px">
                  <v-text-field label="minimal DP" v-money="money" ref="minimalDP" v-model="formDetail.minimalDP" :error-messages="minimalDPErrors"  required name="minimalDP" @blur="$v.formDetail.minimalDP.$touch()" ></v-text-field>
                </v-flex>
                <v-flex xs12 style="padding: 10px;text-align: right;">
                  <v-btn
                    :loading="loading"
                    :disabled="loading"
                    color="primary"
                    class="ma-2 white--text"
                    @click="appendItinerary"
                  >
                    Append
                    <v-icon right dark>check_circle</v-icon>
                  </v-btn>
                </v-flex>
                <v-flex xs12 style="padding: 10px">
                  <v-data-table
                    :headers="itineraryHeaders"
                    :items="formDetail.itineraryItems"
                    class="elevation-1"
                  >
                    <template v-slot:items="props">
                      <td>{{ props.item.dateStart }}</td>
                      <td>{{ props.item.dateEnd }}</td>
                      <td class="text-xs-right">{{ props.item.adultPrice  | currency}}</td>
                      <td class="text-xs-right">{{ props.item.CnBPrice  | currency}}</td>
                      <td class="text-xs-right">{{ props.item.CwBPrice  | currency}}</td>
                      <td class="text-xs-right">{{ props.item.infantPrice  | currency}}</td>
                      <td class="text-xs-right">{{ props.item.minimalDP  | currency}}</td>
                      <td class="text-xs-right">{{ props.item.agentPrice  | currency}}</td>
                      <td class="text-xs-right">{{ props.item.tipsPrice  | currency}}</td>
                      <td class="text-xs-right">{{ props.item.aptPrice  | currency}}</td>
                      <td class="text-xs-right">{{ props.item.seat }}</td>
                      <td if="props.item.action == 'action" class="text-xs-right">
                        <v-btn small color="primary" dark fab @click="">
                          <v-icon dark>edit</v-icon>
                        </v-btn>
                        <v-btn small color="red" dark fab @click="">
                          <v-icon dark>remove</v-icon>
                        </v-btn>
                      </td>
                    </template>
                  </v-data-table>
                </v-flex>
              </v-layout>
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
          Vue.filter('currency', function(val){
            return accounting.formatNumber(val)
          })

          axios
            .get('/api/get-token')
            .then(response => {
              axios.defaults.headers.common['Authorization'] = 'Bearer '+response.data.access_token;

            })
            .catch(error => {
              console.log(error)
              this.errored = true
            })
            .finally(() => this.apiReady = true)


      },
      data: () => ({
        addDetailSchedule : 1,
        loadingWizard: false,
        addFlightDetail : 1,
        id:'',
        apiReady:false,
        form: {
            name: '',
            destination: '',
            additional: '',
            flightBy: '',
            code:'Tes',
            term:'',
            carousel:[],
            flyer:[],
            pdf:[],
        },
        formDetail:{
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
          itineraryItems:[],
        },
        destinationOptions:[],
        additionalOptions:[],
        note:[],
        title:[],
        caption:[],
        bld:[],
        flight:[],
        flightBy:[],
 
        route:[],
        departure:[],
        arrival:[],
        money: {
          decimal: '.',
          thousands: ',',
          precision: 0,
          masked: false /* doesn't work with directive */
        },
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
      }),
      validations: {
          form: {
              name: {
                  required
              },
              
              destination: {
                  required
              },
              additional: {
                  required
              },
              flightBy: {
                  required
              },
          },
          formDetail: {
              adultPrice: {
                  required
              },
              minimalDP: {
                  required
              },
              CnBPrice: {
                  required
              },
              CwBPrice: {
                  required
              },
              infantPrice: {
                  required
              },
              agentPrice: {
                  required
              },
              tipsPrice: {
                  required
              },
              visaPrice: {
                  required
              },
              aptPrice: {
                  required
              },
              seat: {
                  required
              },
              minimalDP: {
                  required
              },
          }
      },
      computed: {
          nameErrors() {
              const errors = []
              if (!this.$v.form.name.$dirty) return errors
              !this.$v.form.name.required && errors.push('Name is required.')
              return errors
          },
          priceErrors() {
              const errors = [];
              if (!this.$v.form.price.$dirty) return errors
              !this.$v.form.price.required && errors.push('price is required.')
              return errors
          },
          destinationErrors() {
              const errors = [];
              if (!this.$v.form.destination.$dirty) return errors
              !this.$v.form.destination.required && errors.push('Destination is required.')
              return errors
          },
          additionalErrors() {
              const errors = [];
              if (!this.$v.form.additional.$dirty) return errors
              !this.$v.form.additional.required && errors.push('Additional is required.')
              return errors
          },
          flightByErrors() {
              const errors = [];
              if (!this.$v.form.flightBy.$dirty) return errors
              !this.$v.form.flightBy.required && errors.push('Flight By is required.')
              return errors
          },
          adultPriceErrors() {
              const errors = [];
              if (!this.$v.formDetail.adultPrice.$dirty) return errors
              !this.$v.formDetail.adultPrice.required && errors.push('Adult Price is required.')
              return errors
          },
          CwBPriceErrors() {
              const errors = [];
              if (!this.$v.formDetail.CwBPrice.$dirty) return errors
              !this.$v.formDetail.CwBPrice.required && errors.push('CwB Price is required.')
              return errors
          },
          agentPriceErrors() {
              const errors = [];
              if (!this.$v.formDetail.agentPrice.$dirty) return errors
              !this.$v.formDetail.agentPrice.required && errors.push('Agent Com Price is required.')
              return errors
          },
          visaPriceErrors() {
              const errors = [];
              if (!this.$v.formDetail.visaPrice.$dirty) return errors
              !this.$v.formDetail.visaPrice.required && errors.push('Visa Price is required.')
              return errors
          },
          seatErrors() {
              const errors = [];
              if (!this.$v.formDetail.seat.$dirty) return errors
              !this.$v.formDetail.seat.required && errors.push('Seat is required.')
              return errors
          },
          CnBPriceErrors() {
              const errors = [];
              if (!this.$v.formDetail.CnBPrice.$dirty) return errors
              !this.$v.formDetail.CnBPrice.required && errors.push('CnB Price is required.')
              return errors
          },
          infantPriceErrors() {
              const errors = [];
              if (!this.$v.formDetail.infantPrice.$dirty) return errors
              !this.$v.formDetail.infantPrice.required && errors.push('Infant Price is required.')
              return errors
          },
          tipsPriceErrors() {
              const errors = [];
              if (!this.$v.formDetail.tipsPrice.$dirty) return errors
              !this.$v.formDetail.tipsPrice.required && errors.push('Tips Price is required.')
              return errors
          },
          aptPriceErrors() {
              const errors = [];
              if (!this.$v.formDetail.aptPrice.$dirty) return errors
              !this.$v.formDetail.aptPrice.required && errors.push('Apt tax and surcharge is required.')
              return errors
          },
          minimalDPErrors() {
              const errors = [];
              if (!this.$v.formDetail.minimalDP.$dirty) return errors
              !this.$v.formDetail.minimalDP.required && errors.push('Minimal DP is required.')
              return errors
          },


      },
      props: {
          dialog: false,
          idData: Array,
      },
      components: {
          'vue-dropify': VueDropify
      },
      watch: {
          dialog: function() {
              this.dialogs = this.dialog;
              this.imageReady = true;
          },
          apiReady:function(){
              console.log('Generate Token...')
              this.callingApi();
          }
      },
      methods: {
          saveAndCloseDialog() {

            let formData = new FormData();

            // for ( var key in this.form ) {
            //     formData.append(key, this.form [key]);
            // }

            // for ( var key in this.formDetail ) {
            //     formData.append(key, this.formDetail [key]);
            // }

            formData.append('id', this.id)
            formData.append('form',  JSON.stringify(this.form))
            formData.append('formDetail', JSON.stringify(this.formDetail))
            formData.append('carousel1', this.form.carousel[0])
            formData.append('carousel2', this.form.carousel[1])
            formData.append('carousel3', this.form.carousel[2])
            formData.append('pdf', this.form.pdf)
            formData.append('flyer', this.form.flyer)
            axios.post('/api/itinerary/save',
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
       
          },
          textContent(content){
            this.form.term = content;
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
          },
          appendItinerary(){
            this.$v.formDetail.$touch();
            if (this.$v.formDetail.$anyError) {
              window.scrollTo(0,0);
              return false;
            }

            const l = this.loader
            this[l] = !this[l]

            let html = '<div>'

            let data = {
              'dateStart':this.formDetail.dateStart,
              'dateEnd':this.formDetail.dateEnd,
              'adultPrice':this.formDetail.adultPrice,
              'CwBPrice':this.formDetail.CwBPrice,
              'CnBPrice':this.formDetail.CnBPrice,
              'infantPrice':this.formDetail.infantPrice,
              'agentPrice':this.formDetail.agentPrice,
              'tipsPrice':this.formDetail.tipsPrice,
              'visaPrice':this.formDetail.visaPrice,
              'aptPrice':this.formDetail.aptPrice,
              'seat':this.formDetail.seat,
              'minimalDP':this.formDetail.minimalDP,
              'action':'action',
            } 

            this.formDetail.itineraryItems.push(data);
            this[l] = false;
            this.loader = null;
            this.formDetail.seat = '';
            this.$refs.adultPrice.$el.getElementsByTagName('input')[0].value = 0;
            this.$refs.CwBPrice.$el.getElementsByTagName('input')[0].value = 0;
            this.$refs.CnBPrice.$el.getElementsByTagName('input')[0].value = 0;
            this.$refs.infantPrice.$el.getElementsByTagName('input')[0].value = 0;
            this.$refs.agentPrice.$el.getElementsByTagName('input')[0].value = 0;
            this.$refs.tipsPrice.$el.getElementsByTagName('input')[0].value = 0;
            this.$refs.visaPrice.$el.getElementsByTagName('input')[0].value = 0;
            this.$refs.aptPrice.$el.getElementsByTagName('input')[0].value = 0;
            this.$refs.minimalDP.$el.getElementsByTagName('input')[0].value = 0;
          },
          callingApi(){
            axios
              .get('/api/itinerary/create')
              .then(response => {
                this.destinationOptions =  response.data.destination;
                this.additionalOptions =  response.data.additional;
              })
              .catch(error => {
                console.log(error)
                this.errored = true
              })
              .finally(() => this.apiReady = true)
          },
          setLoading: function(value) {
              this.loadingWizard = value;
          },
          beforeChange() {
            console.log(this.$v);
            return new Promise((resolve, reject) => {
              this.$v.form.$touch()
              if (this.$v.form.$anyError == true) {
                window.scrollTo(0,0);
                reject(true);
              }else{
                resolve(true)
              }
            })
          },
          onComplete: function(){
            this.saveAndCloseDialog();
          },
          changeImage:function(param,index){
            if (param == 'carousel') {
              var input =  $('#carousel_'+index).find('input');
              this.form.carousel[index-1] = input[0].files[0];  
            }else if (param == 'pdf'){
              var input =  $('#pdf').find('input');
              this.form.pdf = input[0].files[0];  
            }else if (param == 'flyer'){
              var input =  $('#flyer').find('input');
              this.form.pdf = input[0].files[0]; 
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