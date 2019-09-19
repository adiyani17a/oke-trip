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

    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
        mounted() {
            console.log('Intialize Main Page...')
            let breadcrumb = '<router-link to="/privilege">Privilege</router-link>';
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
                    { text: 'Role', value: 'role_name',class:'text-xs-left',type:'default'},
                    { text: 'Menu', value: 'menu_list_name',class:'text-xs-left',type:'default'},
                    { text: 'Create', value: 'create' ,type:'switch',class:'text-xs-center'},
                    { text: 'Edit', value: 'edit' ,type:'switch',class:'text-xs-center'},
                    { text: 'Delete', value: 'delete' ,type:'switch',class:'text-xs-center'},
                    { text: 'Validation', value: 'validation' ,type:'switch',class:'text-xs-center'},
                ],
                loadingDataTable:false,
                apiReady:false,
                pagination:{
                    current: 1,
                    total: 0,
                    rowsPerPage:10, 
                    totalItems:0, 
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
                this.api = '/api/privilege/datatable'
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
                  .get('/api/privilege/datatable?page='+page+'&showing='+show)
                  .then(response => {
                    this.loadingDataTable = false
                    this.dataItem = response.data.data
                    this.pagination.current = response.data.current_page;
                    this.pagination.total = response.data.last_page;
                    this.pagination.rowsPerPage = show;
                    this.pagination.totalItems = response.data.total;
                    this.totalItem = response.data.total;
                    
                    for (var i = 0; i < this.dataItem.length; i++) {
                        if (this.dataItem[i].create == 'true') {
                            this.dataItem[i].create = true 
                        }else{
                            this.dataItem[i].create = false 
                        }

                        if (this.dataItem[i].edit == 'true') {
                            this.dataItem[i].edit = true 
                        }else{
                            this.dataItem[i].edit = false 
                        }

                        if (this.dataItem[i].delete == 'true') {
                            this.dataItem[i].delete = true 
                        }else{
                            this.dataItem[i].delete = false 
                        }

                        if (this.dataItem[i].validation == 'true') {
                            this.dataItem[i].validation = true 
                        }else{
                            this.dataItem[i].validation = false 
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
                    .post('/api/privilege/delete',{
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
                    .post('/api/privilege/change-status',{
                        data:data,
                        id:id,
                        param:param,
                    })
                    .then(response => {
                        this.snackbar =  true;
                        this.text =  response.data.message;
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

</script>
