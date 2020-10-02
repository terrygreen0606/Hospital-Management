<template>
    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bold">
                Latest Receipts
            </h4>
        </div>
        <div class="col-md-12">
            <div class="table-responsive pmd-table-card">
                <table id="invoice-listing" class="table pmd-table">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Shipping</th>
                            <th>Total</th>
                            <th>Created On</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="payment in payments.data" :key="payment.id">
                            <td
                                v-if="payment.status == 'completed'"
                                data-title="Number"
                            >
                                {{ payment.invoice.number }}
                            </td>
                            <td
                                v-if="payment.status == 'completed'"
                                data-title="Shipping"
                            >
                                ${{ payment.shipping }}
                            </td>
                            <td
                                v-if="payment.status == 'completed'"
                                data-title="Total"
                            >
                                ${{ payment.amount }}
                            </td>
                            <td
                                v-if="payment.status == 'completed'"
                                data-title="Created"
                            >
                                {{ payment.invoice.created_at }}
                            </td>
                            <td v-if="payment.status == 'completed'">
                                <router-link
                                    :to="{
                                        name: 'viewreceipt',
                                        params: { invoice: payment.id }
                                    }"
                                    tag="button"
                                    class="btn btn-dark btn-rounded btn-icon"
                                >
                                    <i class="ti-eye"></i>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <td colspan="6" class="text-left pl-2">
                            <pagination
                                :limit="1"
                                :data="payments"
                                @pagination-change-page="getReceipts"
                            ></pagination>
                        </td>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            payments: {}
        };
    },
    mounted() {
        this.getReceipts();
    },
    methods: {
        getReceipts(page = 1) {
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get("/api/payments" + p).then(response => {
                this.payments = response.data;
            });
        }
        }
};
</script>
