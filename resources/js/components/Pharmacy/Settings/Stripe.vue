<template>

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body col-md-6 col-sm-12">
                <h1>Stripe Account Settings</h1>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Enter your key and secret that will be used during the patient's payment</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            <form class="form form-vertical">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-icon">Stripe Key</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text"
                                                        id="first-name-icon"
                                                        class="form-control"
                                                        name="fname-icon"
                                                        placeholder="Stripe Key"
                                                        v-model="stripe_key">
                                                    <div class="form-control-position">
                                                        <i class="bx bx-lock-alt"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-icon">Stripe Secret</label>
                                                <div class="position-relative has-icon-left">
                                                    <input 
                                                        type="text"
                                                        id="email-id-icon"
                                                        class="form-control"
                                                        name="email-id-icon"
                                                        placeholder="Stripe Secret"
                                                        v-model="stripe_secret">
                                                    <div class="form-control-position">
                                                        <i class="bx bxs-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button
                                                type="button"
                                                class="btn btn-primary mr-1 mb-1"
                                                @click="saveStripe"
                                                >
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
</template>
<script>
import swal from 'sweetalert';
export default {
    data() {
        return {
            stripe_key: '',
            stripe_secret: '',
            stripe_data: {}
        };
    },
    mounted() { 
        this.getStripeData()
    },

    methods: {
        getStripeData() {
            this.axios.get(`/api/stripeAccount?user_id=` + this.$auth.user().id).then(res => {
                this.stripe_key = res.data.stripe_key
                this.stripe_secret = res.data.stripe_secret
            });
        },
        saveStripe() {
            let data = {
                stripe_key: this.stripe_key,
                stripe_secret: this.stripe_secret,
                user_id: this.$auth.user().id,
                active: 1
            }
            
            this.axios.post(`/api/stripeAccount`, data).then(res => {
                console.log(res)
                swal("Saved!", "Stripe Account has been saved!", "success");
            });
        }
    }
};
</script>
