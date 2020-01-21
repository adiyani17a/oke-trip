<template id="example">
    <div class="container" >
        <loading :active.sync="isLoading" 
            :can-cancel="true" 
            :on-cancel="onCancel"
            :is-full-page="fullPage">    
        </loading>
        <div class="row justify-content-center" id="apps">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 style="margin-top: 10px;display: inline-block;"><b>{{ namaFitur }}</b></h5>
                        <v-menu offset-y v-if="select.length == 1">
                          <template v-slot:activator="{ on }">
                            <v-btn v-if="select.length == 1" color="error pull-right" @click="dialogDelete = true">Delete
                                <v-icon dark right>fas fa-trash-alt</v-icon>
                            </v-btn>
                            <v-btn v-if="select.length > 1" color="error pull-right" @click="dialogDelete = true">Bulk Delete
                                <v-icon dark right>fas fa-trash</v-icon>
                            </v-btn>
                            <v-btn
                              
                              color="info pull-right"
                              dark
                              v-on="on"
                            >
                              Menu List
                            <v-icon dark right>fas fa-info</v-icon>
                            </v-btn>
                          </template>
                          <v-list>
                            <v-list-tile
                              v-for="(item, index) in itineraryOptions"
                              :key="index"
                              @click=""
                              >
                              <v-list-tile-title @click="modalAction(item.value)" :class="item.class">{{ item.title }}</v-list-tile-title>
                            </v-list-tile>
                          </v-list>
                        </v-menu>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <datatable-component :dataItem="dataItem"
                                                 :headers="headers"
                                                 :loadingDataTable="loadingDataTable"
                                                 :paginations="pagination"
                                                 :totalItem="totalItem"
                                                 :namaFitur="namaFitur"
                                                 @selectedCheckbox="selectedCheckbox"
                                                 @callingApi="callingApi"
                                                 @switchChange="switchChange"
                                                 @hotDeals="hotDeals"
                                                 >
                            </datatable-component>
                        </div>
                    </div>
                    <v-dialog
                      v-model="dialogDelete"
                      max-width="290"
                    >
                      <v-card>
                        <v-card-title class="headline">Are You Sure Deleting Data?</v-card-title>

                        <v-card-text>
                          This Action Cannot Be Undo.
                        </v-card-text>

                        <v-card-actions>
                          <v-spacer></v-spacer>

                          <v-btn
                            color="default darken-1"
                            flat="flat"
                            @click="confirmationDelete('cancel')"
                          >
                            Cancel
                          </v-btn>

                          <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="confirmationDelete('confirm')"
                          >
                            Yes, Delete
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>

                    <v-dialog
                      v-model="scheduleModal"
                      width="800"
                      style="z-index:9999999999 !important"
                      >
                      <v-card>
                        <v-card-title
                          class="headline grey lighten-2"
                          primary-title
                        >
                          Schedule
                        </v-card-title>

                        <v-card-text>
                          <schedule :schedules="menuListData"></schedule>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn
                            color="primary"
                            flat
                            @click="scheduleModal = false"
                          >
                            Close
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>

                    <v-dialog
                      v-model="routeModal"
                      width="800"
                      style="z-index:9999999999 !important"
                     >
                      <v-card>
                        <v-card-title
                          class="headline grey lighten-2"
                          primary-title
                         >
                          Flight Route
                        </v-card-title>

                        <v-card-text>
                          <flight-route :route="menuListData"></flight-route>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn
                            color="primary"
                            flat
                            @click="routeModal = false"
                          >
                            Close
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>

                    <v-dialog
                      v-model="termModal"
                      width="800"
                      style="z-index:9999999999 !important"
                    >
                      <v-card>
                        <v-card-title
                          class="headline grey lighten-2"
                          primary-title
                        >
                          Term & Condition
                        </v-card-title>

                        <v-card-text>
                          <term :term="term"></term>
                          
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn
                            color="primary"
                            flat
                            @click="termModal = false"
                          >
                            Close
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>

                    <v-dialog
                      v-model="detailModal"
                      width="800"
                      style="z-index:9999999999 !important"
                    >
                      <v-card>
                        <v-card-title
                          class="headline grey lighten-2"
                          primary-title
                        >
                            Detail
                        </v-card-title>

                        <v-card-text>
                          <detail :itineraryDetail="menuListData" :selected="select"></detail>  
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn
                            color="primary"
                            flat
                            @click="detailModal = false"
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
</template>
<script>

    Vue.component('detail', require('../Itinerary/Detail.vue').default)
    Vue.component('flight-route', require('../Itinerary/FlightRoute.vue').default)
    Vue.component('schedule', require('../Itinerary/Schedule.vue').default)
    Vue.component('term', require('../Itinerary/Term.vue').default)
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
        mounted() {
            console.log('Intialize Main Page...')
            let breadcrumb = '<router-link to="/additional">Additional</router-link>';
            $('#crumb').html(breadcrumb);
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
        components: {
            Loading
        },
        data() {
            return {
                namaFitur: this.$route.name,
                dataItem: [],
                select: [],
                isLoading: true,
                scheduleModal: false,
                menuListData:[],
                routeModal: false,
                detailModal: false,
                termModal:false,
                fullPage: true,
                term: '',
                dialog: false,
                dialogDelete: false,
                itineraryOptions: [
                    { title: ' Schedule' ,class:'fas fa-address-book',value:'schedule'},
                    { title: ' Flight Route',class:'fas fa-plane-departure',value:'flight' },
                    { title: ' Term' ,class:'fas fa-question' ,value:'term'},
                    { title: ' Itinerary Detail',class:'fas fa-list-alt' ,value:'detail' },
                ],
                headers:[
                    { text: 'Code', value: 'code',class:'text-xs-left',type:'default'},
                    { text: 'Name', value: 'name',class:'text-xs-left',type:'default'},
                    { text: 'Destination', value: 'destination'},
                    { text: 'Highlight', value: 'highlight' ,type:'default'},
                    { text: 'Flight By', value: 'flight_by' ,type:'default'},
                    { text: 'Active', value: 'active' ,type:'switch',class:'text-xs-center'},
                    { text: 'Created At', value: 'created_at',type:'default' },
                    { text: 'Created By', value: 'created_by',type:'default' },
                    { text: 'is Hot Deals', value: 'hot_deals',type:'hot deals' },
                ],
                loadingDataTable:false,
                apiReady:false,
                pagination:{
                    current: 1,
                    total: 0,
                    rowsPerPage:10, 
                    totalItem:0, 
                },
                totalItem:0,
                currentPage:1,
                dialog:false,
                idData:[],
                param:'',
                snackbar: false,
                color: 'success',
                mode: '',
                tes: '',
                destination: [],
                additional: [],
                timeout: 6000,
                text: 'Hello, I\'m a snackbar'
            }
        },
        watch:{
            apiReady:function(){
                console.log('Generate Token...')
                this.callingApi();
            },
        },
        methods:{
            hotDeals(param,id){
              axios.post('/api/itinerary/change-status-hot-deal', {
                      id: id,
                      param: param,
                  })
                  .then(response => {
                      this.snackbar = true;
                      this.text = response.data.message;
                      this.callingApi();
                      this.dialogDelete = false;
                  })
                  .catch(error => {
                      console.log(error)
                      this.snackbar = true;
                      this.text = error;
                      this.errored = true
                      this.dialogDelete = false;
                  })
            },
            onClickChild(value){
                this.api = '/api/additional/datatable'
            },
            selectedCheckbox(selected){
                this.select = selected;
                this.idData = selected;
            },
            callingApi(page,show){
                if (show == undefined) {
                    show = 10;
                }

                if (page == undefined) {
                    page = this.currentPage;
                }
                axios
                  .get('/api/archive/datatable?page='+page+'&showing='+show)
                  .then(response => {
                    this.loadingDataTable = false
                    this.dataItem = response.data.data.data
                    this.pagination.current = response.data.data.current_page;
                    this.pagination.total = response.data.data.last_page;
                    this.pagination.rowsPerPage = show;
                    this.pagination.totalItem = response.data.data.total;
                    this.totalItem = response.data.data.total;
                    for (var i = 0; i < this.dataItem.length; i++) {
                        if (this.dataItem[i].active == 'true') {
                            this.dataItem[i].active = true 
                        }else{
                            this.dataItem[i].active = false 
                        }

                        this.dataItem[i].image = '.'+this.dataItem[i].image;
                        if (this.dataItem[i].create != null) {
                          this.dataItem[i].created_by = this.dataItem[i].create.name;
                        }
                    }

                  })
                  .catch(error => {
                    console.log(error)
                    this.errored = true
                  })
                  .finally(() => this.loadingDataTable = true,this.isLoading = false)
            },
            deleteData(){

                axios
                    .post('/api/archive/delete',{
                        data:{
                            data:this.select,
                        }
                    })
                    .then(response => {
                        if (response.data.status == 1) {
                            this.snackbar =  true;
                            this.text =  response.data.message;
                            this.callingApi();
                            this.dialogDelete = false;
                            this.color = 'success';
                        }else{
                            this.snackbar =  true;
                            this.text =  response.data.message;
                            this.callingApi();
                            this.dialogDelete = false;
                            this.color = 'error';
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        this.snackbar =  true;
                        this.text =  error;
                        this.errored = true
                        this.dialogDelete = false;
                    })
            },
            editData(){
              this.$router.push({ name: 'Edit Itinerary', params: { id: this.select[0].id } });
            },
            closeDialog(param){
                this.dialog = false;
                this.callingApi();
            },
            confirmationDelete(param){
                if (param == 'confirm') {
                    this.deleteData();
                }else{
                    this.dialogDelete = false;
                }
            },
            doAjax() {
                this.isLoading = true;
                // simulate AJAX
                setTimeout(() => {
                  this.isLoading = false
                },5000)
            },
            onCancel() {
              console.log('User cancelled the loader.')
            },
            getCurrentPage(page){
                this.currentPage  = page;
                console.log(this.currentPage);
            },
            switchChange(data,id,param){
                axios
                    .post('/api/itinerary/change-status',{
                        data:data,
                        id:id,
                        param:param,
                    })
                    .then(response => {
                        this.snackbar =  true;
                        this.text =  response.data.message;
                        this.callingApi();
                        this.dialogDelete = false;
                    })
                    .catch(error => {
                        console.log(error)
                        this.snackbar =  true;
                        this.text =  error;
                        this.errored = true
                        this.dialogDelete = false;
                    })
            },
            modalAction(param){
                axios
                    .get('/api/itinerary/menu-list?id='+this.select[0].id)
                    .then(response => {
                        if (param == 'schedule') {
                            this.menuListData = response.data.itinerary_schedule;
                            for (var i = 0; i < this.menuListData.length; i++) {
                              this.menuListData[i].id = i;
                            }
                            this.scheduleModal = true;
                        }else if (param == 'flight') {
                            this.menuListData = response.data.itinerary_flight;
                            for (var i = 0; i < this.menuListData.length; i++) {
                              this.menuListData[i].id = i;
                            }
                            this.routeModal = true;
                        }else if (param == 'term') {
                            this.term = response.data.term_condition;
                            this.termModal = true;
                        }if (param == 'detail') {
                            this.menuListData = response.data.itinerary_detail;
                            for (var i = 0; i < this.menuListData.length; i++) {
                              this.menuListData[i].id = i;
                            }

                            this.detailModal = true;
                        }
                    })
                    .catch(error => {
                      this.errored = true
                    })
                    .finally(() => this.apiReady = true)
            }
        }
    }
    // new Vue({
    //   beforeCreate: function() {
    //     console.log(this.$appName)
    //   }
    // })

</script>
