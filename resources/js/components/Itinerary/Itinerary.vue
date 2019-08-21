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
                        <router-link to="/itinerary/create">
                            <v-btn color="primary pull-right" dark >Create
                                <v-icon dark right>fas fa-plus</v-icon>
                            </v-btn>
                        </router-link>

                        <v-btn v-if="select.length == 1" color="warning pull-right" @click="editData">Edit
                            <v-icon dark right>fas fa-pencil-alt</v-icon>
                        </v-btn>
                        <v-btn v-if="select.length == 1" color="error pull-right" @click="dialogDelete = true">Delete
                            <v-icon dark right>fas fa-trash-alt</v-icon>
                        </v-btn>
                        <v-btn v-if="select.length > 1" color="error pull-right" @click="dialogDelete = true">Bulk Delete
                            <v-icon dark right>fas fa-trash</v-icon>
                        </v-btn>
                        <v-menu offset-y v-if="select.length == 1">
                          <template v-slot:activator="{ on }">
                            <v-btn
                              
                              color="info pull-right"
                              dark
                              v-on="on"
                            >
                              Dropdown
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
                      v-model="scheduleDialog"
                      max-width="800"
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

    Vue.component('create-itinerary', require('./CreateItinerary.vue').default)

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
                routeModal: false,
                detailModal: false,
                fullPage: true,
                dialog: false,
                dialogDelete: false,
                itineraryOptions: [
                    { title: ' Schedule' ,class:'fas fa-address-book',value:'schedule'},
                    { title: ' Flight Route',class:'fas fa-plane-departure',value:'flight' },
                    { title: ' Term' ,class:'fas fa-question' ,value:'term'},
                    { title: ' Itinerary Detail',class:'fas fa-list-alt' ,value:'detail' }
                ],
                headers:[
                    { text: 'Name', value: 'name',class:'text-xs-left',type:'default'},
                    { text: 'Destination', value: 'destination'},
                    { text: 'Highlight', value: 'highlight' ,type:'default'},
                    { text: 'Flight By', value: 'flight_by' ,type:'default'},
                    { text: 'Active', value: 'active' ,type:'switch',class:'text-xs-center'},
                    { text: 'Created At', value: 'created_at',type:'default' },
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
                  .get('/api/itinerary/datatable?page='+page+'&showing='+show)
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
                    .delete('/api/additional/delete',{
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
                this.idData = '';
                this.idData = this.select;
                this.dialog = true;

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
                    .post('/api/additional/change-status',{
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
                console.log(param);
            }
        }
    }
    // new Vue({
    //   beforeCreate: function() {
    //     console.log(this.$appName)
    //   }
    // })

</script>
