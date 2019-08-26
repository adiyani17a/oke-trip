<template>
  <div class="container">
    <div class="row justify-content-center" id="apps">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 style="margin-top: 10px;display: inline-block;"><b>DETAIL ITINERARY</b></h5>
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
                <v-text-field label="Tour Leader Tips*" v-money="money" v-model="tourLeaderTips" @blur="$v.tourLeaderTips.$touch()" :error-messages="tourLeaderTipsErrors" ></v-text-field>
              </v-flex>
              <v-flex xs12 style="padding: 10px">
                <label>Upload Final PDF</label>
                <div class="final preview_div satu row">
                  <div class="file-upload upl_3 col-sm-8 py-3">
                    <div class="file-select">
                      <div class="file-select-button fileName" >Final Confirmation</div>
                      <div class="file-select-name noFile"></div>
                      <input type="file" class="chooseFile" id="final" name="fc">
                    </div>
                  </div>
                  <div class="preview_pdf col-sm-4">
                    <div>
                      <button type="button" class="btn btn-info" style="margin-top: 5px;" @click="previewPDF('final')"><i class="fa fa-eye"></i> Preview PDF</button>
                    </div>
                  </div>
                </div>
              </v-flex>
              <v-flex xs12 style="padding: 10px">
                <label>Upload Final PDF</label>
                <div class="tata_tertib preview_div satu row">
                  <div class="file-upload upl_3 col-sm-8 py-3">
                    <div class="file-select">
                      <div class="file-select-button fileName" >Tata Tertib</div>
                      <div class="file-select-name noFile"></div>
                      <input type="file" class="chooseFile" id="tata_tertib" name="fc">
                    </div>
                  </div>
                  <div class="preview_pdf col-sm-4">
                    <div>
                      <button type="button" class="btn btn-info" style="margin-top: 5px;" @click="previewPDF('tata_tertib')"><i class="fa fa-eye"></i> Preview PDF</button>
                    </div>
                  </div>
                </div>
              </v-flex>
              <v-flex xs12 style="padding: 10px">
                <label>Upload Flayer PDF</label>
                <div class="flayer preview_div satu row">
                  <div class="file-upload upl_3 col-sm-8 py-3">
                    <div class="file-select">
                      <div class="file-select-button fileName" >Flayer</div>
                      <div class="file-select-name noFile"></div>
                      <input type="file" class="chooseFile" id="flayer" name="fc">
                    </div>
                  </div>
                  <div class="preview_pdf col-sm-4">
                    <div>
                      <button type="button" class="btn btn-info" style="margin-top: 5px;" @click="previewPDF('flayer')"><i class="fa fa-eye"></i> Preview PDF</button>
                    </div>
                  </div>
                </div>
              </v-flex>
              <v-flex xs12 md-6 style="padding: 10px" class="right">
                <v-btn color="primary">
                  <v-icon>fas fa-save</v-icon>&nbsp;Save 
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
                    @click="dialog = false"
                  >
                    I accept
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
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
          load(parent,this);
      });

      function load(parent,file) {
          var fsize = $(file)[0].files[0].size;
          if(fsize>2048576) //do something if file size more than 1 mb (1048576)
          {
            alert('Data To Big');
            return false;
          }
          var reader = new FileReader();
          reader.onload = function(e){
              $(parent).find('.output').attr('src',e.target.result);
          };
          reader.readAsDataURL(file.files[0]);
      }

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
      tourLeaderOptions: [],
      apiReady:false,
      pdfPreview:false,
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
        }
    },
    methods: {
      callingApi(){
        axios
          .get('/api/itinerary/detail?id='+this.$route.params.id+'&dt='+this.$route.params.dt)
          .then(response => {
              this.tourLeaderOptions = response.data.tourLeader;
            
          })
          .catch(error => {
            console.log(error)
            this.errored = true
          })
          .finally(() => this.apiReady = true)
      },
      previewPDF(param){
        let par = $('.'+param).find('.chooseFile');
        let pdffile = $(par)[0].files[0];
        let pdffile_url = URL.createObjectURL(pdffile);
        console.log(pdffile_url);
        $('#viewer').attr('src',pdffile_url);
        this.pdfPreview = true;
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