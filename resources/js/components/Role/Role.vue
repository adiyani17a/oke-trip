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
                        <v-btn v-if="select.length == 0" color="primary pull-right" dark @click="dialog = true">Create
                            <v-icon dark right>fas fa-plus</v-icon>
                        </v-btn>
                        <v-btn v-if="select.length == 1" color="warning pull-right" @click="editData">Edit
                            <v-icon dark right>fas fa-pencil-alt</v-icon>
                        </v-btn>
                        <v-btn v-if="select.length == 1" color="error pull-right" @click="dialogDelete = true">Delete
                            <v-icon dark right>fas fa-trash-alt</v-icon>
                        </v-btn>
                        <v-btn v-if="select.length > 1" color="error pull-right" @click="dialogDelete = true">Bulk Delete
                            <v-icon dark right>fas fa-trash</v-icon>
                        </v-btn>
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
                        <create-role :dialog="dialog" 
                                            :idData="idData" 
                                            @closeDialog="closeDialog"></create-role>
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

    Vue.component('create-role', require('./createRole.vue').default)

    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
        mounted() {
            console.log('Intialize Main Page...')
            let breadcrumb = '<router-link to="/role">Role</router-link>';
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
                fullPage: true,
                dialog: false,
                dialogDelete: false,
                headers:[
                    { text: 'Name', value: 'name',class:'text-xs-left',type:'default'},
                    { text: 'Note', value: 'note' ,type:'default'},
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
                this.api = '/api/role/datatable'
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
                  .get('/api/role/datatable?page='+page+'&showing='+show)
                  .then(response => {
                    this.loadingDataTable = false
                    this.dataItem = response.data.data
                    this.pagination.current = response.data.current_page;
                    this.pagination.total = response.data.last_page;
                    this.pagination.rowsPerPage = show;
                    this.pagination.totalItem = response.data.total;
                    this.totalItem = response.data.total;
                    for (var i = 0; i < this.dataItem.length; i++) {
                        if (this.dataItem[i].active == 'true') {
                            this.dataItem[i].active = true 
                        }else{
                            this.dataItem[i].active = false 
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
                    .post('/api/role/delete',{
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
                    .post('/api/role/change-status',{
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
            }
        }
    }
    // new Vue({
    //   beforeCreate: function() {
    //     console.log(this.$appName)
    //   }
    // })

</script>
