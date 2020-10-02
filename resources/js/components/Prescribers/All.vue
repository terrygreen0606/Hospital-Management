<template>
    <div class="row">
        <div class="col-md-4">
            <h4 class="font-weight-bold">All Doctor<br /></h4>
            <pagination
                :limit="2"
                size="small"
                :data="prescribers"
                @pagination-change-page="getPrescribers"
            ></pagination>
        </div>
        <div class="col-md-4 offset-md-4">
            <div class="justify-content-lg-end">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <div class="input-group-text ti-search"></div>
                    </div>
                    <input
                        class="form-control form-control-sm"
                        placeholder="Type query and hit enter"
                        v-model="search"
                        v-on:keyup="searchQuery"
                    />
                </div>
            </div>
        </div>
        <div class="col-md-12" v-if="$route.query.success">
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
        <div class="col-md-12">
            <div class="table-responsive pmd-table-card">
                <table id="prescriber-listing" class="table pmd-table table-hover records">
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
                    <tbody>
                        <tr
                            v-for="prescriber in prescribers.data"
                            :key="prescriber.id"
                            style = "cursor: pointer;"
                        >
                            <td @click="details(prescriber)">{{ prescriber.npi }}</td>
                            <td @click="details(prescriber)">{{ prescriber.name }}</td>
                            <td @click="details(prescriber)">{{ prescriber.phone }}</td>
                            <td @click="details(prescriber)">{{ prescriber.primary_address }}</td>
                            <td @click="details(prescriber)">{{ prescriber.dea }}</td>
                            <td @click="details(prescriber)">{{ prescriber.created_at }}</td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'prescriberAdminFormulary',
                                        params: { status: prescriber.status }
                                    }"
                                    tag="button"
                                    class="btn btn-sm btn-info"
                                >
                                    Formulary
                                </router-link>
                                <router-link
                                    :to="{
                                        name: 'editprescriber',
                                        params: { id: prescriber.id }
                                    }"
                                    tag="button"
                                    class="btn btn-dark btn-rounded btn-icon"
                                >
                                    <i class="ti-pencil"></i>
                                </router-link>
                                <button
                                    @click="deletePrescriber(prescriber.id)"
                                    class="btn btn-danger btn-rounded btn-icon"
                                >
                                    <i class="ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
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
</template>

<script>
import swal from 'sweetalert';

export default {
    data() {
        return {
            prescribers: {},
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
            this.$router.push({ name: "prescriberRXHistory", params:{id:data.user_id} })
        }
    }
};
</script>
