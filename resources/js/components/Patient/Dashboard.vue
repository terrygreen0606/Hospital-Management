<template>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <h1>HOME PATIENT</h1>
            </div>
        </div>
    </div>
    <!-- END: Content-->
</template>
<script>
export default {
    data() {
        return {
            phone: null
        };
    },

    mounted() {
        
    },

    methods: {
        
        refreshReports() {
            this.axios.post(`/api/reports`).then(response => {
                this.$router.go(0);
            });
        },

        getOrders(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            this.axios
                .get(`/api/orders?user_id=${this.$auth.user().id}` + p)
                .then(response => {
                    this.orders = response.data;
                });
        },

        getInvoices(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            this.axios
                .get(`/api/invoices?user_id=${this.$auth.user().id}` + p)
                .then(response => {
                    this.invoices = response.data;
                });
        }
    }
};
</script>
