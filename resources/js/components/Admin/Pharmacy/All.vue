<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Patients</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>NAME</th>
                                                <th>EMAIL </th>
                                                <th>WEB ADDRESS</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr 
                                                v-for="provider in pdata.data"
                                                :key="provider.id"
                                                style = "cursor: pointer;"
                                                >
                                                <td @click="details(provider)">{{ provider.id }}</td>
                                                <td @click="details(provider)">{{ provider.name }}</td>
                                                <td @click="details(provider)">{{ provider.user.email }}</td>
                                                <td @click="details(provider)">{{ provider.web_address }}</td>
                                                <td>
                                                    <router-link
                                                        :to="{
                                                            name: 'edit_pharmacy',
                                                            params: { id: provider.id }
                                                        }"
                                                        tag="button"
                                                        class="btn btn-dark btn-rounded btn-icon"
                                                    >
                                                        <i class="bx bx-edit-alt"></i>
                                                    </router-link>
                                                    <button
                                                        @click="deleteProvider(provider.id)"
                                                        class="btn btn-danger btn-rounded btn-icon"
                                                    >
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="d-table-footer">
                                            <td colspan="6" class="text-left pl-2">
                                                <pagination
                                                    :limit="1"
                                                    :data="pdata"
                                                    @pagination-change-page="getProviders"
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
            pdata: {}
        };
    },
    mounted() {
        this.getProviders();
    },
    methods: {

        async deleteProvider(id) {
            const willDelete = await swal({
                title: "Are you sure?",
                text: "Are you sure that you want to delete this Pharmacy?",
                icon: "warning",
                dangerMode: true,
                buttons: true,
            });
            
            if (willDelete) {
                this.axios.delete(`/api/providers/${id}`).then(response => {
                    let i = this.pdata.data.map(item => item.id).indexOf(id); // find index of your object
                    this.pdata.data.splice(i, 1);
                    swal("Deleted!", "Pharmacy has been deleted has been deleted!", "success");
                });
            }
        },

        getProviders(page = 1) {
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get("/api/providers" + p).then(response => {
                this.pdata = response.data;
                console.log(response.data)
            });
        },

        details(data) {
            this.$router.push({ name: "providerRXHistory", params:{id:data.user_id} })
        }

    }
};
</script>
