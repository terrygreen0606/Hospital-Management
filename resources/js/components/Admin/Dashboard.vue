<template>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <h1>HOME ADMIN</h1>
            </div>
        </div>
    </div>
    <!-- END: Content-->
</template>
<script>
export default {
    data() {
        return {
            phone: null,
            dob: null,
            otp: null,
            has_error: false,
            error: "",
            errors: {
                phone: [],
                dob: []
            },
            success: false,
            requested: false,
            updated: false,

            user: {
                patient: {}
            },

            orders: {},

            invoices: {},
            
            reports: {
                patients: [],
                invoices: [],
                orders: []
            },

            isMirror: 0
        };
    },

    mounted() {
        // if(this.$auth.user().role == 'prescriber') {
        //     this.$router.push({ name: "PrescriberHome"})
        // }
        // this.getOrders();
        // this.getInvoices();

        // let mirror = localStorage.getItem('mirrorView');
        // this.isMirror = mirror ? mirror : 0;
    },

    methods: {
        updateUser() {
            var app = this;
            this.axios
                .put(`/api/users/${this.user.id}`, this.user)
                .then(response => {
                    app.updated = true;
                });
        },

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
