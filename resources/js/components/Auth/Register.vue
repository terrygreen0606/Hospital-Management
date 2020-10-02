<template>
    <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light p-5">
                <div class="brand-logo text-center">
                    <img src="/assets/images/logo.png" />
                </div>
                <div class="alert alert-danger" v-if="has_error && !success">
                    <p v-if="error == 'registration_validation_error'">.</p>
                    <p v-else>Registration failed. Please try again.</p>
                </div>
                <form
                    class="pt-3"
                    autocomplete="off"
                    @submit.prevent="register"
                    v-if="!success"
                    method="post"
                >
                    <div
                        class="form-group"
                        v-bind:class="{
                            'has-error': has_error && errors.name
                        }"
                    >
                        <label for="name">Full Name</label>
                        <input
                            type="name"
                            id="name"
                            class="form-control"
                            placeholder="Enter name"
                            v-model="name"
                        />
                        <span
                            class="help-block"
                            v-if="has_error && errors.name"
                        >
                            {{ errors.name }}</span
                        >
                    </div>

                    <div
                        class="form-group"
                        v-bind:class="{
                            'has-error': has_error && errors.email
                        }"
                    >
                        <label for="email">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            class="form-control"
                            placeholder="user@example.com"
                            v-model="email"
                        />
                        <span
                            class="help-block"
                            v-if="has_error && errors.email"
                        >
                            {{ errors.email }}</span
                        >
                    </div>

                    <div
                        class="form-group"
                        v-bind:class="{
                            'has-error': has_error && errors.phone
                        }"
                    >
                        <label for="phone">Phone Number</label>
                        <input
                            type="tel"
                            id="phone"
                            class="form-control"
                            v-model="phone"
                            placeholder="Enter phone"
                            minlength="10"
                            maxlength="10"
                        />
                        <span
                            class="help-block"
                            v-if="has_error && errors.phone"
                            >{{ errors.phone }}
                        </span>
                    </div>

                    <div
                        class="form-group"
                        v-bind:class="{ 'has-error': has_error && errors.dob }"
                    >
                        <label for="dob">Date of Birth</label>
                        <input
                            type="number"
                            id="dob"
                            class="form-control"
                            v-model="dob"
                            placeholder="Format mmddyy"
                            minlength="6"
                            maxlength="6"
                        />
                        <span
                            class="help-block"
                            v-if="has_error && errors.dob"
                            >{{ errors.dob }}
                        </span>
                    </div>

                    <div class="form-group">
                        <button
                            type="submit"
                            class="btn btn-block btn-primary btn-lg font-weight-medium"
                        >
                            SUBMIT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: "",
            email: "",
            phone: "",
            dob: "",
            has_error: false,
            error: "",
            errors: {},
            success: false
        };
    },
    methods: {
        register() {
            this.$auth.register({
                data: {
                    name: this.name,
                    phone: this.phone,
                    dob: this.dob,
                    email: this.email
                },
                success: function() {
                    this.success = true;
                    this.$router.push({
                        name: "login",
                        params: { successRegistrationRedirect: true }
                    });
                },
                error: function(res) {
                    console.log(res.response.data.errors);
                    this.has_error = true;
                    this.error = res.response.data.error;
                    this.errors = res.response.data.errors || {};
                }
            });
        }
    }
};
</script>
