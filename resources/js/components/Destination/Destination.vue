<template id="example">
    <div class="container" >
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
                        <v-btn v-if="select.length == 1" color="error pull-right" @click="deleteData('single')">Delete
                            <v-icon dark right>fas fa-trash-alt</v-icon>
                        </v-btn>
                        <v-btn v-if="select.length > 1" color="error pull-right" @click="deleteData('bulk')">Bulk Delete
                            <v-icon dark right>fas fa-trash</v-icon>
                        </v-btn>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <datatable-component :dataItem="dataItem"
                                                 :headers="headers"
                                                 :loadingDataTable="loadingDataTable"
                                                 :pagination="pagination"
                                                 :totalItem="totalItem"
                                                 @selectedCheckbox="selectedCheckbox"
                                                 @callingApi="callingApi"
                                                 >
                            </datatable-component>
                        </div>
                        <create-destination :dialog="dialog" 
                                            :idData="idData" 
                                            @closeDialog="closeDialog"></create-destination>
                    </div>
                </div>
            </div>
        </div>  
    </div>

</template>
<script>

    Vue.component('create-destination', require('./CreateDestination.vue').default)


    export default {
        async mounted() {
            console.log('Intialize Main Page...')
            let breadcrumb = '<router-link to="/destination">Destination</router-link>';
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
        data() {
            return {
                namaFitur: this.$route.name,
                dataItem: [],
                select: [],
                dialog: false,
                headers:[
                    { text: 'Name', value: 'name',class:'text-xs-left'},
                    { text: 'Slug', value: 'slug' },
                    { text: 'Created At', value: 'created_at' },
                    { text: 'Action',value:'action'},
                ],
                loadingDataTable:false,
                apiReady:false,
                pagination:{
                    current: 1,
                    total: 0
                },
                totalItem:0,
                dialog:false,
                idData:[],

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
                this.api = '/api/destination/datatable'
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
                    page = 1;
                }
                axios
                  .get('/api/destination/datatable?page='+page+'&showing='+show)
                  .then(response => {
                    this.loadingDataTable = false
                    this.dataItem = response.data.data
                    this.pagination.current = response.data.current_page;
                    this.pagination.total = response.data.last_page;
                    this.totalItem = response.data.total;

                    for (var i = 0; i < this.dataItem.length; i++) {
                        let html = 'tes';

                        this.dataItem[i].action = html
                    }
                        
                  })
                  .catch(error => {
                    console.log(error)
                    this.errored = true
                  })
                  .finally(() => this.loadingDataTable = true)
            },
            deleteData(param){
                console.log(this.select)
            },
            editData(){
                this.idData = '';
                this.idData = this.select;
                this.dialog = true;

            },
            closeDialog(param){
                this.dialog = false;
                this.callingApi();
            }
        }
    }
    // new Vue({
    //   beforeCreate: function() {
    //     console.log(this.$appName)
    //   }
    // })

</script>
