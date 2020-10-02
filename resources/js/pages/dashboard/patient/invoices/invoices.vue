<template>
    <div class="content">
        <div class="content-body">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                        <p>{{ $route.meta.subtitle }}</p>
                    </div>
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a 
                                    class="nav-link"
                                    v-bind:class="{ 'active': statusFilter == 'Open' }"
                                    id="all-tab" 
                                    href="javascript:void(0)" 
                                    @click="statusFilter = 'Open'"
                                >All</a>
                            </li>
                            <li class="nav-item">
                                <a 
                                    class="nav-link" 
                                    v-bind:class="{ 'active': statusFilter == 'Pending' }"
                                    id="pending-tab" 
                                    href="javascript:void(0)" 
                                    @click="statusFilter = 'Pending'"
                                >Pending</a>
                            </li>
                            <li class="nav-item">
                                <a 
                                    class="nav-link" 
                                    v-bind:class="{ 'active': statusFilter == 'Cancelled' }"
                                    id="cancelled-tab" 
                                    href="javascript:void(0)" 
                                    @click="statusFilter = 'Cancelled'"
                                >Cancelled</a>
                            </li>
                            <li class="nav-item">
                                <a 
                                    class="nav-link" 
                                    v-bind:class="{ 'active': statusFilter == 'Completed' }"
                                    id="completed-tab" 
                                    href="javascript:void(0)" 
                                    @click="statusFilter = 'Completed'"
                                >Completed</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
                                <div class="table-responsive pmd-table-card">
                                    <div class="row m-0 mb-2">
                                        <div class="col-lg-4 px-0">
                                            <input type="text" class="form-control" placeholder="Search Here..." v-model="search">
                                        </div>
                                    </div>

                                    <div>
                                        <custom-data-table 
                                            :headers="dataTableHeaders"
                                            :records="invoices.filter(data => data.full_record.status == statusFilter)"
                                        >
                                            <template v-slot:information="scope">
                                                <div class="row m-0 pb-2">
                                                    <div class="col-lg-2 px-0">
                                                        <router-link
                                                            v-if="scope.record.full_record.status  != 'Completed' && 
                                                                scope.record.full_record.status  != 'Cancelled' 
                                                                && isMirror == 0"
                                                            :to="{
                                                                name: 'checkout',
                                                                params: { invoice: scope.record.data.number }
                                                            }"
                                                            tag="button"
                                                            class="btn btn-block btn-success"
                                                        >
                                                            PAY INVOICE
                                                        </router-link>
                                                    </div>
                                                    <div class="col-lg-7 px-0"></div>
                                                    <div class="col-lg-3 px-0 text-lg-right mt-2 mt-lg-0">
                                                        <h5 class="mb-0">{{ scope.record.data.number }}</h5>
                                                        <small class="text-primary">NUMBER</small>
                                                    </div>

                                                    <div class="col-lg-12 px-0 pt-3">
                                                        <h5 class="mb-0 text-primary">DISPENSED ITEMS:</h5>
                                                        <hr>

                                                        <div class="row m-0" v-for="dispensedItems in scope.record.full_record.invoice_orders">
                                                            <div class="col-lg-3 pb-2">
                                                                <p class="d-block mb-0">{{ dispensedItems.dispensed_item_name }}</p>
                                                                <small class="text-primary">ITEM NAME</small>
                                                            </div>
                                                            <div class="col-lg-3 pb-2">
                                                                <p class="d-block mb-0">{{ dispensedItems.rx_number }}</p>
                                                                <small class="text-primary">RX NUMBER</small>
                                                            </div>
                                                            <div class="col-lg-3 pb-2">
                                                                <p class="d-block mb-0">${{ dispensedItems.total_price_paid }}</p>
                                                                <small class="text-primary">ITEM TOTAL PAYABLE</small>
                                                            </div>
                                                            <div class="col-lg-3 pb-2">
                                                                <p class="d-block mb-0">{{ dispensedItems.current_transaction_status.toUpperCase() }}</p>
                                                                <small class="text-primary">STATUS</small>
                                                            </div>
                                                            <div class="col-lg-12 px-0">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                        <div class="row m-0">
                                                            <div class="col-lg-12 px-0">
                                                                <span class="text-primary">TOTAL: ${{ scope.record.full_record.amount }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </custom-data-table>
                                    </div>
                                    
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
                                </div>
                            </div>
                        </div>
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
            formattedInvoices: [],
            statusFilter: 'Open',
            search: '',
            searchWait: null,
            totalPages: 1,
            currentPage: 1,

            invoices: [],
            
            dataTableHeaders: [
                {
                    label: 'Invoice Number',
                    index: 'number'
                },
                {
                    label: 'Number of Items Dispensed',
                    index: 'dispensed_items_count'
                },
                {
                    label: 'Created On',
                    index: 'created_on'
                }
            ],

            isMirror: 0
        };
    },
    watch: {
        search (value) {
            if (this.searchWait) {
                clearTimeout(this.searchWait);
            }

            this.searchWait = setTimeout(() => {
                this.currentPage = 1;
                this.getInvoices(1);
            }, 1000);
        },

        currentPage (value) {
            this.getInvoices(value);
        }
    },
    mounted() {
        this.getInvoices();

        let mirror = localStorage.getItem('mirrorView');
        this.isMirror = mirror ? mirror : 0;

        console.log("dsad", this.isMirror)
    },
    methods: {
        deleteInvoice(id) {
            this.axios.delete(`/api/invoices/${id}`).then(response => {
                let i = this.invoices.map(item => item.id).indexOf(id); // find index of your object
                this.invoices.splice(i, 1);
            });
        },

        getInvoices(page = 1) {
            console.log("Getting invoices...");

            let queries = {
                page: page,
                user_id: this.$auth.user().id
            };

            if (this.search) {
                queries['searchQuery'] = this.search;
            }

            let stringifiedQuery = QueryString.stringify(queries);
            this.axios.get(`/api/invoices?` + stringifiedQuery).then(response => {
                this.totalPages = response.data.last_page;
                this.invoices = [];

                for (let counter = 0; counter < response.data.data.length; counter++) {
                    let objectToPush = {
                        data: {
                            number: response.data.data[counter]['number'],
                            dispensed_items_count: response.data.data[counter]['invoice_orders'].length,
                            created_on: response.data.data[counter]['created_at']
                        },
                        full_record: response.data.data[counter]
                    }

                    this.invoices.push(objectToPush);
                }
            });
        },
    }
};
</script>
