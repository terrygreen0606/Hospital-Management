<template>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Editing {{ user.name }} Details</h4>
            <div class="row">
                <div class="col-md-12">
                    <form @submit.prevent="updateUser" class="row">
                        <div class="form-group col-md-6">
                            <label>Full Name</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="user.name"
                            />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Date of Birth</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="user.dob"
                            />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email Address</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="user.email"
                            />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone Number</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="user.phone"
                            />
                        </div>

                        <div
                            class="collapse form-group col-md-12"
                            id="user-details"
                             v-if="user.patient !== null"
                        >
                            <div class="form-group">
                                <label>Shipping Address</label>
                                <input
                                    class="form-control form-control-sm"
                                    v-model="user.patient.address"
                                />
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>City</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        v-model="user.patient.city"
                                    />
                                </div>
                                <div class="form-group col-md-3">
                                    <label>State</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        v-model="user.patient.state"
                                    />
                                </div>
                                <div class="form-group col-md-5">
                                    <label>Zip Code</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        v-model="user.patient.zip_code"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6 pt-3">
                            <a
                                class="w-100 text-left"
                                data-toggle="collapse"
                                href="#user-details"
                                role="button"
                                aria-expanded="false"
                                aria-controls="user-details"
                                v-if="user.patient !== null"
                            >
                                <h5>
                                    Edit Shipping Details
                                    <i class="ti-pencil float-right"></i>
                                </h5>
                            </a>
                        </div>

                        <div class="form-group col-md-6">
                            <button
                                type="submit"
                                class="btn btn-primary btn-block"
                            >
                                Update Profile
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
            user: {}
        };
    },
    created() {
        this.axios.get(`/api/users/${this.$route.params.id}`).then(response => {
            this.user = response.data;
            console.log(response.data);
        });
    },
    methods: {
        updateUser() {
            var app = this;
            this.axios
                .put(`/api/users/${this.$route.params.id}`, this.user)
                .then(response => {
                    app.$router.push({ name: "allusers" });
                });
        }
    }
};
</script>
