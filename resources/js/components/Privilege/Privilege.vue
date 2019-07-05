<template>
    <div class="container">
        <loading :active.sync="isLoading" 
                :can-cancel="true" 
                :is-full-page="fullPage">    
        </loading>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-between align-center mb-3">
                  <v-btn @click="all">all</v-btn>
                  <v-btn @click="none">none</v-btn>
                </div>
                <v-expansion-panel
                  v-model="panel"
                  expand
                >
                    <v-expansion-panel-content
                    v-for="(item,i) in items"
                    :key="i"
                    >
                        <template v-slot:header>
                          <div>Item</div>
                        </template>
                        <v-card>
                          <v-card-text>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</v-card-text>
                        </v-card>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </div>
        </div>
    </div>
</template>

<script>
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {

        mounted(){
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
                panel: [],
                items: [],
                isLoading: true,
                fullPage: true,
                apiReady:false,

            }
        },
        watch:{
            apiReady:function(){
                console.log('Generate Token...')
                this.callingApi();
            },
        },
        methods: {
            // Create an array the length of our items
            // with all values as true
            all() {
                this.panel = [...Array(this.items).keys()].map(_ => true)
            },
            // Reset the panel
            none() {
                this.panel = []
            },
            callingApi(){
                // axios
                //   .get('/api/privilege/get-data?page='+page+'&showing='+show)
                //   .then(response => {
                    
                //     this.isLoading = false;
                //   })
                //   .catch(error => {
                //     console.log(error)
                //     this.errored = true
                //   })
                //   .finally(() => this.loadingDataTable = true)
            }
        }
    }
</script>