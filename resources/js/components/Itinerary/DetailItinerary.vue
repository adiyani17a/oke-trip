<template>
  <div class="container">
    <div class="row justify-content-center" id="apps">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 style="margin-top: 10px;display: inline-block;"><b>DETAIL ITINERARY</b></h5>
            <v-btn  color="warning pull-right" @click="$router.push({ name: 'Itinerary' })">Back
              <v-icon dark right>fas fa-home</v-icon>
            </v-btn>
          </div>
          <template  style="z-index: 999999999999999999999">
            <div class="text-xs-center">
              <v-dialog
                v-model="dialog"
                width="1000"

              >
                <v-card>
                  <v-card-title
                    class="headline grey lighten-2"
                    primary-title
                  >
                      Payment List
                  </v-card-title>

                  <v-card-text>
                      <table class="table" v-if="payment_history.length != 0">
                          <tr>
                              <td>Code</td>
                              <td>: {{ payment_history[0].code }}</td>
                              <td>Date</td>
                              <td>: {{ payment_history[0].created_at }}</td>
                          </tr>
                          <tr>
                              <td>Total Payment</td>
                              <td>: {{ payment_history[0].total_payment | currency }}</td>
                              <td>Payment Method</td>
                              <td>: {{ payment_history[0].payment_method }}</td>
                          </tr>
                      </table>
                      <table class="table table-bordered">
                          <thead>
                              <th class="border p-1">Proof</th>
                              <th class="border p-1">Account Name</th>
                              <th class="border p-1">Account Number</th>
                              <th class="border p-1">Bank Name</th>
                              <th class="border p-1">Date Payment</th>
                              <th class="border p-1">Nominal</th>
                          </thead>
                          <tbody v-if="payment_history.length != 0">
                              <tr v-for="(item,i) in payment_history[0].payment_history_d">
                                  <td class="text-center border p-2" style="width: 20%;">
                                      <img style="width: 100%;height: 100px;" :src="$root.url_image+item.image">       
                                  </td>
                                  <td class="text-center border p-2">{{ item.account_name }}</td>
                                  <td class="text-center border p-2">{{ item.account_number }}</td>
                                  <td class="text-center border p-2">{{ item.bank }}</td>
                                  <td class="text-center border p-2">{{ item.date }}</td>
                                  <td class="text-right border p-2">{{ item.nominal | currency }}</td>
                              </tr>
                          </tbody>
                      </table>
                  </v-card-text>
                  <v-divider></v-divider>
                  <v-card-actions v-if="payment_history.length != 0">
                    <v-spacer></v-spacer>
                    <v-btn
                      color="primary"
                      flat
                      @click="approveData('Approve')"
                      v-if="!approveLoading && payment_history[0].status_payment == 'Pending'"
                    >
                      Approve
                    </v-btn>
                    <v-btn
                      color="primary"
                      flat
                      v-if="approveLoading && payment_history[0].status_payment == 'Pending'"
                      >
                      <i class="fa fa-spin fa-spinner"></i>
                    </v-btn>
                    <v-btn
                      color="error"
                      flat
                      @click="approveData('Rejected')"
                      v-if="!approveLoading && payment_history[0].status_payment == 'Pending'"
                    >
                      Reject
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </div>
          </template>
          <div class="card-body" v-if="apiReady == true">
            <v-layout wrap class="px-5 py-5">
              <v-flex xs12 md6 style="padding: 10px">
                <v-select
                  v-model="tourLeader"
                  label="Tour Leader*"
                  :items="tourLeaderOptions"
                  item-text="name"
                  item-value="id"
                  @blur="$v.tourLeader.$touch()" :error-messages="tourLeaderErrors"
                  >
                </v-select>
              </v-flex>
              <v-flex xs12 md6 style="padding: 10px">
                <v-text-field ref="tourLeaderTips" label="Tour Leader Tips*" v-money="money" v-model="tourLeaderTips" @blur="$v.tourLeaderTips.$touch()" :error-messages="tourLeaderTipsErrors" ></v-text-field>
              </v-flex>
              <v-flex xs12 md6 style="padding: 10px">
                <v-select
                  v-model="isBooked"
                  label="Is Booked By?"
                  :items="isBookedOptions"
                  item-text="name"
                  item-value="id"
                  :clearable="true"
                  :disabled="isPaid"
                  >
                </v-select>
              </v-flex>
              <v-flex xs12 md6 style="padding: 10px">
                <v-text-field ref="grossPerPax" label="Gross Per Pax*" v-money="money" v-model="grossPerPax" @blur="$v.grossPerPax.$touch()" :error-messages="grossPerPaxErrors" ></v-text-field>
              </v-flex>
              <v-flex xs12 md6 style="padding: 10px" v-if="payment_history.length != 0">
                <v-btn color="success" @click="dialog = true" v-if="payment_history[0].status_payment == 'Pending'">
                  Approve DP Payment
                </v-btn>
                <v-btn color="info" @click="dialog = true" v-if="payment_history[0].status_payment != 'Pending'">
                  View Payment
                </v-btn>
                </v-select>
              </v-flex>
              <v-flex xs12 style="padding: 10px">
               <ul>
                 <li>
                  <a :href="$root.url+'get-booking-list/pdf/pax/'+idBooking">Rooming List & Passport List</a>
                 </li>
                 <li>
                  <a :href="$root.url+'get-booking-list/pdf/room/'+idBooking">Pembagian Kamar</a>
                 </li>
                 <li>
                  <a :href="$root.url+'get-booking-list/pdf/passport/'+idBooking">Foto Passport</a>
                 </li>
               </ul>
              </v-flex>
              <v-flex xs12 style="padding: 10px">
                <label>Upload Final PDF</label>
                <div class="final preview_div satu row">
                  <div class="file-upload upl_3 col-sm-8 py-3" v-bind:class="{ active: finalActive }">
                    <div class="file-select">
                      <div class="file-select-button fileName" >Final Confirmation</div>
                      <div class="file-select-name noFile">{{ finalName }}</div>
                      <input type="file" class="chooseFile" id="final" name="fc" @change="uploadPDF('final')">
                    </div>
                  </div>
                  <div class="preview_pdf col-sm-4 text-right">
                    <div>
                      <button type="button" class="btn btn-info" style="margin-top: 5px;" @click="previewPDF('final')"><i class="fa fa-eye"></i> Preview PDF</button>
                    </div>
                  </div>
                </div>
              </v-flex>
              <v-flex xs12 style="padding: 10px">
                <label>Upload Tata Tertib PDF</label>
                <div class="tata_tertib preview_div satu row">
                  <div class="file-upload upl_3 col-sm-8 py-3" v-bind:class="{ active: tatibActive }">
                    <div class="file-select">
                      <div class="file-select-button fileName" >Tata Tertib</div>
                      <div class="file-select-name noFile">{{ tatibName }}</div>
                      <input type="file" class="chooseFile" id="tataTertib" name="fc" @change="uploadPDF('tatib')">
                    </div>
                  </div>
                  <div class="preview_pdf col-sm-4 text-right">
                    <div>
                      <button type="button" class="btn btn-info" style="margin-top: 5px;" @click="previewPDF('tata_tertib')"><i class="fa fa-eye"></i> Preview PDF</button>
                    </div>
                  </div>
                </div>
              </v-flex>
              <v-flex xs12 style="padding: 10px">
                <label>Upload Flayer PDF</label>
                <div class="flayer preview_div satu row">
                  <div class="file-upload upl_3 col-sm-8 py-3" v-bind:class="{ active: flayerActive }">
                    <div class="file-select">
                      <div class="file-select-button fileName" >Flayer</div>
                      <div class="file-select-name noFile">{{ flayerName }}</div>
                      <input type="file" class="chooseFile" id="flayer" name="fc" @change="uploadPDF('flayer')">
                    </div>
                  </div>
                  <div class="preview_pdf col-sm-4 text-right">
                    <div>
                      <button type="button" class="btn btn-info" style="margin-top: 5px;" @click="previewPDF('flayer')"><i class="fa fa-eye"></i> Preview PDF</button>
                    </div>
                  </div>
                </div>
              </v-flex>
              <v-flex xs12 md6 style="padding: 10px">
                <v-text-field ref="flightDetail" label="Flight Detail* Use | To Split" v-model="flightDetail" @blur="$v.flightDetail.$touch()" :error-messages="flightDetailErrors" ></v-text-field>
              </v-flex>
              <v-flex xs12 md-6 style="padding: 10px" class="right">
                <v-btn color="warning" @click="saveData">
                  <v-icon>fas fa-edit</v-icon>&nbsp;Update 
                </v-btn>
              </v-flex>
            </v-layout>
            <v-dialog
              v-model="pdfPreview"
              width="500"
              >
              <v-card>
                <v-card-title
                  class="headline grey lighten-2"
                  primary-title
                >
                  Preview
                </v-card-title>

                <v-card-text>
                   <iframe id="viewer" frameborder="0" scrolling="no" style="width: 100%" height="600" src="blob:http://127.0.0.1:8000/c6baefc6-a37d-4bb3-a544-10b5f4a81f9f"></iframe>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="primary"
                    flat
                    @click="pdfPreview = false"
                  >
                    Close
                  </v-btn>
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
              {{ textPreview }}
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
  import {VMoney} from 'v-money'

  export default {
    directives: {
        money: VMoney
    },
    mixins: [validationMixin],

    validations: {
      tourLeader: { required},
      tourLeaderTips: { required},
      flightDetails: { required},
      grossPerPax:{required}
    },
    mounted(){
      let breadcrumb = 'Itinerary <router-link to="/additional">/ Detail</router-link>';
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
      tourLeader: '',
      grossPerPax:'',
      tourLeaderTips: '',
      isBooked: '',
      flightDetail:'',
      tourLeaderOptions: [],
      isBookedOptions: [],
      approveLoading:false,
      apiReady:false,
      pdfPreview:false,
      finalConfirmation:'',
      tataTertib:'',
      flayer:'',
      finalActive:false,
      tatibActive:false,
      flayerActive:false,
      finalName:false,
      tatibName:false,
      idBooking:null,
      flayerName:false,
      snackbar:false,
      timeout: 6000,
      mode: '',
      color:'warning',
      payment_history:[],
      dialog:false,
      isPaid:false,
      textPreview: 'No data can be preview',

      money: {
        decimal: '.',
        thousands: ',',
        precision: 0,
        masked: false /* doesn't work with directive */
      },
    }),
    computed: {
      tourLeaderErrors () {
        const errors = []
        if (!this.$v.tourLeader.$dirty) return errors
        !this.$v.tourLeader.required && errors.push('Tour Leader Cant Be Empty!')
        return errors
      },
      tourLeaderTipsErrors () {
        const errors = []
        if (!this.$v.tourLeaderTips.$dirty) return errors
        !this.$v.tourLeaderTips.required && errors.push('Tour Leader Tips is required')
        return errors
      },
      flightDetailErrors () {
        const errors = []
        if (!this.$v.flightDetails.$dirty) return errors
        !this.$v.flightDetails.required && errors.push('Flight Detail is required')
        return errors
      },
      grossPerPaxErrors () {
        const errors = []
        if (!this.$v.grossPerPax.$dirty) return errors
        !this.$v.grossPerPax.required && errors.push('Gross Per Pax is required')
        return errors
      }
    },
    watch: {
        apiReady:function(){
            console.log('Generate Token...')
            this.callingApi();
        },
        tourLeaderTips(){
          console.log(this.tourLeaderTips);
        }
    },
    methods: {
      callingApi(){
        axios
          .get('/api/itinerary/detail?id='+this.$route.params.id+'&dt='+this.$route.params.dt)
          .then(response => {
              this.tourLeaderOptions = response.data.tourLeader;
              this.isBookedOptions = response.data.agen;
              this.tourLeader = response.data.data.tour_leader_id;
              this.tourLeaderTips = response.data.data.tour_leader_tips;
              this.$refs.tourLeaderTips.$el.getElementsByTagName('input')[0].value =  accounting.formatNumber(response.data.data.tour_leader_tips);
              this.grossPerPax = response.data.data.gross_per_pax;
              this.$refs.grossPerPax.$el.getElementsByTagName('input')[0].value =  accounting.formatNumber(response.data.data.gross_per_pax);
              this.finalConfirmation = response.data.data.final_pdf;
              this.tataTertib = response.data.data.term_pdf;
              this.flayer = response.data.data.flayer_jpg;
              this.isBooked = response.data.data.booked_by;
              this.flightDetail = response.data.data.flight_detail;
              this.payment_history = response.data.data.payment_history;
              this.idBooking = response.data.data.booking[0].id;
              if (this.payment_history.length != 0) { 
                if (this.payment_history[0].status_payment == 'Approve') {
                  this.isPaid = true;
                }
              }
                
              if (this.finalConfirmation != '') {
                this.finalActive = true;
                this.finalName = this.finalConfirmation.replace(/^.*[\\\/]/, '');
              }

              if (this.tatibConfirmation != '') {
                this.tatibActive = true;
                this.tatibName = this.tataTertib.replace(/^.*[\\\/]/, '');
              }

              if (this.flayerConfirmation != '') {
                this.flayerActive = true;
                this.flayerName = this.flayer.replace(/^.*[\\\/]/, '');
              }

          })
          .catch(error => {
            console.log(error)
            this.errored = true
          })
          .finally(() => this.apiReady = true)
      },
      previewPDF(param){
        if (param == 'final') {
          var pdffile = this.finalConfirmation;
        }else if (param == 'tata_tertib') {
          var pdffile = this.tataTertib;
        }else if (param == 'flayer') {
          var pdffile = this.flayer;
        }

        if (pdffile == undefined) {
          this.textPreview = 'No data can be preview';
          this.snackbar = true;
          return false;
        }

        if (pdffile.name === undefined) {
          $('#viewer').attr('src','/'+pdffile);
        }else{
          pdffile = URL.createObjectURL(pdffile);
          $('#viewer').attr('src',pdffile);
        }

        this.pdfPreview = true;
      },
      uploadPDF(param){
        $('.chooseFile').bind('change', function() {
            console.log('tes')
            var filename = $(this).val();
            var fsize = $(this)[0].files[0].size;
            if (fsize > 5048576) //do something if file size more than 1 mb (1048576)
            {
                alert('Data To Big');
                return false;
            }
            var parent = $(this).parents(".preview_div");
            if (/^\s*$/.test(filename)) {
                $(parent).find('.file-upload').removeClass('active');
                $(parent).find(".noFile").text("No file chosen...");
            } else {
                $(parent).find('.file-upload').addClass('active');
                $(parent).find(".noFile").text(filename.replace("C:\\fakepath\\", ""));
            }
        });

        if (param == 'final') {
          var input =  $('#final');
          this.finalConfirmation = input[0].files[0];  
        }else if (param == 'tatib') {
          var input =  $('#tataTertib');
          this.tataTertib= input[0].files[0];  
        }else if (param == 'flayer') {
          var input =  $('#flayer');
          this.flayer = input[0].files[0];  
        }
      },
      saveData(){
        let formData = new FormData();


        formData.append('id', this.$route.params.id)
        formData.append('dt', this.$route.params.dt)
        formData.append('tour_leader_id', this.tourLeader)
        formData.append('tour_leader_tips', this.tourLeaderTips)
        formData.append('finalConfirmation', this.finalConfirmation)
        formData.append('tataTertib', this.tataTertib)
        formData.append('flayer', this.flayer)
        formData.append('booked_by', this.isBooked)
        formData.append('flight_detail', this.flightDetail)
        formData.append('gross_per_pax', this.grossPerPax)
        axios.post('/api/itinerary/save-detail',
                formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            )
            .then(response => {
                this.dialogSave = false;
                this.snackbar = true;
                this.textPreview = response.data.message;
                if (response.data.status == 1) {
                  this.color = 'success';
                } else {
                  this.color = 'error'
                }
                this.imageReady = false;
            })
            .catch(error => {
                console.log(error)
                this.snackbar = true;
                this.textPreview = error;
                this.errored = true
            })
      },
      approveData(param) {
          let formData = new FormData();
          this.approveLoading = true;

          formData.append('status_payment', param);
          if (this.payment_history.length != 0) {
            formData.append('id', this.payment_history[0].id);
          }

          axios.post('/api/payment-list/update',
                  formData, {
                      headers: {
                          'Content-Type': 'multipart/form-data'
                      }
                  }
              )
              .then(response => {
                  this.snackbar = true;
                  this.textPreview = response.data.message;
                  if (response.data.status == 1) {
                      this.color = 'success'
                      this.approveLoading = false;
                      this.dialog = false;
                      this.select = [];
                      this.callingApi();

                  } else {
                      this.color = 'error'
                  }
              })
              .catch(error => {
                  this.snackbar = true;
                  this.text = error;
                  this.color = 'error'
                  this.dialog = false;
                  this.approveLoading = false;
              })
      }
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