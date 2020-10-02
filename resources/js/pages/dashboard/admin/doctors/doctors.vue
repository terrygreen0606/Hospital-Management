<template>
    <div class="content">
        <div class="content-body">
            <div class="row m-0">
                <div class="col-lg-12" v-if="$route.query.success">
                    <div
                        class="alert alert-success alert-dismissible fade show"
                        role="alert"
                    >
                        All doctors have been imported successfully
                        <button
                            type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-12">

                    <div class="card bg-transparent">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                                    <p>{{ $route.meta.subtitle }}</p>
                                </div>

                                <div class="table-responsive pmd-table-card">

                                    <div class="row m-0">
                                        <div class="col-lg-4 px-0 mb-1">
                                            <div class="form-group">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text"
                                                        id="first-name-icon"
                                                        class="form-control bg-transparent"
                                                        name="fname-icon"
                                                        placeholder="Search here"
                                                        v-model="search"
                                                        required
                                                        v-on:keyup="searchQuery"
                                                        >
                                                    <div class="form-control-position">
                                                        <i class="bx bx-search-alt-2"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <table id="prescriber-listing" class="table pmd-table table-hover records" style="margin-bottom: 9.1rem !important;">
                                        <thead>
                                            <tr>
                                                <th>NPI</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Primary Address</th>
                                                <th>DEA</th>
                                                <th>Added</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody v-if="prescribers.data.length > 0">
                                            <tr
                                                v-for="prescriber in prescribers.data"
                                                :key="prescriber.id"
                                                style = "cursor: pointer;"
                                            >
                                                <td >{{ prescriber.npi }}</td>
                                                <td>{{ prescriber.name }}</td>
                                                <td>{{ prescriber.phone }}</td>
                                                <td>
                                                    <span v-if="prescriber.primary_address">
                                                        {{ prescriber.primary_address }}
                                                    </span>
                                                    <span v-else class="text-danger">N/A</span>
                                                </td>
                                                <td>{{ prescriber.dea }}</td>
                                                <td>{{ prescriber.created_at }}</td>
                                                <td class="text-right">
                                                    <div class="dropdown">
                                                        <button class="btn btn-block btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            OPTIONS
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a
                                                                href="javascript:void(0)"
                                                                @click="details(prescriber)"
                                                                class="dropdown-item"
                                                            >
                                                                View Record
                                                            </a>
                                                            <router-link
                                                                :to="{
                                                                    name: 'doctor_admin_formulary',
                                                                    params: { status: prescriber.status }
                                                                }"
                                                                class="dropdown-item"
                                                            >
                                                                Formulary
                                                            </router-link>
                                                            <router-link
                                                                :to="{
                                                                    name: 'edit_doctor',
                                                                    params: { id: prescriber.id }
                                                                }"
                                                                class="dropdown-item"
                                                            >
                                                                Edit Record
                                                            </router-link>
                                                            <a
                                                                href="javascript:void(0)"
                                                                @click="deletePrescriber(prescriber.id)"
                                                                class="dropdown-item"
                                                            >
                                                                Delete Record
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td class="text-center py-4" colspan="7">
                                                    <h5 class="mb-0">
                                                        <i class='bx bx-info-circle d-block' style="font-size: 40px; margin-bottom: 5px;"></i>
                                                        No records available to be displayed.
                                                    </h5>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tfoot v-if="prescribers.data.length > 0">
                                            <td colspan="7" class="text-left pl-2">
                                                <pagination
                                                    :limit="1"
                                                    :data="prescribers"
                                                    @pagination-change-page="getPrescribers"
                                                ></pagination>
                                            </td>
                                        </tfoot>
                                    </table>
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
            prescribers: { data: [] },
            search: ""
        };
    },
    mounted() {
        this.getPrescribers();
    },
    methods: {
        async deletePrescriber(id) {
            const willDelete = await swal({
                title: "Are you sure?",
                text: "Are you sure that you want to delete this user?",
                icon: "warning",
                dangerMode: true,
                buttons: true,
            });
            
            if (willDelete) {
                this.axios.delete(`/api/prescribers/${id}`).then(response => {
                    let i = this.prescribers.data.map(item => item.id).indexOf(id); // find index of your object
                    this.prescribers.data.splice(i, 1);
                    swal("Deleted!", "User has been deleted has been deleted!", "success");
                });
            }

        },

        getPrescribers(page = 1) {
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get("/api/prescribers" + p).then(response => {
                this.prescribers = response.data;
                console.log(response.data)
            });
        },

        searchQuery() {
            this.axios.get("/api/prescribers?s=" + this.search).then(response => {
                this.prescribers = response.data;
            });
        },

        details(data) {
            this.$router.push({ name: "doctor_rx_history", params:{id:data.user_id} })
        }
    }
};
</script>
