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
                                                 @selectedCheckbox="selectedCheckbox"
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

            axios
              .get('/api/destination/datatable?page=1')
              .then(response => {
                this.dataItem = response.data.data

                $.each(this.dataitem,function(index, value){
                    this.dataItem.action.push('tes')
                });
              })
              .catch(error => {
                console.log(error)
                this.errored = true
              })
              .finally(() => this.loadingDataTable = true)
        },
        data() {
            return {
                namaFitur: this.$route.name,
                dataItem: [],
                select: [],
                headers:[
                    { text: 'Name', value: 'name',class:'text-xs-left'},
                    { text: 'Slug', value: 'slug' },
                ],
                loadingDataTable:false,
            }
        },
        methods:{
            onClickChild(value){
                this.api = '/api/destination/datatable'
            },
            selectedCheckbox(selected){
                this.select = selected;
            }
        }
    }
    // new Vue({
    //   beforeCreate: function() {
    //     console.log(this.$appName)
    //   }
    // })

</script>
