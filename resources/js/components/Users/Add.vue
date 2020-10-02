<template>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new user</h4>
            <div class="row">
                <div class="col-md-12">
                    <form
                        class="pt-3 form-row"
                        autocomplete="off"
                        @submit.prevent="addUser"
                        method="post"
                    >
                        <div
                            class="form-group col-md-12"
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
                            class="form-group col-md-6"
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
                            class="form-group col-md-6"
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
                                placeholder="Enter phone number"
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
                            class="form-group col-md-6"
                            v-bind:class="{ 'has-error': has_error && errors.dob }"
                        >
                            <label for="dob">Date of Birth</label>
                            <input
                                type="number"
                                id="dob"
                                class="form-control"
                                v-model="dob"
                                placeholder="Format: mmddyy"
                                minlength="6"
                                maxlength="6"
                            />
                            <span
                                class="help-block"
                                v-if="has_error && errors.dob"
                                >{{ errors.dob }}
                            </span>
                        </div>

                        <div
                            class="form-group col-md-6"
                            v-bind:class="{ 'has-error': has_error && errors.role }"
                        >
                            <label for="role">Role</label>
                            <select
                                class="form-control"
                                id="role"
                                v-model="role"
                                >
                                <option value="admin">Admin</option>
                                <option value="patient">Patient</option>
                                <option value="provider">Provider</option>
                                <option value="prescriber">Doctor</option>
                            </select>
                            <span
                                class="help-block"
                                v-if="has_error && errors.role"
                                >{{ errors.role }}
                            </span>
                        </div>

                        <div class="form-group col-md-6 offset-md-6">
                            <button
                                type="submit"
                                class="btn btn-block btn-primary btn-lg font-weight-medium"
                            >
                                Create Account
                            </button>
                        </div>
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
            name: "",
            email: "",
            phone: "",
            dob: "",
            role: "",

            has_error: false,
            error: "",
            errors: {},
            success: false
        };
    },
    methods: {
        addUser() {
            this.axios
                .post("/api/users", {
                    name: this.name,
                    phone: this.phone,
                    dob: this.dob,
                    email: this.email,
                    role: this.role
                })
                .then(response =>
                    this.$router.push({ name: "allusers" })
                )
                .catch(error => console.log(error))
                .finally(() => (this.loading = false));
        }
    }
};
</script>
