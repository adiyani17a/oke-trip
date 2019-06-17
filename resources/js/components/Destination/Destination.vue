<template id="example">
    <div class="container" >
        <div class="row justify-content-center" id="apps">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span>{{ this.$appName }}</span>
                        <button class="btn btn-primary pull-right"><i class="fas fa-plus"></i></button>
                    </div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
    Vue.prototype.$appName = 'My App'
            let breadcrumb = '';
            console.log(breadcrumb);
            $('#crumb').html(breadcrumb);
        }
    }

    new Vue({
      beforeCreate: function() {
        console.log(this.$appName)
      }
    })

</script>
