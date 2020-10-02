<template>
    <div class="content">
        <div class="content-body">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                        <p>{{ $route.meta.subtitle }}</p>

                        <div class="row m-0 mb-2">
                            <div class="col-lg-4 px-0">
                                <input type="text" class="form-control" placeholder="Search Here..." v-model="search" name="">
                            </div>
                        </div>

                        <custom-data-table 
                            :headers="dataTableHeaders"
                            :records="paymentList"
                        >
                            <template v-slot:information="scope">
                                <div class="row m-0">
                                    <div class="col-lg-12 mb-2">
                                        <router-link :to="{
                                            name: 'patient_view_invoice',
                                            params: {
                                                id: scope.record.full_record.invoice.number
                                            }
                                        }" class="btn btn-secondary">
                                            View Receipt
                                        </router-link>
                                    </div>

                                    <div class="col-lg-4">
                                        <h6 class="text-primary mb-0">{{ scope.record.full_record.invoice.number }}</h6>
                                        <small>INVOICE NUMBER</small>
                                    </div>
                                    <div class="col-lg-4">
                                        <h6 class="text-primary mb-0">{{ scope.record.data.status.toUpperCase() }}</h6>
                                        <small>STATUS</small>
                                    </div>

                                    <div class="col-lg-12">
                                        <hr>
                                    </div>

                                    <div class="col-lg-12">
                                        <h6 class="text-primary mb-2">ITEMS DISPENSED</h6>

                                        <ul class="m-0 pl-2">
                                            <li v-for="(invoice_order, invoice_order_index) in scope.record.full_record.invoice_orders" class="mb-1">
                                                <small class="text-primary d-block" style="margin-bottom: 5px;">
                                                    <span class="text-secondary">NAME: </span>
                                                    {{ invoice_order.dispensed_item_name }}
                                                </small>
                                                <small class="text-primary d-block" style="margin-bottom: 5px;">
                                                    <span class="text-secondary">PRICE: </span>
                                                    ${{ invoice_order.total_price_paid }}
                                                </small>
                                                <hr v-if="invoice_order_index + 1 < scope.record.full_record.invoice_orders.length">
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-12">
                                        <hr>
                                        <span class="text-primary">TOTAL:</span> ${{ scope.record.data.amount }}
                                    </div>
                                </div>
                            </template>
                        </custom-data-table>

                        <div class="row m-0">
                            <div class="col-md-4 col-lg-2 px-0 mt-3">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            Page: 
                                        </span>
                                    </div>
                                    
                                    <select class="form-control text-right" v-model="currentPage">
                                        <option v-for="counter in totalPages" :value="counter">{{ counter }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <!-- <div class="table-responsive pmd-table-card">
                            <table id="payment-listing" class="table pmd-table">
                                <thead>
                                    <tr>
                                        <th>Dispensed Item</th>
                                        <th>Invoice</th>
                                        <th>Amount</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Receipt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="payment in payments.data" :key="payment.id">
                                        <td class="font-weight-bold text-left">
                                            <span
                                                v-for="order in payment.invoice_orders"
                                                :key="order.id"
                                                >
                                                <li>
                                                    {{ order.dispensed_item_name }}
                                                </li>
                                            </span>
                                        </td>
                                        <td data-title="Invoice">
                                            {{ payment.invoice.number }}
                                        </td>
                                        <td data-title="Amount">${{ payment.amount }}</td>
                                        <td data-title="Date">{{ payment.created_at }}</td>
                                        <td data-title="Status" class="text-capitalize">
                                            {{ payment.status }}
                                        </td>
                                        <td>
                                            <router-link
                                                :to="{
                                                    name: 'patient_view_invoice',
                                                    params: {
                                                        id: payment.invoice.number
                                                    }
                                                }"
                                                tag="button"
                                                class="btn btn-primary btn-rounded"
                                            >
                                                <i class="bx bx-receipt"></i>
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import QueryString from 'query-string';

export default {
    data() {
        return {
            search: '',
            currentPage: 1,
            totalPages: 1,

            dataTableHeaders: [
                // {
                //     label: 'Dispensed Item',
                //     index: 'dispensed_item'
                // },
                {
                    label: 'Invoice',
                    index: 'invoice'
                },
                {
                    label: 'Amount',
                    index: 'amount'
                },
                {
                    label: 'Created On',
                    index: 'created_on'
                },
                {
                    label: 'Status',
                    index: 'status'
                }
            ],
            paymentList: [],

            payments: {},
            paymentObject: {}
        };
    },
    watch: {
        search (value) {
            if (this.searchWait) {
                clearTimeout(this.searchWait);
            }

            this.searchWait = setTimeout(() => {
                this.currentPage = 1;
                this.getPayments(1);
            }, 1000);
        },

        currentPage (value) {
            this.getPayments(value);
        }
    },
    mounted() {
        this.getPayments();
    },
    methods: {
        deletePayment(id) {
            this.axios.delete(`/api/payments/${id}`).then(response => {
                let i = this.payments.map(item => item.id).indexOf(id); // find index of your object
                this.payments.splice(i, 1);
            });
        },

        getPayments(page = 1) {
            
            let queries = {
                page: page,
                user_id: this.$auth.user().id
            };

            if (this.search) {
                queries['searchQuery'] = this.search;
            }

            let stringifiedQuery = QueryString.stringify(queries);

            this.axios.get(`/api/payments?` + stringifiedQuery).then(response => {
                this.totalPages = response.data.last_page;
                this.paymentList = [];

                for (let counter = 0; counter < response.data.data.length; counter++) {
                    let objectToPush = {
                        data: {
                            invoice: response.data.data[counter]['invoice']['number'],
                            amount: response.data.data[counter]['amount'],
                            created_on: response.data.data[counter]['created_at'],
                            status: response.data.data[counter]['status']
                        },
                        full_record: response.data.data[counter]
                    };

                    this.paymentList.push(objectToPush);
                }

                console.log("PAYMENT LIST: ", this.paymentList);

                this.payments = response.data;
            });
        }
    }
};
</script>
