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
                                    class="form form-vertical"
                                    autocomplete="off"
                                    @submit.prevent="addUser"
                                    method="post"
                                    >
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first-name-icon">Name</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text"
                                                            id="first-name-icon"
                                                            class="form-control bg-transparent"
                                                            name="fname-icon"
                                                            placeholder="Full Name"
                                                            v-model="name"
                                                            required
                                                            >
                                                        <div class="form-control-position">
                                                            <i class="bx bx-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-icon">Email</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="email"
                                                            id="email-id-icon"
                                                            class="form-control bg-transparent"
                                                            name="email-id-icon"
                                                            placeholder="Email"
                                                            v-model="email"
                                                            required
                                                            >
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mail-send"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="contact-info-icon">Phone</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="number"
                                                            id="contact-info-icon"
                                                            class="form-control bg-transparent"
                                                            name="contact-icon"
                                                            placeholder="Mobile"
                                                            v-model="phone"
                                                            required
                                                            >
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mobile"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="dob-info-icon">Date of Birth</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="date"
                                                            id="dob-info-icon"
                                                            class="form-control bg-transparent"
                                                            name="contact-icon"
                                                            placeholder="DOB"
                                                            v-model="dob"
                                                            required
                                                            >
                                                        <div class="form-control-position">
                                                            <i class="bx bxs-calendar-alt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="addressMe">Address</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text"
                                                            id="addressMe"
                                                            class="form-control bg-transparent"
                                                            name="contact-icon"
                                                            placeholder="Address"
                                                            v-model="address"
                                                            required
                                                            >
                                                        <div class="form-control-position">
                                                            <i class="bx bxs-map-alt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end px-0">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                                <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
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
    </div>
    <!-- END: Content-->
    
</template>

<script>
import swal from 'sweetalert';
export default {
    data() {
        return {
            name: "",
            email: "",
            phone: "",
            dob: "",
            role: "patient",
            address: "",

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
                    address: this.address,
                    role: this.role
                })
                .then(response =>
                    this.$router.push({ name: "all_patients" })
                )
                .catch(error => console.log(error))
                .finally(() => (this.loading = false));
        }
    }
};
</script>
