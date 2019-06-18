<template id="example">
    <div class="container" >
        <div class="row justify-content-center" id="apps">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span style="margin-top: 10px;">{{ namaFitur }}</span>
                        <button class="btn btn-primary pull-right">Create <i class="fas fa-plus"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <datatable-component v-bind:fields="field" v-bind:items="item"></datatable-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            let breadcrumb = '<router-link to="/destination">Destination</router-link>';
            $('#crumb').html(breadcrumb);
            axios.get('/api/destination/datatable?page=1')
            .then(response => {
                this.item = response.data
            })
            .catch(e => {
                this.errors.push(e)
            })
        },
        data() {
            return {
                namaFitur: this.$route.name,
                field: ['<input type="checkbox">','tes1','tes2'],
                item:Array
            }
        },
    }
    // new Vue({
    //   beforeCreate: function() {
    //     console.log(this.$appName)
    //   }
    // })

</script>
