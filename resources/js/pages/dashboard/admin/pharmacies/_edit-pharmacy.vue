<template>
    <div class="app-content content">
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row m-0">
                        <div class="col-lg-6">
                            <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                            <p>{{ $route.meta.subtitle }}</p>

                            <form
                                class="pt-3 form-row"
                                autocomplete="off"
                                @submit.prevent="addProvider"
                                method="post"
                            >
                                <div
                                    class="form-group col-md-12"
                                >
                                    <label for="name">Name</label>
                                    <input
                                        type="name"
                                        id="name"
                                        class="form-control"
                                        placeholder="Enter name"
                                        v-model="provider.name"
                                        v-bind:class="{
                                            'is-invalid': has_error && errors.name
                                        }"
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
                                >
                                    <label for="email">Email Address</label>
                                    <input
                                        type="email"
                                        id="email"
                                        class="form-control"
                                        placeholder="prescriber@example.com"
                                        v-model="provider.user.email"
                                        v-bind:class="{
                                            'is-invalid': has_error && errors.email
                                        }"
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
                                >
                                    <label for="phone">Phone Number</label>
                                    <input
                                        type="number"
                                        id="phone"
                                        class="form-control"
                                        v-model="provider.user.phone"
                                        placeholder="Enter phone"
                                        minlength="10"
                                        maxlength="10"
                                        v-bind:class="{
                                            'is-invalid': has_error && errors.phone
                                        }"
                                    />
                                    <span
                                        class="help-block"
                                        v-if="has_error && errors.phone"
                                        >{{ errors.phone }}
                                    </span>
                                </div>

                                <div
                                    class="form-group col-md-6"
                                >
                                    <label for="pharmacy_pioneer_rx_id">Pharmacy Pioneer RX ID</label>
                                    <input
                                        type="text"
                                        id="pharmacy_pioneer_rx_id"
                                        class="form-control"
                                        v-model="provider.pharmacy_pioneer_rx_id"
                                        v-bind:class="{ 'is-invalid': has_error && errors.pharmacy_pioneer_rx_id }"
                                    />
                                    <span
                                        class="help-block"
                                        v-if="has_error && errors.pharmacy_pioneer_rx_id"
                                        >{{ errors.pharmacy_pioneer_rx_id }}
                                    </span>
                                </div>

                                <div
                                    class="form-group col-md-6"
                                >
                                    <label for="npi">Web Address</label>
                                    <input
                                        type="text"
                                        id="web_address"
                                        class="form-control"
                                        v-model="provider.web_address"
                                        placeholder="https://"
                                        v-bind:class="{ 'is-invalid': has_error && errors.web_address }"
                                    />
                                    <span
                                        class="help-block"
                                        v-if="has_error && errors.web_address"
                                        >{{ errors.web_address }}
                                    </span>
                                </div>

                                <div class="form-group col-md-4" >
                                    <label for="npi">NCPDP</label>
                                    <input
                                        type="text"
                                        id="ncpdp"
                                        class="form-control"
                                        v-model="provider.ncpdp"
                                        v-bind:class="{ 'is-invalid': has_error && errors.ncpdp }"
                                    />
                                    <span
                                        class="help-block"
                                        v-if="has_error && errors.ncpdp"
                                        >{{ errors.ncpdp }}
                                    </span>
                                </div>

                                <div class="form-group col-md-4" >
                                    <label for="npi">NPI</label>
                                    <input
                                        type="text"
                                        id="npi"
                                        class="form-control"
                                        v-model="provider.npi"
                                        v-bind:class="{ 'is-invalid': has_error && errors.npi }"
                                    />
                                    <span
                                        class="help-block"
                                        v-if="has_error && errors.npi"
                                        >{{ errors.npi }}
                                    </span>
                                </div>

                                <div class="form-group col-md-4" >
                                    <label for="npi">DEA</label>
                                    <input
                                        type="text"
                                        id="dea"
                                        class="form-control"
                                        v-model="provider.dea"
                                        v-bind:class="{ 'is-invalid': has_error && errors.dea }"
                                    />
                                    <span
                                        class="help-block"
                                        v-if="has_error && errors.dea"
                                        >{{ errors.dea }}
                                    </span>
                                </div>

                                <div
                                    class="form-group col-md-12"
                                >
                                    <label for="name">Address</label>
                                    <textarea
                                        id="address"
                                        class="form-control"
                                        placeholder="Enter address"
                                        v-model="provider.address"
                                        v-bind:class="{
                                            'is-invalid': has_error && errors.address
                                        }"
                                    ></textarea>
                                    <span
                                        class="help-block"
                                        v-if="has_error && errors.address"
                                    >
                                        {{ errors.address }}</span
                                    >
                                </div>

                                <div class="form-group col-md-6 offset-md-6 text-right">
                                    <button
                                        type="submit"
                                        class="btn btn-primary font-weight-medium"
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
</template>
<script>
export default {
    data() {
        return {
            provider: { user: {} },
            has_error: false,
            error: "",
            errors: {},
            success: false
        }
    },
    created() {
        this.axios
            .get(`/api/providers/${this.$route.params.pharmacy}`)
            .then((response) => {
                this.provider = response.data;
            });
    },
    methods: {
        addProvider() {

            this.errors = {};

            if (!this.errors.length) {
                this.axios
                    .put(`/api/providers/${this.$route.params.pharmacy}`, this.provider)
                    .then(response =>
                        this.$router.push({ name: "all_pharmacy" })
                    )
                    .catch(error => console.log(error))
                    .finally(() => (this.loading = false));
            }

        }
    }
};
</script>



<style scoped>
    .help-block {
        color:red;
        font-style: italic;
        font-size: 12px;
    }

</style>
