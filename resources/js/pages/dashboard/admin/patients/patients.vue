<template>
    <div class="content">
        <div class="content-body">
            <div class="row m-0">
                <div class="col-12">
                    <div class="card bg-transparent">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                                    <p>{{ $route.meta.subtitle }}</p>
                                </div>

                                <div class="table-responsive">
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

                                    <table class="table mb-0">
                                        <thead class="">
                                            <tr>
                                                <th><strong>NAME</strong></th>
                                                <th>EMAIL ADDRESS</th>
                                                <th>PHONE NUMBER</th>
                                                <th>DOB</th>
                                                <th>LOCATION</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>

                                        <tbody v-if="users.data.length > 0">
                                            <tr v-for="user in users.data" :key="user.id">
                                                <td class="text-bold-500">{{ user.name }}</td>
                                                <td>{{ user.email }}</td>
                                                <td>{{ user.phone }}</td>
                                                <td>{{ user.dob }}</td>
                                                <td>{{ user.address }}</td>
                                                <td><a href="#"><i class="badge-circle badge-circle-light-secondary bx bx-envelope font-medium-1"></i></a></td>
                                            </tr>
                                            
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td class="text-center py-4" colspan="6">
                                                    <h5 class="mb-0">
                                                        <i class='bx bx-info-circle d-block' style="font-size: 40px; margin-bottom: 5px;"></i>
                                                        No records available to be displayed.
                                                    </h5>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tfoot class="d-table-footer" v-if="users.data.length > 0">
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
            users: {},
            search: ""
        };
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        getUsers(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            this.axios.get("/api/users?role=patient" + p).then(response => {
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
            this.axios.get("/api/users?role=patient&s=" + this.search).then(response => {
                this.users = response.data;
            });
        },

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
