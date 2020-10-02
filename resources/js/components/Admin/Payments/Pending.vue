<template>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="font-weight-bold">
                        Pending Payments
                    </h4>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive pmd-table-card">
                        <table id="payment-listing" class="table pmd-table">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Amount</th>
                                    <th>Request</th>
                                    <th>Created At</th>
                                    <!-- <th>Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="payment in payments" :key="payment.id">
                                    <td data-title="Patient">{{ payment.user.name }}</td>
                                    <td data-title="Amount">${{ payment.amount }}</td>
                                    <td data-title="Request" class="text-capitalize">{{ payment.request }}</td>
                                    <td data-title="Date">{{ payment.created_at }}</td>
                                    <!-- <td>
                                        <router-link
                                            :to="{
                                                name: 'editpayment',
                                                params: { id: payment.id }
                                            }"
                                            tag="button"
                                            class="btn btn-dark btn-rounded btn-icon"
                                        >
                                            <i class="ti-pencil"></i>
                                        </router-link>
                                        <button
                                            @click="deletePayment(payment.id)"
                                            class="btn btn-danger btn-rounded btn-icon"
                                        >
                                            <i class="ti-trash"></i>
                                        </button>
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
</template>

<script>
export default {
    data() {
        return {
            payments: []
        };
    },
    created() {
        this.axios.get("/api/payments?status=pending").then(response => {
            this.payments = response.data;
        });
    },
    methods: {
        deletePayment(id) {
            this.axios.delete(`/api/payments/${id}`).then(response => {
                let i = this.payments.map(item => item.id).indexOf(id); // find index of your object
                this.payments.splice(i, 1);
            });
        }
    }
};
</script>
