<template>
    <div class="w-100">
        <div
            class="row"
            id="invoice-salute"
            v-if="$auth.check() && user.role == 'admin'"
        >
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-md-12 col-xl-5 mb-4 mb-xl-0">
                        <h4 class="font-weight-bold">
                            Hello, {{ user.name }}!
                        </h4>
                        <h4 class="font-weight-normal mb-0">
                            <i class="ti-settings mr-2"></i> You're editting app
                            settings.
                        </h4>
                    </div>
                    <div class="col-md-12 col-xl-7">
                        <div class="d-flex justify-content-end flex-wrap">
                            <ul
                                class="nav nav-tabs nav-fill mb-xl-0"
                                role="tablist"
                            >
                                <li class="nav-item">
                                    <a
                                        class="nav-link active"
                                        id="invoices-tab"
                                        data-toggle="tab"
                                        href="#invoices-section"
                                        role="tab"
                                        aria-controls="invoices-section"
                                        aria-selected="true"
                                    >
                                        Invoice Rules
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link"
                                        id="other-tab"
                                        data-toggle="tab"
                                        href="#other-section"
                                        role="tab"
                                        aria-controls="other-section"
                                        aria-selected="false"
                                    >
                                        Other Settings
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="row"
            id="invoice-tabs"
            v-if="$auth.check() && user.role == 'admin'"
        >
            <div class="col-md-section2 col-xl-12">
                <div class="tab-content border-0 p-0">
                    <div
                        class="tab-pane fade show active"
                        id="invoices-section"
                        role="tabpanel"
                        aria-labelledby="invoices-tab"
                    >
                        <div class="row card">
                            <div class="col-lg-12 card-body">
                                <div
                                    v-if="updated"
                                    class="alert alert-success fade show"
                                    role="alert"
                                >
                                    Successfuly updated invoice rules
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="alert"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">
                                            &times;
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <form
                                @submit.prevent="updateSettings"
                                class="col-lg-12 d-flex justify-content-between card-body row"
                            >
                                <div class="form-group col-md-4">
                                    <label>Full Name</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        v-model="user.name"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Date of Birth</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        v-model="user.dob"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Email Address</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        v-model="user.email"
                                    />
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Phone Number</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        v-model="user.phone"
                                    />
                                </div>

                                <div class="form-group col-md-4 offset-md-8">
                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-block"
                                    >
                                        Update settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div
                        class="tab-pane fade card"
                        id="other-section"
                        role="tabpanel"
                        aria-labelledby="other-tab"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            has_error: false,
            error: "",
            errors: {},
            success: false,
            requested: false,
            updated: false,

            user: {},

            settings: {
                invoices: []
            }
        };
    },
    created() {
        if (this.$auth.check()) {
            this.user = this.$auth.user();
            this.axios.get(`/api/settings/invoices`).then(response => {
                this.settings.invoices = response.data;
            });
        }
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
            // get the redirect object
            var redirect = this.$auth.redirect();
            var app = this;
            this.$auth.login({
                params: {
                    phone: app.phone,
                    dob: app.dob,
                    otp: this.otp
                },
                success: function() {
                    // handle redirection
                    const to = redirect ? redirect.from.name : "home";
                    app.$router.push({ name: to });
                },
                error: function() {
                    app.has_error = true;
                },
                rememberMe: true,
                fetchUser: true
            });
        },

        updateSettings(option) {
            var app = this;
            this.axios
                .put(`/api/users/${this.user.id}`, option)
                .then(response => {
                    app.updated = true;
                });
        }
    }
};
</script>
