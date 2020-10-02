<template>
    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bold">
                My Receipts
                <router-link to="/" class="font-weight-bold float-right">
                    <i class="ti-home"></i>
                </router-link>
            </h4>
        </div>
        <div class="col-md-12">
            <div class="table-responsive pmd-table-card">
                <table id="payment-listing" class="table pmd-table">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Amount</th>
                            <th>Created On</th>
                            <th>Receipt Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="payment in payments.data" :key="payment.id">
                            <td data-title="Number">
                                {{ payment.inoice.number }}
                            </td>
                            <td data-title="Amount">${{ payment.amount }}</td>
                            <td data-title="Status">
                                {{ payment.created_at }}
                            </td>
                            <td>
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
        deletepayment(id) {
            this.axios.delete(`/api/payments/${id}`).then(response => {
                let i = this.payments.map(item => item.id).indexOf(id); // find index of your object
                this.payments.splice(i, 1);
            });
        },

        getReceipts(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            this.axios
                .get(`/api/payments?user_id=${this.$auth.user().id}` + p)
                .then(response => {
                    this.orders = response.data;
                });
        }
    }
};
</script>
