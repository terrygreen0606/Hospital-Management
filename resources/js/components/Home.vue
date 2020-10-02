<template>

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <h1>HOME</h1>
            </div>
        </div>
    </div>
    <!-- END: Content-->
</template>
<script>
export default {
    data() {
        return {
            user: {
                
            }
        };
    },

    mounted() {
        if(this.$auth.user().role == 'doctor' || this.$auth.user().role == 'prescriber') {
            this.$router.push({ name: "prescriber_home"})
        }
        if(this.$auth.user().role == 'admin') {
            this.$router.push({ name: "admin_dashboard"})
        }
        if(this.$auth.user().role == 'patient') {
            this.$router.push({ name: "patient_dashboard"})
        }
        if(this.$auth.user().role == 'pharmacy' || this.$auth.user().role == 'provider') {
            this.$router.push({ name: "pharmacy_dashboard"})
        }
    },

    methods: {

    }
};
</script>
