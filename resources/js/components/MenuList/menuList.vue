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
                                                 @getCurrentPage="getCurrentPage"
                                                 @selectedCheckbox="selectedCheckbox"
                                                 @callingApi="callingApi"
                                                 >
                            </datatable-component>
                        </div>
                        <create-menu-list :dialog="dialog" 
                                            :idData="idData" 
                                            :options="options" 
                                            @closeDialog="closeDialog"></create-menu-list>
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

    Vue.component('create-menu-list', require('./createMenuList.vue').default)

    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
        mounted() {
            console.log('Intialize Main Page...')
            let breadcrumb = '<router-link to="/menu-list">Menu List</router-link>';
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
                    { text: 'Name', value: 'name',class:'text-xs-left'},
                    { text: 'Slug', value: 'slug' },
                    { text: 'Icon', value: 'icon' },
                    { text: 'Url', value: 'url' },
                    { text: 'Group Menu', value: 'group_menu_name' },
                    { text: 'Created At', value: 'created_at' },
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
                dialog:false,
                idData:[],
                param:'',
                snackbar: false,
                color: 'success',
                mode: '',
                options:[],
                currentPage:1,
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
                this.api = '/api/menu-list/datatable'
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
                  .get('/api/menu-list/datatable?page='+page+'&showing='+show)
                  .then(response => {
                    this.loadingDataTable = false
                    this.dataItem = response.data.data.data
                    this.pagination.current = response.data.data.current_page;
                    this.pagination.total = response.data.data.last_page;
                    this.pagination.rowsPerPage = show;
                    this.pagination.totalItem = response.data.data.total;
                    this.totalItem = response.data.data.total;
                    for (var i = 0; i < response.data.groupMenuList.length; i++) {
                        this.options.push({
                            text:response.data.groupMenuList[i].name,
                            value:response.data.groupMenuList[i].id
                        })
                    }

                    for (var i = 0; i < this.dataItem.length; i++) {
                        let html = 'tes';

                        this.dataItem[i].action = html
                    }
                    this.isLoading = false;
                  })
                  .catch(error => {
                    console.log(error)
                    this.errored = true
                  })
                  .finally(() => this.loadingDataTable = true)
            },
            deleteData(){
                axios
                    .post('/api/menu-list/delete',{
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
                console.log(this);
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
            }
        }
    }
    // new Vue({
    //   beforeCreate: function() {
    //     console.log(this.$appName)
    //   }
    // })

</script>
