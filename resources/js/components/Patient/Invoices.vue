<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="font-weight-bold">
                                My Invoices
                                <router-link to="/" class="font-weight-bold float-right">
                                    <i class="ti-home"></i>
                                </router-link>
                            </h4>
                        </div>
                        <div class="col-md-12">

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">All</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Pending</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="cancelled-tab" data-toggle="tab" href="#cancelled" role="tab" aria-controls="cancelled" aria-selected="false">Cancelled</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">Completed</a>
                                </li>
                            </ul>


                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="table-responsive pmd-table-card">
                                        <table id="invoice-listing" class="table pmd-table">
                                            <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <!-- <th>Amount</th> -->
                                                    <th>Dispensed Item</th>
                                                    <th>Created On</th>
                                                    <th>Invoice Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="invoice in invoices.data" :key="invoice.id">
                                                    <template v-if="invoice.status === 'Open'">
                                                        <td data-title="Number">
                                                            {{ invoice.number }}
                                                        </td>
                                                        <!-- <td data-title="Amount">
                                                            ${{ invoice.amount }}
                                                        </td> -->
                                                        <td data-title="">
                                                            <span
                                                                v-for="order in invoice.invoice_orders"
                                                                :key="order.id"
                                                            >
                                                                <li
                                                                    v-if="
                                                                        order.current_transaction_status !==
                                                                            'Completed'
                                                                    "
                                                                >
                                                                    {{ order.dispensed_item_name }}
                                                                </li>
                                                            </span>
                                                        </td>
                                                        <td data-title="Created On">
                                                            {{ invoice.created_at }}
                                                        </td>
                                                        <td>
                                                            <router-link
                                                                v-if="invoice.status !== 'Open'"
                                                                :to="{
                                                                    name: 'viewinvoice',
                                                                    params: { id: invoice.id }
                                                                }"
                                                                tag="button"
                                                                class="btn btn-info btn-block"
                                                            >
                                                                <i class="bx bx-show pr-2"></i>
                                                                View invoice
                                                            </router-link>

                                                            <router-link
                                                                v-if="invoice.status == 'Open' && isMirror == 0"
                                                                :to="{
                                                                    name: 'checkout',
                                                                    params: { invoice: invoice.number }
                                                                }"
                                                                data-toggle="tooltip"
                                                                title="Select To Pay"
                                                                tag="button"
                                                                class="btn btn-primary btn-block"
                                                            >
                                                                <i class="bx bx-credit-card pr-2"></i>
                                                                Select To Pay
                                                            </router-link>
                                                        </td>
                                                    </template> 
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="6" class="text-left pl-2">
                                                    <pagination
                                                        :limit="1"
                                                        :data="invoices"
                                                        @pagination-change-page="getInvoices"
                                                    ></pagination>
                                                </td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade show" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                    <div class="table-responsive pmd-table-card">
                                        <table id="invoice-listing" class="table pmd-table">
                                            <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <!-- <th>Amount</th> -->
                                                    <th>Dispensed Item</th>
                                                    <th>Created On</th>
                                                    <th>Invoice Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="invoice in invoices.data" :key="invoice.id">
                                                    <template v-if="invoice.status === 'Pending'">
                                                        <td data-title="Number">
                                                            {{ invoice.number }}
                                                        </td>
                                                        <!-- <td data-title="Amount">
                                                            ${{ invoice.amount }}
                                                        </td> -->
                                                        <td data-title="">
                                                            <span
                                                                v-for="order in invoice.invoice_orders"
                                                                :key="order.id"
                                                            >
                                                                <li
                                                                    v-if="
                                                                        order.current_transaction_status !==
                                                                            'Completed'
                                                                    "
                                                                >
                                                                    {{ order.dispensed_item_name }}
                                                                </li>
                                                            </span>
                                                        </td>
                                                        <td data-title="Created On">
                                                            {{ invoice.created_at }}
                                                        </td>
                                                        <td>
                                                            <router-link
                                                                v-if="invoice.status !== 'Open' && isMirror == 0"
                                                                :to="{
                                                                    name: 'view_invoice',
                                                                    params: { id: invoice.id }
                                                                }"
                                                                tag="button"
                                                                class="btn btn-info btn-block"
                                                            >
                                                                <i class="bx bx-show pr-2"></i>
                                                                Pay Invoice
                                                            </router-link>

                                                            <router-link
                                                                v-if="invoice.status == 'Open'"
                                                                :to="{
                                                                    name: 'checkout',
                                                                    params: { invoice: invoice.number }
                                                                }"
                                                                data-toggle="tooltip"
                                                                title="Select To Pay"
                                                                tag="button"
                                                                class="btn btn-primary btn-block"
                                                            >
                                                                <i class="bx bxs-credit-card pr-2"></i>
                                                                Select To Pay
                                                            </router-link>
                                                        </td>
                                                    </template> 
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="6" class="text-left pl-2">
                                                    <pagination
                                                        :limit="1"
                                                        :data="invoices"
                                                        @pagination-change-page="getInvoices"
                                                    ></pagination>
                                                </td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>


                                <div class="tab-pane fade show" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                                    <div class="table-responsive pmd-table-card">
                                        <table id="invoice-listing" class="table pmd-table">
                                            <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <!-- <th>Amount</th> -->
                                                    <th>Dispensed Item</th>
                                                    <th>Created On</th>
                                                    <th>Invoice Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="invoice in invoices.data" :key="invoice.id">
                                                    <template v-if="invoice.status === 'Cancelled'">
                                                        <td data-title="Number">
                                                            {{ invoice.number }}
                                                        </td>
                                                        <!-- <td data-title="Amount">
                                                            ${{ invoice.amount }}
                                                        </td> -->
                                                        <td data-title="">
                                                            <span
                                                                v-for="order in invoice.invoice_orders"
                                                                :key="order.id"
                                                            >
                                                                <li
                                                                    v-if="
                                                                        order.current_transaction_status !==
                                                                            'Completed'
                                                                    "
                                                                >
                                                                    {{ order.dispensed_item_name }}
                                                                </li>
                                                            </span>
                                                        </td>
                                                        <td data-title="Created On">
                                                            {{ invoice.created_at }}
                                                        </td>
                                                        <td>
                                                            <router-link
                                                                v-if="invoice.status !== 'Open'"
                                                                :to="{
                                                                    name: 'viewinvoice',
                                                                    params: { id: invoice.id }
                                                                }"
                                                                tag="button"
                                                                class="btn btn-dark btn-block btn-sm"
                                                            >
                                                                <i class="ti-eye pr-2"></i>
                                                                View invoice
                                                            </router-link>

                                                            <router-link
                                                                v-if="invoice.status == 'Open'"
                                                                :to="{
                                                                    name: 'checkout',
                                                                    params: { invoice: invoice.number }
                                                                }"
                                                                data-toggle="tooltip"
                                                                title="Select To Pay"
                                                                tag="button"
                                                                class="btn btn-dark btn-block btn-sm"
                                                            >
                                                                <i class="ti-credit-card pr-2"></i>
                                                                Select To Pay
                                                            </router-link>
                                                        </td>
                                                    </template> 
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="6" class="text-left pl-2">
                                                    <pagination
                                                        :limit="1"
                                                        :data="invoices"
                                                        @pagination-change-page="getInvoices"
                                                    ></pagination>
                                                </td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>


                                <div class="tab-pane fade show" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                                    <div class="table-responsive pmd-table-card">
                                        <table id="invoice-listing" class="table pmd-table">
                                            <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <!-- <th>Amount</th> -->
                                                    <th>Dispensed Item</th>
                                                    <th>Created On</th>
                                                    <th>Invoice Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="invoice in invoices.data" :key="invoice.id">
                                                    <template v-if="invoice.status === 'Completed'">
                                                        <td data-title="Number">
                                                            {{ invoice.number }}
                                                        </td>
                                                        <!-- <td data-title="Amount">
                                                            ${{ invoice.amount }}
                                                        </td> -->
                                                        <td data-title="">
                                                            <span
                                                                v-for="order in invoice.invoice_orders"
                                                                :key="order.id"
                                                            >
                                                                <li
                                                                    v-if="
                                                                        order.current_transaction_status !==
                                                                            'Completed'
                                                                    "
                                                                >
                                                                    {{ order.dispensed_item_name }}
                                                                </li>
                                                            </span>
                                                        </td>
                                                        <td data-title="Created On">
                                                            {{ invoice.created_at }}
                                                        </td>
                                                        <td>
                                                            <router-link
                                                                :to="{
                                                                    name: 'view_invoice',
                                                                    params: { id: invoice.id }
                                                                }"
                                                                tag="button"
                                                                class="btn btn-success btn-block"
                                                            >
                                                                <i class="bx bx-show pr-2"></i>
                                                                Receipts & Tracking
                                                            </router-link>
                                                        </td>
                                                    </template> 
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="6" class="text-left pl-2">
                                                    <pagination
                                                        :limit="1"
                                                        :data="invoices"
                                                        @pagination-change-page="getInvoices"
                                                    ></pagination>
                                                </td>
                                            </tfoot>
                                        </table>
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
export default {
    data() {
        return {
            invoices: {},
            isMirror: 0
        };
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
            let p = page == 1 ? "" : "&page=" + page;
            this.axios
                .get(`/api/invoices?user_id=${this.$auth.user().id}` + p)
                .then(response => {
                    this.invoices = response.data;
                });
        }
    }
};
</script>
