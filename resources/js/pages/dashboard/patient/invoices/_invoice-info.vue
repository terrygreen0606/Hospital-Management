<template>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- app invoice View Page -->
                <section class="invoice-view-wrapper">
                    <div class="row">
                        <!-- invoice view page -->
                        <div class="col-xl-12 col-md-8 col-12" id="printSection">
                            <div class="card invoice-print-area">
                                <div class="card-content">
                                    <div class="card-body pb-0 mx-25">
                                        <!-- header section -->
                                        <div class="row">
                                            <div class="col-xl-4 col-md-12">
                                                <!-- <span class="invoice-number mr-50">Invoice#</span>
                                                <span>{{ invoice.number }}</span> -->
                                            </div>
                                            <div class="col-xl-8 px-0 col-md-12">
                                                <div class="d-flex align-items-center justify-content-xl-end flex-wrap">
                                                    <div class="mr-2">
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
                                                <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                                                <p>{{ $route.meta.subtitle }}</p>
                                                <button @click="printSection" class="btn btn-light-primary invoice-print">
                                                    <span>Print Receipt</span>
                                                </button>
                                                <!-- <span>Software Development</span> -->
                                            </div>
                                            <div class="col-6 d-flex justify-content-end">
                                                <img src="/assets/images/logo.png" alt="logo" height="46" width="164">
                                            </div>
                                        </div>
                                        <hr>
                                        <!-- invoice address and contact -->

                                        <div class="row m-0">
                                            <div class="col-lg-5 px-0">
                                                <h5>
                                                    <span class="invoice-number mr-50"><strong>Invoice #:</strong></span>
                                                    <span><strong>{{ invoice.number }}</strong></span>
                                                </h5>
                                            </div>
                                        </div>

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
                                                    <span>{{ invoice.patient_data.address }}, {{ invoice.patient_data.city }}, {{ invoice.patient_data.state }}, {{ invoice.patient_data.zip_code }}</span>
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
                                            <tbody v-for="order in invoice.invoice_orders">
                                                <tr
                                                    v-if="order.current_transaction_status == 'Completed'"
                                                    :key="order.id"
                                                    >
                                                    <td>{{ order.rx_number }}</td>
                                                    <td>{{ order.dispensed_item_name }}</td>
                                                    <td v-if=" $auth.check() && $auth.user().role == 'admin' ">x{{ order.dispensed_quantity }}</td>
                                                    <td>{{ order.current_transaction_status }}</td>
                                                    <td v-if=" $auth.check() && $auth.user().role == 'admin' ">{{ order.rx_status }}</td>
                                                    <td class="text-primary text-right font-weight-bold">
                                                        ${{ parseFloat(order.total_price_paid).toFixed(2) }} 
                                                        {{ sumUpTotal(parseFloat(order.total_price_paid).toFixed(2)) }}
                                                    </td>
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
                                                        <span class="invoice-value">${{ parseFloat(total).toFixed(2)}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- invoice action  -->
                        <!-- <div class="col-xl-3 col-md-4 col-12">
                            <div class="card invoice-action-wrapper shadow-none border">
                                <div class="card-body">
                                    <div class="invoice-action-btn">
                                        <button @click="printSection" class="btn btn-light-primary btn-block invoice-print">
                                            <span>Print Receipt</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
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
                patient_data: {},
                order: {},
                payment: {}
            },

            total: 0
        };
    },
    created() {
        var app = this;
        this.axios
            .get(`/api/invoices/${this.$route.params.id}`)
            .then(response => {
                console.log("DATA", response.data)
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
        },

        sumUpTotal (data) {
            this.total += data;
        }
    }
};
</script>
