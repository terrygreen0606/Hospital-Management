<template>
    <div class="row">
        <div class="col-lg-12" id="printSection">
            <div class="card px-2">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3 justify-content-end mt-2">
                                <router-link
                                    class="navbar-brand brand-logo-mini"
                                    to="/"
                                >
                                    <img
                                        src="/assets/images/logo.png"
                                        alt="logo"
                                        width="150px"
                                    />
                                </router-link>
                            </div>
                            <div class="col-md-9 justify-content-end mt-2">
                                <h2 class="text-right">
                                    Item&nbsp;&nbsp;#{{ invoice.number }}
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid d-flex justify-content-between">
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
                        <div class="col-lg-3 pr-0">
                            <p class="mt-5 mb-2 text-right">
                                <b>Billed to</b>
                            </p>
                            <p class="text-right">
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
                    <div
                        class="container-fluid mt-5 d-flex justify-content-center w-100"
                    >
                        <div class="table-responsive w-100">
                            <table class="table">
                                <tbody>
                                    <tr class="text-right" v-for="order in invoice.invoice_orders" :key="order.id">
                                        <td class="text-left" data-title="">
                                            <b>
                                                {{
                                                    order
                                                    .dispensed_item_name
                                                }}
                                            </b>
                                        </td>
                                        <td data-title="Qty">
                                            x{{
                                                order.dispensed_quantity
                                            }}
                                        </td>
                                        <td class="text-right pr-5" data-title="Amount">
                                            ${{
                                                order.total_price_paid
                                            }}
                                        </td>
                                    </tr>
                                    <tr class="text-right" v-if="invoice.payment">
                                        <td class="text-left">2</td>
                                        <td class="text-left">
                                            Shipping
                                        </td>
                                        <td>
                                        </td>
                                        <td class="text-right pr-4">
                                            ${{
                                                invoice.payment.shipping
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container-fluid mt-5 w-100 row">
                        <div class="col-md-9 text-left mb-2 pl-4">
                            Signed: {{ invoice.user.name }}<br />
                            <img
                                class="pl-3"
                                v-bind:src="invoice.signature"
                                v-bind:alt="invoice.user.name"
                                width="200px"
                            />
                        </div>
                        <div class="col-md-3 mt-4">
                            <h5 class="text-right mb-2 pr-4">
                                Sub Total: ${{ invoice.amount }}
                            </h5>
                            <h4 class="text-right mb-5 pr-4">
                                Total : ${{ total }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-3">
            <div class="card px-2">
                <div class="card-body">
                    <div class="container-fluid w-100">
                        <button
                            @click="printSection"
                            class="btn btn-primary float-right ml-2"
                        >
                            <i class="mdi mdi-printer mr-1"></i>
                            Print Item
                        </button>
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
            invoice: {
                user: {},
                patient: {},
                order: {},
                payment: {}
            }
        };
    },
    computed: {
        total: function() {
            if('payment' in this.invoice){
                return (parseFloat(this.invoice.payment.shipping) + parseFloat(this.invoice.amount)).toFixed( 2 );
            } else {
                return this.invoice.amount.toFixed( 2 );
            }
        }
    },

    created() {
        var app = this;
        this.axios
            .get(`/api/invoices/${this.$route.params.invoice}`)
            .then(response => {
                this.invoice = response.data;
            });
    },
    methods: {
        sendInvoice() {
            this.axios
                .post(`/api/invoices/${this.$route.params.id}`, this.invoice)
                .then(response => {
                    this.$router.push({ name: "home" });
                });
        },
        printSection() {
            this.$htmlToPaper("printSection");
        }
    }
};
</script>
