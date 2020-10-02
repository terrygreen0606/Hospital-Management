<template>
    <div class="row">
        <div class="col-lg-12" id="printSection">
            <div class="card px-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3 justify-content-end mt-4">
                            <router-link
                                class="navbar-brand brand-logo-mini"
                                to="/"
                            >
                                <img
                                    src="/assets/images/logo.png"
                                    alt="logo"
                                    width="180px"
                                />
                            </router-link>
                        </div>
                        <div
                            class="col-md-4 offset-md-5 justify-content-md-end justify-content-lg-end mt-2"
                        >
                            <h6 class="btn btn-sm btn-dark text-uppercase">
                                {{ invoice.status }}
                            </h6>
                            <br />
                            <h3 class="">#{{ invoice.number }}</h3>
                        </div>
                    </div>
                </div>
                <div class="container-fluid d-lg-flex justify-content-between">
                    <div class="col-lg-3 pl-0">
                        <p class="mt-5 mb-2">
                            <b>RX Payments</b>
                        </p>
                        <p>
                            17826 Davenport Rd, <br />
                            Dallas, TX 75252, <br />
                            United States of America.<br />
                            Phone: 1 844 504 8772<br />
                            rxorders@dermrxpharmacy.com
                        </p>
                    </div>
                    <div class="col-lg-3 pr-0 align-items-md-end">
                        <p class="mt-5 mb-2">
                            <b>Invoice to</b>
                        </p>
                        <p class="">
                            {{ invoice.user.name }}, <br />
                            {{ invoice.patient.address }}<br />
                            {{ invoice.patient.city }},
                            {{ invoice.patient.state }},
                            {{ invoice.patient.zip_code }}<br />
                            Phone: {{ invoice.user.phone }}<br />
                            {{ invoice.user.email }}<br />
                        </p>
                    </div>
                </div>
                <div class="container d-lg-flex justify-content-between">
                    <div class="col-lg-12 pr-0 align-items-lg-end">
                        <p class="text-right pr-5">
                            <b>ISSUED ON: {{ invoice.created_at }}</b>
                        </p>
                    </div>
                </div>
                <div
                    class="container-fluid mt-5 d-lg-flex justify-content-center w-100"
                >
                    <div class="w-100 pmd-table-card border-0">
                        <table class="table pmd-table border-0">
                            <tbody>
                                <tr
                                    class="text-right"
                                    v-for="order in invoice.invoice_orders"
                                    :key="order.id"
                                >
                                    <td class="text-left" data-title="RX #">
                                        {{ order.rx_number }}
                                    </td>
                                    <td data-title="">
                                        <b>
                                            {{ order.dispensed_item_name }}
                                        </b>
                                    </td>
                                    <td
                                        data-title="Qty"
                                        v-if="
                                            $auth.check() &&
                                                $auth.user().role == 'admin'
                                        "
                                    >
                                        x{{ order.dispensed_quantity }}
                                    </td>
                                    <td class="text-left" data-title="">
                                        {{ order.current_transaction_status }}
                                    </td>
                                    <td
                                        class="text-right pr-5"
                                        data-title="RX Status"
                                        v-if="
                                            $auth.check() &&
                                                invoice.user.role == 'admin'
                                        "
                                    >
                                        {{ order.rx_status }}
                                    </td>
                                    <td data-title="Amount">
                                        ${{ parseFloat(order.total_price_paid).toFixed(2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="container-fluid mt-5 w-100">
                    <div class="row">
                        <!-- <p class="text-right mb-2 pr-4">
                        Sub Total: ${{ invoice.amount }}
                    </p> -->

                        <div class="col-md-3 offset-md-9">
                            <h4
                                class="text-right mb-5 pr-4 justify-content between"
                            >
                                <span>TOTAL :</span>
                                <span>${{ parseFloat(invoice.amount).toFixed(2)}}</span>
                            </h4>
                        </div>
                        <!-- <div class="col-md-12 border-top pt-2">
                            <p>
                                <b>INFO AND NOTES</b>
                            </p>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-3 row" v-if="invoice.status == 'Open' || invoice.status == 'Pending'">
            <div class="col">
                <router-link
                    :to="{
                        name: 'checkout',
                        params: { invoice: invoice.number }
                    }"
                    class="btn btn-primary float-left"
                >
                    <i class="mdi mdi-cart mr-1"></i>
                    Select To Pay
                </router-link>
            </div>
            <div class="col mb-2">
                <button
                    @click="printSection"
                    class="btn btn-primary float-right ml-2"
                >
                    <i class="mdi mdi-printer mr-1"></i>
                    Print Invoice
                </button>
            </div>
            <div
                class="col mb-2"
                v-if="$auth.check() && $auth.user().role == 'admin'"
            >
                <button
                    class="btn btn-success float-right ml-2"
                    @click="emailInvoice"
                >
                    <i class="mdi mdi-telegram mr-1"></i>
                    Send Invoice Email
                </button>
            </div>
            <div
                class="col mb-2"
                v-if="$auth.check() && $auth.user().role == 'admin'"
            >
                <button class="btn btn-success float-right" @click="smsInvoice">
                    <i class="mdi mdi-telegram mr-1"></i>
                    Send Invoice SMS
                </button>
            </div>
        </div>

        <div class="col-md-4 offset-md-8 mt-3 mb-2" v-else>
            <button @click="printSection" class="btn btn-primary btn-block">
                <i class="mdi mdi-printer mr-1"></i>
                Print Invoice
            </button>
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
