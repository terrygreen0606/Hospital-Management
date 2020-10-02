<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="font-weight-bold">
                                Patient Payments
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
                                            <th>Dispensed Item</th>
                                            <th>Invoice</th>
                                            <th>Amount</th>
                                            <th>Created On</th>
                                            <th>Status</th>
                                            <!-- <th>Receipt</th> -->
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
                                              <!-- <<td>
                                              router-link
                                                    :to="{
                                                        name: 'viewpayment',
                                                        params: { id: payment.id }
                                                    }"
                                                    tag="button"
                                                    class="btn btn-dark btn-rounded btn-icon"
                                                >
                                                    <i class="ti-eye"></i>
                                                </router-link>
                                                <router-link
                                                    :to="{
                                                        name: 'view_receipt',
                                                        params: {
                                                            invoice: payment.id
                                                        }
                                                    }"
                                                    tag="button"
                                                    class="btn btn-dark btn-rounded btn-icon"
                                                >
                                                    <i class="bx bx-show"></i>
                                                </router-link>
                                            </td> -->
                                        </tr>
                                    </tbody>
                                </table>
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
            payments: {}
        };
    },
    mounted() {
        this.getPayments();
    },
    methods: {
        deletePayment(id) {
            this.axios.delete(`/api/payments/${id}`).then(response => {
                let i = this.payments.map(item => item.id).indexOf(id); // find index of your object
                this.payments.splice(i, 1);
            });
        },

        getPayments(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            this.axios.get("/api/getPharmacyData/"+this.$auth.user().id).then(res => {
                if(res.data.length > 0){
                    this.axios.get("/api/payments?ids=" + JSON.stringify(res.data) + p).then(response => {
                        this.payments = response.data;
                    });
                }

            });
        }
    }
};
</script>
