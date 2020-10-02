<template>
    <div class="app-content content">
        <div class="content-body">
            <div class="row m-0">
                <div class="col-md-12">
                    <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                    <p>{{ $route.meta.subtitle }}</p>

                    <div class="table-responsive pmd-table-card">
                        <table id="payment-listing" class="table pmd-table">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Request</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="payment in payments.data" :key="payment.id">
                                    <td data-title="Patient">
                                        {{ payment.user.name }}
                                    </td>
                                    <td data-title="Patient">
                                        <router-link
                                            :to="{
                                                name: 'view_invoice',
                                                params: { id: payment.invoice.id }
                                            }"
                                        >
                                            {{ payment.invoice.number }}
                                        </router-link>
                                    </td>
                                    <td data-title="Amount">${{ payment.amount }}</td>
                                    <td data-title="Request" class="text-capitalize">
                                        {{ payment.request }}
                                    </td>
                                    <td data-title="Status" class="text-capitalize">
                                        {{ payment.status }}
                                    </td>
                                    <td data-title="Date">{{ payment.created_at }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td colspan="6" class="text-left pl-2">
                                    <pagination
                                        :limit="1"
                                        :data="payments"
                                        @pagination-change-page="getPayments"
                                    ></pagination>
                                </td>
                            </tfoot>
                        </table>
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
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get("/api/payments" + p).then(response => {
                this.payments = response.data;
            });
        }
    }
};
</script>
