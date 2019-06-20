<template id="example">
    <div class="container" >
        <div class="row justify-content-center" id="apps">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 style="margin-top: 10px;display: inline-block;"><b>{{ namaFitur }}</b></h5>
                        <button class="btn btn-primary pull-right">Create <i class="fas fa-plus"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <filter-bar-component @keyupSearchinBox="onClickChild"></filter-bar-component>
                            <datatable-component :fields="fields"
                                                 :dataItems="dataItems"
                                                 :api="api"  
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
            let breadcrumb = '<router-link to="/destination">Destination</router-link>';
            $('#crumb').html(breadcrumb);
        },
        data() {
            return {
                namaFitur: this.$route.name,
                fields: [{
                  name: '__checkbox',   // <----
                  titleClass: 'center aligned parent-checker',
                  dataClass: 'center aligned child-checker'
                },{
                    name: 'name',
                    callback: 'allcap'
                }, {
                    name: 'slug',
                }, {
                    name: 'created_at',
                    title: 'Date',
                    titleClass: 'left aligned',
                    dataClass: 'left aligned',
                    sortField: 'created_at',
                    callback: 'formatDate|DD-MM-YYYY'
                }, {
                    name: 'created_by',
                    title: 'Created By',
                    titleClass: 'left aligned',
                    dataClass: 'left aligned',
                }, ],
                dataItems: null,
                api: '/api/destination/datatable?page=1'
            }
        },
        methods:{
            onClickChild(value){
                this.api = '/api/destination/datatable?page=1'
            }
        }
    }
    // new Vue({
    //   beforeCreate: function() {
    //     console.log(this.$appName)
    //   }
    // })

</script>
