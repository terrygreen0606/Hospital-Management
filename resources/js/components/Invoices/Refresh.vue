<template>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Refresh Invoices</h4>
            <div class="row">
                <div class="col-md-12">
                    <form @submit.prevent="refreshInvoices">
                        <div class="form-group">
                            <h5>Click the button to send reminder messages to patients informing them of their prescriptions.</h5>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Send Text Messages Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: false,
            error: false
        };
    },
    methods: {
        refreshInvoices() {
            this.axios
                .post("/api/sms")
                .then(response => {
                    this.message = resonse.data.message;
                    this.error = resonse.data.error;
                    this.$router.push({ name: "invoices" });
                })
                .catch(error => console.log(error))
                .finally(() => (this.loading = false));
        }
    }
};
</script>
