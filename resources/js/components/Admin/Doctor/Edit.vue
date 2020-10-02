<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add new Doctor</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <form
                                        class="pt-3 form-row"
                                        autocomplete="off"
                                        @submit.prevent="updatePrescriber"
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
                                                v-model="prescriber.name"
                                            />
                                            <span
                                                class="help-block"
                                                v-if="has_error && errors.prescriber.name"
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
                                                placeholder="prescriber@example.com"
                                                v-model="prescriber.email"
                                            />
                                            <span
                                                class="help-block"
                                                v-if="has_error && errors.prescriber.email"
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
                                                v-model="prescriber.phone"
                                                placeholder="Enter phone"
                                                minlength="10"
                                                maxlength="10"
                                            />
                                            <span
                                                class="help-block"
                                                v-if="has_error && errors.prescriber.phone"
                                                >{{ errors.phone }}
                                            </span>
                                        </div>

                                        <div
                                            class="form-group col-md-6"
                                            v-bind:class="{ 'has-error': has_error && errors.npi }"
                                        >
                                            <label for="npi">Prescriber NPI</label>
                                            <input
                                                type="number"
                                                id="npi"
                                                class="form-control"
                                                v-model="prescriber.npi"
                                                minlength="6"
                                                maxlength="6"
                                            />
                                            <span
                                                class="help-block"
                                                v-if="has_error && errors.prescriber.npi"
                                                >{{ errors.npi }}
                                            </span>
                                        </div>

                                        <div
                                            class="form-group col-md-6"
                                            v-bind:class="{ 'has-error': has_error && errors.dea }"
                                        >
                                            <label for="npi">DEA Number</label>
                                            <input
                                                type="text"
                                                id="dea"
                                                class="form-control"
                                                v-model="prescriber.dea"
                                                minlength="6"
                                                maxlength="6"
                                            />
                                            <span
                                                class="help-block"
                                                v-if="has_error && errors.prescriber.dea"
                                                >{{ errors.dea }}
                                            </span>
                                        </div>

                                        <div
                                            class="form-group col-md-12"
                                            v-bind:class="{
                                                'has-error': has_error && errors.prescriber.address
                                            }"
                                        >
                                            <label for="name">Address</label>
                                            <textarea
                                                id="address"
                                                class="form-control"
                                                placeholder="Enter address"
                                                v-model="prescriber.address"
                                            ></textarea>
                                            <span
                                                class="help-block"
                                                v-if="has_error && errors.prescriber.address"
                                            >
                                                {{ errors.address }}</span
                                            >
                                        </div>

                                        <div class="form-group col-md-6 offset-md-6">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import swal from 'sweetalert';

    export default {
        data() {
            return {
                prescriber: {},

                has_error: false,
                error: "",
                errors: [],
            }
        },
        created() {
            this.axios
                .get(`/api/prescribers/${this.$route.params.id}`)
                .then((response) => {
                    this.prescriber = response.data;
                    console.log(response.data);
                });
        },
        methods: {
            updatePrescriber() {
                this.axios
                    .put(`/api/prescribers/${this.$route.params.id}`, this.prescriber)
                    .then((response) => {
                        swal("Updated!", "User data updated successfully!", "success");
                        this.$router.push({name: 'all_doctors'});
                    });
            }
        }
    }
</script>