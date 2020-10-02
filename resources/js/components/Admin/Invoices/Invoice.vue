<template>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- app invoice View Page -->
                <section class="invoice-view-wrapper">
                    <div class="row">
                        <!-- invoice view page -->
                        <div class="col-xl-9 col-md-8 col-12" id="printSection">
                            <div class="card invoice-print-area">
                                <div class="card-content">
                                    <div class="card-body pb-0 mx-25">
                                        <!-- header section -->
                                        <div class="row">
                                            <div class="col-xl-4 col-md-12">
                                                <span class="invoice-number mr-50">Invoice#</span>
                                                <span>{{ invoice.number }}</span>
                                            </div>
                                            <div class="col-xl-8 col-md-12">
                                                <div class="d-flex align-items-center justify-content-xl-end flex-wrap">
                                                    <div class="mr-3">
                                                        <small class="text-muted">Date Issue:</small>
                                                        <span>{{ invoice.created_at }}</span>
                                                    </div>
                                                    <!-- <div>
                                                        <small class="text-muted">Date Due:</small>
                                                        <span>08/10/2019</span>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- logo and title -->
                                        <div class="row my-3">
                                            <div class="col-6">
                                                <h4 class="text-primary">Invoice</h4>
                                                <!-- <span>Software Development</span> -->
                                            </div>
                                            <div class="col-6 d-flex justify-content-end">
                                                <img src="/assets/images/logo.png" alt="logo" height="46" width="164">
                                            </div>
                                        </div>
                                        <hr>
                                        <!-- invoice address and contact -->
                                        <div class="row invoice-info">
                                            <div class="col-6 mt-1">
                                                <h6 class="invoice-from">Bill From</h6>
                                                <div class="mb-1">
                                                    <span>RX Payments</span>
                                                </div>
                                                <div class="mb-1">
                                                    <span>17826 Davenport Rd, Dallas, TX 75252</span>
                                                </div>
                                                <div class="mb-1">
                                                    <span>prxorders@dermrxpharmacy.com</span>
                                                </div>
                                                <div class="mb-1">
                                                    <span>1 844 504 8772</span>
                                                </div>
                
                                            </div>
                                            <div class="col-6 mt-1">
                                                <h6 class="invoice-to">Bill To</h6>
                                                <div class="mb-1">
                                                    <span>{{ invoice.user.name }}</span>
                                                </div>
                                                <div class="mb-1">
                                                    <span>{{ invoice.patient.address }}, {{ invoice.patient.city }}, {{ invoice.patient.state }}, {{ invoice.patient.zip_code }}</span>
                                                </div>
                                                <div class="mb-1">
                                                    <span>{{ invoice.user.email }}</span>
                                                </div>
                                                <div class="mb-1">
                                                    <span>{{ invoice.user.phone }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <!-- product details table-->
                                    <div class="invoice-product-details table-responsive mx-md-25">
                                        <table class="table table-borderless mb-0">
                                            <thead>
                                                <tr class="border-0">
                                                    <th scope="col">RX Number</th>
                                                    <th scope="col">Item</th>
                                                    <th scope="col" v-if=" $auth.check() && $auth.user().role == 'admin' ">Qty</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col" v-if=" $auth.check() && $auth.user().role == 'admin' ">Transaction Status</th>
                                                    <th scope="col" class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="order in invoice.invoice_orders"
                                                    :key="order.id"
                                                    >
                                                    <td>{{ order.rx_number }}</td>
                                                    <td>{{ order.dispensed_item_name }}</td>
                                                    <td v-if=" $auth.check() && $auth.user().role == 'admin' ">x{{ order.dispensed_quantity }}</td>
                                                    <td>{{ order.current_transaction_status }}</td>
                                                    <td v-if=" $auth.check() && $auth.user().role == 'admin' ">{{ order.rx_status }}</td>
                                                    <td class="text-primary text-right font-weight-bold">${{ parseFloat(order.total_price_paid).toFixed(2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- invoice subtotal -->
                                    <div class="card-body pt-0 mx-25">
                                        <hr>
                                        <div class="row">
                                            <div class="col-4 col-sm-6 mt-75">
                                                <p>Thanks for your business.</p>
                                            </div>
                                            <div class="col-8 col-sm-6 d-flex justify-content-end mt-75">
                                                <div class="invoice-subtotal">
                                                    <div class="invoice-calc d-flex justify-content-between">
                                                        <span class="invoice-title">Total</span>
                                                        <span class="invoice-value">${{ parseFloat(invoice.amount).toFixed(2)}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- invoice action  -->
                        <div class="col-xl-3 col-md-4 col-12">
                            <div class="card invoice-action-wrapper shadow-none border">
                                <div class="card-body">
                                    <div class="invoice-action-btn">
                                        <button
                                            class="btn btn-primary btn-block invoice-send-btn"
                                            @click="emailInvoice"
                                            v-if="$auth.check() && $auth.user().role == 'admin'"
                                            >
                                            <i class="bx bx-send"></i>
                                            <span>Send Invoice Email</span>
                                        </button>
                                    </div>
                                    <div class="invoice-action-btn">
                                        <button
                                            class="btn btn-info btn-block invoice-send-btn"
                                            @click="smsInvoice"
                                            v-if="$auth.check() && $auth.user().role == 'admin'"
                                            >
                                            <i class="bx bx-mail-send"></i>
                                            <span>Send Invoice SMS</span>
                                        </button>
                                    </div>
                                    <div class="invoice-action-btn">
                                        <button @click="printSection" class="btn btn-light-primary btn-block invoice-print">
                                            <span>print</span>
                                        </button>
                                    </div>
                                    <div class="invoice-action-btn">
                                        <router-link
                                            :to="{
                                                name: 'checkout',
                                                params: { invoice: invoice.number }
                                            }"
                                            class="btn btn-success btn-block"
                                            >
                                            <i class='bx bx-dollar'></i>
                                            <span>Select to Pay</span>
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            invoice: {
                user: {},
                patient: {},
                order: {},
                payment: {}
            }
        };
    },
    created() {
        var app = this;
        this.axios
            .get(`/api/invoices/${this.$route.params.id}`)
            .then(response => {
                this.invoice = response.data;
            });
    },
    methods: {
        smsInvoice() {
            this.axios
                .post(`/api/sms/${this.$route.params.id}`, {})
                .then(response => {
                    this.$router.push({ name: "allinvoices" });
                });
        },

        emailInvoice() {
            this.axios
                .post(`/api/email/${this.$route.params.id}`, {
                    subject: "Available Prescription",
                    message:
                        "Don't forget! Your prescription from DermRx is now available. Place your invoice now."
                })
                .then(response => {
                    this.$router.push({ name: "allinvoices" });
                });
        },

        printSection() {
            this.$htmlToPaper("printSection");
        }
    }
};
</script>
