<template>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Refresh Invoices</h4>
            <div class="row">
                <div class="col-md-12" v-if="message">
                    <div
                        class="alert alert-success alert-dismissible fade show"
                        role="alert"
                    >
                        All messages sent imported successfully..
                        <router-link to="/admin/invoices" class="alert-link">
                            View Invoices
                        </router-link>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
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
            success: false,
            error: false
        };
    },
    methods: {
        refreshInvoices() {
            var app = this
            app.axios
                .post("/api/sms")
                .then(response => {
                    app.message = resonse.data.message;
                    app.success = resonse.data.success;
                    app.error = resonse.data.error;
                    app.$router.push({ name: "invoices" });
                })
                .catch(error => console.log(error))
                .finally(() => (this.loading = false));
        }
    }
};
</script>
