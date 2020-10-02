<template>

    <div class="container">
        <div class="row justify-content-md-center">
                
            <div class="col-md-6 col-12 mt-5 pt-5">
                <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                    <div class="card-header pb-1">
                        <div class="card-title">
                            <h4 class="text-center mb-2">Welcome Back</h4>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="d-flex flex-md-row flex-column justify-content-around">
                                <img style="height: 70px" src="/assets/images/logo.png" />
                            </div>
                            <hr>
                            <div class="alert alert-danger mb-2" v-if="has_error && !success">
                                <p v-if="error == 'login_error'">
                                    Login failed. Please try again
                                </p>
                                <p v-else>{{ error }}.</p>
                                <p v-if="errors.phone">{{ errors.phone[0] }}</p>
                                <small v-if="errors.dob">{{ errors.dob[0] }}</small>
                            </div>

                            <div class="alert alert-success" v-if="requested">
                                <p>{{ customerMessage }}</p>
                                <!-- <small v-if="errors.phone">{{ errors.phone[0] }}</small> -->
                            </div>

                            <form
                                class="pt-3"
                                autocomplete="off"
                                @submit.prevent="requestOtp"
                                method="post"
                                v-if="!requested"
                            >
                                <div class="form-group mb-50">
                                    <label class="text-bold-600" for="otpphone">Your Phone Number</label>
                                    <input
                                        type="tel"
                                        id="otpphone"
                                        class="form-control"
                                        placeholder="Enter phone number"
                                        v-model="phone"
                                        minlength="10"
                                        maxlength="12"
                                        required
                                    />
                                </div>
                                <div class="mt-3">
                                     <button
                                        type="submit"
                                        class="btn btn-info glow w-100 position-relative"
                                        >
                                            Login
                                            <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                        </button>
                                </div>
                            </form>

                            <form
                                class="pt-3"
                                autocomplete="off"
                                @submit.prevent="login"
                                method="post"
                                v-if="requested"
                                >
                                <div class="form-group">
                                    <label class="text-bold-600" for="phone">Your Phone Number</label>
                                    <input
                                        type="tel"
                                        id="phone"
                                        class="form-control"
                                        placeholder="Enter phone number"
                                        v-model="phone"
                                        minlength="10"
                                        maxlength="12"
                                        required
                                    />
                                </div>
                                <div class="form-group">
                                    <label class="text-bold-600" for="dob">Date of birth / Passcode</label>
                                    <input
                                        type="number"
                                        id="dob"
                                        class="form-control"
                                        v-model="dob"
                                        required
                                        minlength="6"
                                        maxlength="6"
                                        placeholder="Format: MMDDYY"
                                    />
                                </div>
                                <div class="form-group">
                                    <label class="text-bold-600" for="dob">One Time Password</label>
                                    <input
                                        type="number"
                                        id="otp"
                                        class="form-control"
                                        v-model="otp"
                                        required
                                        minlength="6"
                                        maxlength="6"
                                    />
                                </div>
                                <div class="mt-3">
                                    <button
                                        type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium"
                                    >
                                        SIGN IN
                                    </button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Don't have an account?
                                    <router-link to="/register" class="text-primary"
                                        >Create one now</router-link
                                    >
                                </div>
                            </form>
                            
                        </div>
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

            requested: false
        };
    },
    methods: {
        requestOtp() {
            this.axios
                .post("/api/auth/otp", { phone: this.phone })
                .then(res => {
                    this.requested = true;
                    this.has_error = false;
                    this.customerMessage = res.data.message;
                })
                .catch(res => {
                    this.has_error = true;
                    this.error =
                        res.response.data.error || res.response.data.message;
                    this.errors =
                        res.response.data.errors ||
                        res.response.data.errors ||
                        {};
                });
        },
        login() {
            var redirect = this.$auth.redirect();
            var app = this;
            this.$auth.login({
                params: {
                    phone: this.phone,
                    dob: this.dob,
                    otp: this.otp
                },
                redirect: {
                    name: redirect ? redirect.from.name : "home"
                },
                success: function(res) {
                    if(res.data.status == "error") {
                        app.has_error = true;
                        app.errors = res.data.message
                        app.error = "Incorrect OTP"
                    }
                },
                error: function(res) {
                    app.has_error = true;
                    app.error =
                        res.response.data.error || res.response.data.message;
                    app.errors =
                        res.response.data.errors ||
                        res.response.data.errors ||
                        {};
                },
                rememberMe: true,
                fetchUser: true
            });
        }
    }
};
</script>
