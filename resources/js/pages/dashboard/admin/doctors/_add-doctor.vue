<template>
    <div class="content">
        <div class="content-body">
            <div class="row m-0">
                <div class="col-lg-6">
                    <div class="card bg-transparent">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="mb-0">
                                    <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                                    <p>{{ $route.meta.subtitle }}</p>
                                </div>
                                <form
                                    class="pt-3 form-row"
                                    autocomplete="off"
                                    @submit.prevent="addPrescriber"
                                    method="post"
                                >
                                    <div
                                        class="form-group col-md-9"
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
                                        class="form-group col-md-3"
                                        v-bind:class="{
                                            'has-error': has_error && errors.name
                                        }"
                                    >
                                        <label for="name">Class</label>
                                        <select class="form-control">
                                            <option>A</option>
                                            <option>B</option>
                                            <option>C</option>
                                        </select>
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
                                            placeholder="prescriber@example.com"
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
                                        class="form-group col-md-6"
                                        v-bind:class="{ 'has-error': has_error && errors.npi }"
                                    >
                                        <label for="npi">Prescriber NPI</label>
                                        <input
                                            type="number"
                                            id="npi"
                                            class="form-control"
                                            v-model="npi"
                                            minlength="6"
                                            maxlength="6"
                                        />
                                        <span
                                            class="help-block"
                                            v-if="has_error && errors.npi"
                                            >{{ errors.npi }}
                                        </span>
                                    </div>

                                    <div
                                        class="form-group col-md-6"
                                        v-bind:class="{ 'has-error': has_error && errors.dea }"
                                    >
                                        <label for="npi">DEA Number</label>
                                        <input
                                            type="number"
                                            id="dea"
                                            class="form-control"
                                            v-model="dea"
                                            placeholder="Options: admin, patient, doctor"
                                            minlength="6"
                                            maxlength="6"
                                        />
                                        <span
                                            class="help-block"
                                            v-if="has_error && errors.dea"
                                            >{{ errors.dea }}
                                        </span>
                                    </div>

                                    <div
                                        class="form-group col-md-12"
                                        v-bind:class="{
                                            'has-error': has_error && errors.address
                                        }"
                                    >
                                        <label for="name">Address</label>
                                        <textarea
                                            id="address"
                                            class="form-control"
                                            placeholder="Enter address"
                                            v-model="address"
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
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: "",
            email: "",
            phone: "",
            npi: "",
            dea: "",
            address: '',

            has_error: false,
            error: "",
            errors: {},
            success: false
        };
    },
    methods: {
        addPrescriber() {
            this.axios
                .post("/api/prescribers", {
                    name: this.name,
                    phone: this.phone,
                    npi: this.npi,
                    email: this.email,
                    dea: this.dea,
                    address: this.address
                })
                .then(response =>
                    this.$router.push({ name: "all_doctors" })
                )
                .catch(error => console.log(error))
                .finally(() => (this.loading = false));
        }
    }
};
</script>
