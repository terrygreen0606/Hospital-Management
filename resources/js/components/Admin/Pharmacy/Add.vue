<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add new Pharmacy</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <form
                                        class="pt-3 form-row"
                                        autocomplete="off"
                                        @submit.prevent="addProvider"
                                        method="post"
                                    >
                                        <div class="form-group col-md-12">
                                            <label for="name">Name</label>
                                            <input
                                                type="name"
                                                id="name"
                                                class="form-control"
                                                placeholder="Enter name"
                                                v-model="name"
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

                                        <div class="form-group col-md-6">
                                            <label for="email">Email Address</label>
                                            <input
                                                type="email"
                                                id="email"
                                                class="form-control"
                                                placeholder="prescriber@example.com"
                                                v-model="email"
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

                                        <div class="form-group col-md-6">
                                            <label for="phone">Phone Number</label>
                                            <input
                                                type="number"
                                                id="phone"
                                                class="form-control"
                                                v-model="phone"
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

                                        <div class="form-group col-md-6">
                                            <label for="pharmacy_pioneer_rx_id">Pharmacy Pioneer RX ID</label>
                                            <input
                                                type="text"
                                                id="pharmacy_pioneer_rx_id"
                                                class="form-control"
                                                v-model="pharmacy_pioneer_rx_id"
                                                v-bind:class="{ 'is-invalid': has_error && errors.pharmacy_pioneer_rx_id }"
                                            />
                                            <span
                                                class="help-block"
                                                v-if="has_error && errors.pharmacy_pioneer_rx_id"
                                                >{{ errors.pharmacy_pioneer_rx_id }}
                                            </span>
                                        </div>

                                        <div class="form-group col-md-6" >
                                            <label for="npi">Web Address</label>
                                            <input
                                                type="text"
                                                id="web_address"
                                                class="form-control"
                                                v-model="web_address"
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
                                                v-model="ncpdp"
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
                                                v-model="npi"
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
                                                v-model="dea"
                                                v-bind:class="{ 'is-invalid': has_error && errors.dea }"
                                            />
                                            <span
                                                class="help-block"
                                                v-if="has_error && errors.dea"
                                                >{{ errors.dea }}
                                            </span>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="name">Address</label>
                                            <textarea
                                                id="address"
                                                class="form-control"
                                                placeholder="Enter address"
                                                v-model="address"
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
export default {
    data() {
        return {
            name: "",
            email: "",
            phone: "",
            pharmacy_pioneer_rx_id: "",
            web_address: "",
            address: '',
            ncpdp: '',
            npi: '',
            dea: '',

            has_error: false,
            error: "",
            errors: [],
            success: false
        };
    },
    methods: {
        addProvider() {

            this.errors = [];
            this.has_error = false;

            if (!this.name) {
                this.errors.name ="Name required.";
                this.has_error = true;
            }

            if (!this.phone) {
                this.errors.phone ="Phone required.";
                this.has_error = true;
            }

            if (!this.email) {
                this.errors.email ="Email required.";
                this.has_error = true;
            }

            if (!this.address) {
                this.errors.address ="Address required.";
                this.has_error = true;
            }

            if (!this.ncpdp) {
                this.errors.ncpdp ="NCPDP required.";
                this.has_error = true;
            }

            if (!this.npi) {
                this.errors.npi ="NPI required.";
                this.has_error = true;
            }

            if (!this.dea) {
                this.errors.dea ="DEA required.";
                this.has_error = true;
            }

            if (!this.has_error) {
                this.axios
                    .post("/api/providers", {
                        name: this.name,
                        phone: this.phone,
                        pharmacy_pioneer_rx_id: this.pharmacy_pioneer_rx_id,
                        email: this.email,
                        web_address: this.web_address,
                        address: this.address,
                        ncpdp: this.ncpdp,
                        npi: this.npi,
                        dea: this.dea
                    })
                    .then(response =>
                        this.$router.push({ name: "all_pharmacy" })
                        // console.log(response)
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
