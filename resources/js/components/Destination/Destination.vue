<template id="example">
    <div class="container" >
        <div class="row justify-content-center" id="apps">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 style="margin-top: 10px;display: inline-block;"><b>{{ namaFitur }}</b></h5>
                        <v-btn color="primary pull-right" dark>Accept
                            <v-icon dark right>fas fa-plus</v-icon>
                        </v-btn>
                        <v-btn v-if="select.length != 0" color="error pull-right">Bulk Delete
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        async mounted() {
            console.log('Intialize Main Page...')
            let breadcrumb = '<router-link to="/destination">Destination</router-link>';
            $('#crumb').html(breadcrumb);
            this.callingApi()
        },
        data() {
            return {
                namaFitur: this.$route.name,
                dataItem: [],
                select: [],
                headers:[
                    { text: 'Name', value: 'name',class:'text-xs-left'},
                    { text: 'Slug', value: 'slug' },
                    { text: 'Created At', value: 'created_at' },
                    { text: 'Action', value: 'action',class:'text-xs-center'},
                ],
                loadingDataTable:false,
                pagination:{
                    current: 1,
                    total: 0
                },
                totalItem:0,
            }
        },
        methods:{
            onClickChild(value){
                this.api = '/api/destination/datatable'
            },
            selectedCheckbox(selected){
                this.select = selected;
            },
            callingApi(page,show){
                console.log(page)
                console.log(show)
                if (show == undefined) {
                    show = 10;
                }
                axios
                  .get('/api/destination/datatable?page='+page+'&showing='+show)
                  .then(response => {
                    this.loadingDataTable = false
                    this.dataItem = response.data.data
                    this.pagination.current = response.data.current_page;
                    this.pagination.total = response.data.last_page;
                    this.totalItem = response.data.total;

                    $.each(this.dataitem,function(index, value){
                        this.dataItem.action.push('tes')
                    });
                  })
                  .catch(error => {
                    console.log(error)
                    this.errored = true
                  })
                  .finally(() => this.loadingDataTable = true)
            }
        }
    }
    // new Vue({
    //   beforeCreate: function() {
    //     console.log(this.$appName)
    //   }
    // })

</script>
