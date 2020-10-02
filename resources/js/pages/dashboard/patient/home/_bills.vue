<template>
    <div class="row">
        <div class="col-md-12">
            <!-- <div class="row m-0 mb-2">
                <div class="col-lg-4 px-0">
                    <input type="text" class="form-control" placeholder="Search Here..." v-model="search" name="">
                </div>
            </div> -->

            <custom-data-table 
                :headers="dataTableHeaders"
                :records="invoices.filter(data => data.full_record.status == 'Open' || data.full_record.status == 'Pending')"
            >
                <template v-slot:information="scope">
                    <div class="row m-0 pb-2">
                        <div class="col-lg-2 px-0">
                            <router-link
                                v-if="scope.record.full_record.status  != 'Completed' && 
                                    scope.record.full_record.status  != 'Cancelled'"
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
                                <div class="col-lg-4 pb-2 px-0">
                                    <p class="d-block mb-0">{{ dispensedItems.dispensed_item_name }}</p>
                                    <small class="text-primary">ITEM NAME</small>
                                </div>
                                <div class="col-lg-4 pb-2 px-0">
                                    <p class="d-block mb-0">${{ dispensedItems.total_price_paid }}</p>
                                    <small class="text-primary">ITEM TOTAL PAYABLE</small>
                                </div>
                                <div class="col-lg-4 pb-2 px-0">
                                    <p class="d-block mb-0">{{ dispensedItems.pharmacy_name }}</p>
                                    <small class="text-primary">PHARMACY</small>
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

            <router-link :to="{ name: 'patient_orders' }" class="btn btn-outline-primary mt-2"  v-if="invoices.length > 0 && invoices.length > 10">
                View More
            </router-link>


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
</template>

<script>
import QueryString from 'query-string';

export default {
    data() {
        return {
            search: '',
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
            invoices: [],
        };
    },
    mounted() {
        this.getInvoices();
    },
    methods: {
        getInvoices(page = 1) {
            console.log("Getting invoices...");

            let queries = { page: page, user_id: this.$auth.user().id };
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
