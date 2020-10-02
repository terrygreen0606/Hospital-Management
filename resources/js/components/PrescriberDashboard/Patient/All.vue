<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="font-weight-bold">
                                        My Patients<br />
                                    </h4>
                                </div>
                                <div class="col-md-4 offset-md-4">
                                    <div class="justify-content-lg-end">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text ti-search"
                                                ></div>
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
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>NAME</th>
                                                <th>PHONE NUMBER</th>
                                                <th>DOB</th>
                                                <th>LOCATION</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="user in users.data"
                                                :key="user.id"
                                            >
                                                <td class="text-bold-500">
                                                    {{ user.name }}
                                                </td>
                                                <td>{{ user.phone }}</td>
                                                <td>{{ user.dob }}</td>
                                                <td>
                                                    <span v-if="user.patient">{{ user.patient.address }}</span>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        ><i
                                                            class="badge-circle badge-circle-light-secondary bx bx-envelope font-medium-1"
                                                        ></i
                                                    ></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="d-table-footer">
                                            <td
                                                colspan="6"
                                                class="text-left pl-2"
                                            >
                                                <pagination
                                                    :limit="1"
                                                    :data="users"
                                                    @pagination-change-page="
                                                        getUsers
                                                    "
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
import swal from "sweetalert";
export default {
    data() {
        return {
            users: {},
            search: ""
        };
    },
    mounted() {
        this.getUsers();
        console.log("asdasd", this.$auth.user().id);
    },
    methods: {
        getUsers(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            this.axios
                .get("/api/prescriberPatients/" + this.$auth.user().id + p)
                .then(response => {
                    this.users = response.data;
                });
        },

        // async deleteUser(id) {
        //     const willDelete = await swal({
        //         title: "Are you sure?",
        //         text: "Are you sure that you want to delete this user?",
        //         icon: "warning",
        //         dangerMode: true,
        //         buttons: true,
        //     });

        //     if (willDelete) {
        //         this.axios.delete(`/api/users/${id}`).then(response => {
        //             let i = this.users.map(item => item.id).indexOf(id); // find index of your object
        //             this.users.splice(i, 1);
        //         });
        //     }
        // },

        searchQuery() {
            this.axios.get("/api/users?s=" + this.search).then(response => {
                this.users = response.data;
            });
        }

        // mirrorMe(id) {

        //     if(confirm("Proceed to this user account?")){
        //         let data = {
        //             id : id
        //         }
        //         this.axios.post(`/api/mirrorLogin`, data).then(response => {
        //             if(response.data.status == 'success'){
        //             localStorage.setItem('mirrorView', 1)
        //             localStorage.setItem('admin_id', this.$auth.user().id)
        //             if(response.data.role == 'prescriber')this.$router.push({ name: "PrescriberHome" })
        //             if(response.data.role == 'provider')this.$router.push({ name: "ProviderHomeDashboard" })
        //             if(response.data.role == 'patient') this.$router.push({ name: "home" })
        //             location.reload();
        //             }
        //         });
        //     }
        // }
    }
};
</script>
