<template>
    <div class="row">
        <div class="col-md-4">
            <h4 class="font-weight-bold">User Accounts<br /></h4>
            <pagination
                :limit="2"
                size="small"
                :data="users"
                @pagination-change-page="getUsers"
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
        <div class="col-md-12">
            <div class="table-responsive pmd-table-card">
                <table id="user-listing" class="table pmd-table records">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th>D.O.B</th>
                            <th>Role</th>
                            <th>Joined On</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td data-title="Name">
                                {{ user.name }}
                            </td>
                            <td data-title="Email">
                                {{ user.email }}
                            </td>
                            <td data-title="Phone">
                                {{ user.phone }}
                            </td>
                            <td data-title="D.O.B">
                                {{ user.dob }}
                            </td>
                            <td data-title="Role" class="text-capitalize">
                                {{ user.role }}
                            </td>
                            <td data-title="Joined">
                                {{ user.created_at }}
                            </td>
                            <td data-title="" class="text-center">
                                <button
                                    class="btn btn-info btn-rounded btn-icon"
                                    @click="mirrorMe(user.id)"
                                >
                                    <i class="ti-eye"></i>
                                </button>
                                <router-link
                                    :to="{
                                        name: 'edituser',
                                        params: { id: user.id }
                                    }"
                                    tag="button"
                                    class="btn btn-dark btn-rounded btn-icon"
                                >
                                    <i class="ti-pencil"></i>
                                </router-link>
                                <button
                                    @click="deleteUser(user.id)"
                                    class="btn btn-danger btn-rounded btn-icon"
                                >
                                    <i class="ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="d-table-footer">
                        <td colspan="6" class="text-left pl-2">
                            <pagination
                                :limit="1"
                                :data="users"
                                @pagination-change-page="getUsers"
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
            users: {},
            search: ""
        };
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        async deleteUser(id) {
            const willDelete = await swal({
                title: "Are you sure?",
                text: "Are you sure that you want to delete this user?",
                icon: "warning",
                dangerMode: true,
                buttons: true,
            });
            
            if (willDelete) {
                this.axios.delete(`/api/users/${id}`).then(response => {
                    let i = this.users.map(item => item.id).indexOf(id); // find index of your object
                    this.users.splice(i, 1);
                });
            }
        },
        getUsers(page = 1) {
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get("/api/users" + p).then(response => {
                this.users = response.data;
            });
        },

        searchQuery() {
            this.axios.get("/api/users?s=" + this.search).then(response => {
                this.users = response.data;
            });
        },

        mirrorMe(id) {

            if(confirm("Proceed to this user account?")){
                let data = {
                    id : id
                }
                this.axios.post(`/api/mirrorLogin`, data).then(response => {
                    if(response.data.status == 'success'){
                    localStorage.setItem('mirrorView', 1) 
                    localStorage.setItem('admin_id', this.$auth.user().id) 
                    if(response.data.role == 'prescriber')this.$router.push({ name: "PrescriberHome" })
                    if(response.data.role == 'provider')this.$router.push({ name: "ProviderHomeDashboard" })
                    if(response.data.role == 'patient') this.$router.push({ name: "home" })
                    location.reload();
                    }
                });
            }
        }
    }
};
</script>
