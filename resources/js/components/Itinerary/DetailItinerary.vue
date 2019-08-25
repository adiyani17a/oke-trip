<template>
	<div>
    <v-card flat >
      <v-layout wrap class="px-5 py-5">
        <v-flex xs12 style="padding: 10px">
          <v-select
            v-model="tourLeader"
            label="Tour Leader*"
            :items="tourLeaderOptions"
            item-text="name"
            item-value="id"
            >
          </v-select>
        </v-flex>
        <v-flex xs12 md6 style="padding: 10px">
          <label>Upload Final PDF</label>
          <div class="preview_div satu row">
            <div class="file-upload upl_3 col-sm-8 py-3">
              <div class="file-select">
                <div class="file-select-button fileName" >Final Confirmation</div>
                <div class="file-select-name noFile"></div>
                <input type="file" class="chooseFile"  name="fc">
              </div>
            </div>
            <div class="preview_pdf col-sm-4">
              <div>
                <button type="button" class="btn btn-info" style="margin-top: 5px;"><i class="fa fa-eye"></i> Preview PDF</button>
              </div>
            </div>
          </div>
        </v-flex>
        <v-flex xs12 md6 style="padding: 10px">
          <label>Upload Final PDF</label>
          <div class="preview_div satu row">
            <div class="file-upload upl_3 col-sm-8 py-3">
              <div class="file-select">
                <div class="file-select-button fileName" >Tata Tertib</div>
                <div class="file-select-name noFile"></div>
                <input type="file" class="chooseFile"  name="fc">
              </div>
            </div>
            <div class="preview_pdf col-sm-4">
              <div>
                <button type="button" class="btn btn-info" style="margin-top: 5px;"><i class="fa fa-eye"></i> Preview PDF</button>
              </div>
            </div>
          </div>
        </v-flex>
        <v-flex xs12 md6 style="padding: 10px">
          <label>Upload Final PDF</label>
          <div class="preview_div satu row">
            <div class="file-upload upl_3 col-sm-8 py-3">
              <div class="file-select">
                <div class="file-select-button fileName" >Flayer</div>
                <div class="file-select-name noFile"></div>
                <input type="file" class="chooseFile"  name="fc">
              </div>
            </div>
            <div class="preview_pdf col-sm-4">
              <div>
                <button type="button" class="btn btn-info" style="margin-top: 5px;"><i class="fa fa-eye"></i> Preview PDF</button>
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
    </v-card>
	</div>
</template>
<script type="text/javascript">
  import { required, maxLength, email } from 'vuelidate/lib/validators'
  import VueDropify from 'vue-dropify';
  export default {
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
      data() {
          return {
              tourLeader:'',
              tabs: [{
                  title: 'Form Data'
              }, {
                  title: 'Itinerary Report'
              }],
              active: null,
              apiReady : false,
              validations: {
                  tourLeader: {
                      required
                  },
              },
              tourLeaderOptions: []
          }
      },
      components: {
          'vue-dropify': VueDropify
      },
      watch: {
          apiReady:function(){
              console.log('Generate Token...')
              this.callingApi();
          }
      },
      methods: {
          next() {
              const active = parseInt(this.active)
              this.active = (active < 2 ? active + 1 : 0)
          },
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
          }
      },
      computed: {
          tourLeaderErrors() {
              const errors = []
              if (!this.$v.tourLeader.required) {
                  errors.push('Tour Leader is required.');
                  return errors;
              }
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