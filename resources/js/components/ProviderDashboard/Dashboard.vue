<template>  
    <div class="w-100">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-md-12 col-xl-5 mb-4 mb-xl-0">
                    <h4 class="font-weight-bold">
                        Hello, {{ user.name }}!
                    </h4>
                    <h4 class="font-weight-normal mb-0">
                        <i class="ti-mobile mr-2"></i> {{ user.phone }}
                    </h4>
                </div>
                <div class="col-md-12 col-xl-7">
                    
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            user: {}
        };
    },

    mounted() {
        this.user = this.$auth.user()
    },

    created() {
        
    },

    methods: {
        
    }
};
</script>
