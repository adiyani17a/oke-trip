<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Income Report</div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <bar-chart :chart-data="datacollection"></bar-chart>
                            <button @click="fillData()">Randomize</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LineChart from './LineChart.js'
    import BarChart from './BarChart.js'
    export default {
        components: {
            LineChart,
            BarChart
        },
        data() {
            return {
                datacollection: {},
                apiReady: false,
            }
        },
        watch: {
            apiReady: function() {
                console.log('Generate Token...')
                this.callingApi();
            },
        },
        mounted() {
            console.log('Intialize Main Page...')
            let breadcrumb = '<router-link to="/income-report">Income Report</router-link>';
            $('#crumb').html(breadcrumb);
            axios
                .get('/api/get-token')
                .then(response => {
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.access_token;

                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => this.apiReady = true)
        },
        methods: {
            fillData() {
                this.datacollection = {
                    datasets: [{
                        label: 'Data One',
                        backgroundColor: '#f87979',
                        data: [this.getRandomInt()]
                    }, {
                        label: 'Data Two',
                        backgroundColor: '#f87979',
                        data: [this.getRandomInt()]
                    }]
                }
            },

            getRandomInt() {
                return Math.floor(Math.random() * (50 - 5 + 1)) + 5
            },
            callingApi(page, show) {
                if (show == undefined) {
                    show = 10;
                }

                if (page == undefined) {
                    page = this.currentPage;
                }
                axios
                    .get('/api/income-report/get-data/')
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    })
                    .finally(() => this.loadingDataTable = true, this.isLoading = false)
            },
        }
    }
</script>

<style>
  .small {
    max-width: 600px;
    margin:  150px auto;
  }
</style>