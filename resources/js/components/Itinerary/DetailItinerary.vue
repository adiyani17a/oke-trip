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
          <div class="card-body">
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
                  >
                </v-select>
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
                <label>Upload Final PDF</label>
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
    },
    mounted(){
      let breadcrumb = 'Itinerary <router-link to="/additional">/ Detail</router-link>';
      $('#crumb').html(breadcrumb);
      Vue.filter('currency', function(val){
        return accounting.formatNumber(val)
      })

      $('.chooseFile').bind('change', function () {
          var filename = $(this).val();
          var fsize = $(this)[0].files[0].size;
          if(fsize>5048576) //do something if file size more than 1 mb (1048576)
          {
            alert('Data To Big');
            return false;
          }
          var parent = $(this).parents(".preview_div");
          if (/^\s*$/.test(filename)) {
              $(parent).find('.file-upload').removeClass('active');
              $(parent).find(".noFile").text("No file chosen..."); 
          }
          else {
              $(parent).find('.file-upload').addClass('active');
              $(parent).find(".noFile").text(filename.replace("C:\\fakepath\\", "")); 
          }
      });

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
      tourLeaderTips: '',
      isBooked: '',
      tourLeaderOptions: [],
      isBookedOptions: [],
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
      flayerName:false,
      snackbar:false,
      timeout: 6000,
      mode: '',
      color:'warning',
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
              this.finalConfirmation = response.data.data.final_pdf;
              this.tataTertib = response.data.data.term_pdf;
              this.flayer = response.data.data.flayer_jpg;
              this.isBooked = response.data.data.booked_by;
              console.log(this.isBooked);
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
                this.text = error;
                this.errored = true
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