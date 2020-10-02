<template>

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="card px-2">
                                <div class="card-body">
                                    <h3 style="color: white;">Payment processing!</h3>

                                    <p>
                                        Congratulations! Your prescription is being processed.
                                        If you have any questions or need to contact us, please
                                        email us at
                                        <a href="mailto:rxorders@dermrxpharmacy.com"
                                            >rxorders@dermrxpharmacy.com</a
                                        >
                                        or call us on
                                        <a href="tel:4693513462">4693513462</a>
                                    </p>

                                    <div>
                                        <dl>
                                            <dt>Invoice Number</dt>
                                            <dd>{{ payment.invoice.number }}</dd>
                                            <dt>Payment Date</dt>
                                            <dd>{{ payment.created_at }}</dd>
                                            <dt>Payment Amount</dt>
                                            <dd>${{ payment.amount }}</dd>
                                            <dt>Email Address</dt>
                                            <dd>{{ payment.user.email }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-md-8">
                            <router-link
                                :to="{
                                    name: 'payments'
                                }"
                                tag="button"
                                class="btn btn-primary btn-block"
                            >
                                <i class="ti-credit-card pr-3"></i> View Payments
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>
<style>
dt {
    font-weight: bold;
}
</style>
<script>
export default {
    data() {
        return {
            payment: {
                user: {},
                invoice: {
                    patient: {}
                }
            }
        };
    },
    created() {
        this.axios.get(`/api/payments/${this.$route.params.id}`).then(res => {
            this.payment = res.data;
        });
    }
};
</script>
