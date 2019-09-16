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
                        <v-btn v-if="select.length == 1 && select[0].status_payment == 'Pending'" color="info pull-right" @click="dialog=true">Approve
                            <v-icon dark right>fas fa-check</v-icon>
                        </v-btn>
                        <v-btn v-if="select.length == 1 && select[0].status_payment != 'Pending'" color="warning pull-right" @click="dialog=true">Preview Data
                            <v-icon dark right>fas fa-check</v-icon>
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
                                                 @selectedCheckbox="selectedCheckbox"
                                                 @callingApi="callingApi"
                                                 @switchChange="switchChange"
                                                 >
                            </datatable-component>
                        </div>
                    </div>
                    <template  style="z-index: 999999999999999999999">
                      <div class="text-xs-center">
                        <v-dialog
                          v-model="dialog"
                          width="1000"

                        >
                          <v-card>
                            <v-card-title
                              class="headline grey lighten-2"
                              primary-title
                            >
                                Payment List
                            </v-card-title>

                            <v-card-text>
                                <table class="table" v-if="select.length != 0">
                                    <tr>
                                        <td>Code</td>
                                        <td>: {{ select[0].code }}</td>
                                        <td>Date</td>
                                        <td>: {{ select[0].created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Payment</td>
                                        <td>: {{ select[0].total_payment | currency }}</td>
                                        <td>Payment Method</td>
                                        <td>: {{ select[0].payment_method }}</td>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <thead>
                                        <th class="border p-1">Proof</th>
                                        <th class="border p-1">Account Name</th>
                                        <th class="border p-1">Account Number</th>
                                        <th class="border p-1">Bank Name</th>
                                        <th class="border p-1">Date Payment</th>
                                        <th class="border p-1">Nominal</th>
                                    </thead>
                                    <tbody v-if="select.length != 0">
                                        <tr v-for="(item,i) in select[0].payment_history_d">
                                            <td class="text-center border p-2" style="width: 20%;">
                                                <img style="width: 100%;height: 100px;" :src="$root.url_image+item.image">       
                                            </td>
                                            <td class="text-center border p-2">{{ item.account_name }}</td>
                                            <td class="text-center border p-2">{{ item.account_number }}</td>
                                            <td class="text-center border p-2">{{ item.bank }}</td>
                                            <td class="text-center border p-2">{{ item.date }}</td>
                                            <td class="text-right border p-2">{{ item.nominal | currency }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-card-text>
                            <v-divider></v-divider>
                            <v-card-actions v-if="select.length != 0">
                              <v-spacer></v-spacer>
                              <v-btn
                                color="primary"
                                flat
                                @click="approveData('Approve')"
                                v-if="!approveLoading && select[0].status_payment == 'Pending'"
                              >
                                Approve
                              </v-btn>
                              <v-btn
                                color="primary"
                                flat
                                v-if="approveLoading && select[0].status_payment == 'Pending'"
                                >
                                <i class="fa fa-spin fa-spinner"></i>
                              </v-btn>
                              <v-btn
                                color="error"
                                flat
                                @click="approveData('Rejected')"
                                v-if="!approveLoading && select[0].status_payment == 'Pending'"
                              >
                                Reject
                              </v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>
                      </div>
                    </template>
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
            let breadcrumb = '<router-link to="/company">Payment List</router-link>';
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
                approveLoading:false,
                dialog: false,
                dialogDelete: false,
                approvePayment:false,
                headers: [{
                    text: 'Code',
                    value: 'code',
                    class: 'text-xs-left',
                    type: 'default'
                }, {
                    text: 'Total Payment',
                    value: 'total_payment',
                    type: 'currency',
                    class: 'text-xs-right',
                }, {
                    text: 'Status Payment',
                    value: 'status_payment',
                    type: 'label'
                }, {
                    text: 'Created At',
                    value: 'created_at',
                    type: 'default'
                },],
                loadingDataTable: false,
                apiReady: false,
                pagination: {
                    current: 1,
                    total: 0,
                    rowsPerPage: 10,
                    totalItem: 0,
                },
                totalItem: 0,
                currentPage: 1,
                dialog: false,
                idData: [],
                param: '',
                snackbar: false,
                color: 'success',
                mode: '',
                tes: '',
                timeout: 6000,
                text: 'Hello, I\'m a snackbar'
            }
        },
        watch: {
            apiReady: function() {
                console.log('Generate Token...')
                this.callingApi();
            },
        },
        methods: {
            onClickChild(value) {
                this.api = '/api/payment-list/datatable'
            },
            selectedCheckbox(selected) {
                this.select = selected;
                this.idData = selected;
            },
            callingApi(page, show) {
                if (show == undefined) {
                    show = 10;
                }

                if (page == undefined) {
                    page = this.currentPage;
                }
                axios
                    .get('/api/payment-list/datatable/'+this.$route.params.id+'?page=' + page + '&showing=' + show)
                    .then(response => {
                        this.loadingDataTable = false
                        this.dataItem = response.data.data.data
                        this.pagination.current = response.data.data.current_page;
                        this.pagination.total = response.data.data.last_page;
                        this.pagination.rowsPerPage = show;
                        this.pagination.totalItem = response.data.data.total;
                        this.totalItem = response.data.data.total;
                        for (var i = 0; i < this.dataItem.length; i++) {
                            if (this.dataItem[i].status_payment == 'Pending') {
                                this.dataItem[i].color = 'warning';
                            } else if (this.dataItem[i].status_payment == 'Approve') {
                                this.dataItem[i].color = 'primary';
                            } else if (this.dataItem[i].status_payment == 'Rejected') {
                                this.dataItem[i].color = 'error';
                            }

                            if (this.idData.length == 1 ) {
                                if (this.idData[0].id == this.dataItem[i].id) {
                                    this.idData[0] = undefined;
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    })
                    .finally(() => this.loadingDataTable = true, this.isLoading = false)
            },
            deleteData() {

                axios
                    .delete('/api/payment-list/delete', {
                        data: {
                            data: this.select,
                        }
                    })
                    .then(response => {
                        if (response.data.status == 1) {
                            this.snackbar = true;
                            this.text = response.data.message;
                            this.callingApi();
                            this.dialogDelete = false;
                            this.color = 'success';
                        } else {
                            this.snackbar = true;
                            this.text = response.data.message;
                            this.callingApi();
                            this.dialogDelete = false;
                            this.color = 'error';
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        this.snackbar = true;
                        this.text = error;
                        this.errored = true
                        this.dialogDelete = false;
                    })
            },
            editData() {
                this.idData = '';
                this.idData = this.select;
                this.dialog = true;

            },
            closeDialog(param) {
                this.dialog = false;
                this.callingApi();
            },
            confirmationDelete(param) {
                if (param == 'confirm') {
                    this.deleteData();
                } else {
                    this.dialogDelete = false;
                }
            },
            doAjax() {
                this.isLoading = true;
                // simulate AJAX
                setTimeout(() => {
                    this.isLoading = false
                }, 5000)
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },
            getCurrentPage(page) {
                this.currentPage = page;
                console.log(this.currentPage);
            },
            switchChange(data, id, param) {
                axios
                    .post('/api/payment-list/change-status', {
                        data: data,
                        id: id,
                        param: param,
                    })
                    .then(response => {
                        this.snackbar = true;
                        this.text = response.data.message;
                        this.callingApi();
                        this.dialogDelete = false;
                    })
                    .catch(error => {
                        console.log(error)
                        this.snackbar = true;
                        this.text = error;
                        this.errored = true
                        this.dialogDelete = false;
                    })
            },
            approveData(param){
                let formData = new FormData();
                this.approveLoading = true;
              
                formData.append('status_payment',param);
                formData.append('id',this.select[0].id);

                axios.post('/api/payment-list/update',
                        formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    )
                    .then(response => {
                        this.snackbar = true;
                        this.text = response.data.message;
                        if (response.data.status == 1) {
                            this.color = 'success'
                            this.approveLoading = false;
                            this.dialog =false;
                            this.select = [];
                            this.callingApi();

                        } else {
                            this.color = 'error'
                        }
                    })
                    .catch(error => {
                        this.snackbar = true;
                        this.text = error;
                        this.color = 'error'
                        this.dialog =false;
                        this.approveLoading = false;
                    })
            }
        }
    }
    // new Vue({
    //   beforeCreate: function() {
    //     console.log(this.$appName)
    //   }
    // })

</script>
