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
                            <div class="col-md-9 justify-content-lg-end mt-2">
                                <h3 class="text-lg-right">
                                    {{ payment.invoice.number }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div
                        class="container-fluid d-flex justify-content-lg-between"
                    >
                        <div class="col-lg-3 pr-0">
                            <p class="mt-5 mb-2">
                                <b>Billed to</b>
                            </p>
                            <p class="text-left">
                                {{ payment.user.name }}, <br />
                                {{ payment.invoice.patient.address }}<br />
                                {{ payment.invoice.patient.city }},
                                {{ payment.invoice.patient.state }},
                                {{ payment.invoice.patient.zip_code }}<br />
                                Phone: {{ payment.user.phone }}<br />
                                {{ payment.user.email }}<br />
                            </p>
                        </div>
                    </div>
                    <div
                        class="container-fluid mt-5 d-flex justify-content-center w-100"
                    >
                        <div class="table-responsive pmd-table-card w-100">
                            <table class="table pmd-table">
                                <tbody>
                                    <tr
                                        class="text-right"
                                        v-for="order in payment.invoice_orders"
                                        :key="order.id"
                                    >
                                        <td class="text-left" data-title="">
                                            <b>
                                                {{ order.dispensed_item_name }}
                                            </b>
                                        </td>
                                        <td class="d-none d-md-table-cell"></td>
                                        <td
                                            class="text-right pr-5"
                                            data-title="Amount"
                                        >
                                            ${{ order.total_price_paid }}
                                        </td>
                                    </tr>
                                    <tr
                                        class="text-right"
                                        v-if="payment.shipping"
                                    >
                                        <td class="d-none d-md-table-cell"></td>
                                        <td
                                            class="d-none d-md-table-cell text-left"
                                        >
                                            Shipping
                                        </td>
                                        <td
                                            class="text-right pr-5"
                                            v-if="payment.shipping"
                                            data-title="Shipping"
                                        >
                                            ${{ payment.shipping }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container-fluid mt-5 w-100 row">
                        <div class="col-md-9 text-left mb-2 pl-4">
                            Signed: {{ payment.user.name }}<br />
                            <img
                                class="pl-3 pt-1"
                                v-bind:src="payment.invoice.signature"
                                v-bind:alt="payment.user.name"
                                width="200px"
                            />
                        </div>

                        <div class="col-md-3 mt-4">
                            <h5 class="text-lg-right mb-2 pr-4">
                                Sub Total: ${{ subtotal }}
                            </h5>
                            <h4 class="text-lg-right mb-5 pr-4">
                                Total : ${{ payment.amount }}
                            </h4>
                        </div>

                        <div class="col-md-12 border-top pt-2">
                            <p>
                                Questions? Email us at
                                <a href="mailto:rxorders@dermrxpharmacy.com">
                                    rxorders@dermrxpharmacy.com
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 offset-md-8 mt-3 mb-3">
            <button @click="printSection" class="btn btn-primary btn-block">
                <i class="mdi mdi-printer mr-1"></i>
                Print Receipt
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            payment: {
                invoice: {
                    patient: {}
                },
                user: {}
            },
            total: ''
        };
    },
    computed: {
        subtotal: function() {
            return (
                parseFloat(this.payment.amount) -
                parseFloat(this.payment.shipping)
            ).toFixed(2);
        }
    },

    created() {
        this.axios
            .get(`/api/payments/${this.$route.params.invoice}`)
            .then(response => {
                this.payment = response.data;
            });
    },
    methods: {
        printSection() {
            this.$htmlToPaper("printSection");
        }
    }
};
</script>
