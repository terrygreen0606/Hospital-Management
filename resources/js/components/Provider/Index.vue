<template>
    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bold">
                All Pharmacy
                <router-link to="/" class="font-weight-bold float-right">
                    <i class="ti-home"></i>
                </router-link>
            </h4>
        </div>
        <div class="col-md-12">
            <div class="table-responsive pmd-table-card">
                <table id="payment-listing" class="table pmd-table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email </th>
                            <th>Web address</th>
                            <th>Action</th>
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
                                        name: 'editprovider',
                                        params: { id: provider.id }
                                    }"
                                    tag="button"
                                    class="btn btn-dark btn-rounded btn-icon"
                                >
                                    <i class="ti-pencil"></i>
                                </router-link>
                                <button
                                    @click="deleteProvider(provider.id)"
                                    class="btn btn-danger btn-rounded btn-icon"
                                >
                                    <i class="ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
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
                text: "Are you sure that you want to delete this user?",
                icon: "warning",
                dangerMode: true,
                buttons: true,
            });
            
            if (willDelete) {
                this.axios.delete(`/api/providers/${id}`).then(response => {
                    let i = this.pdata.data.map(item => item.id).indexOf(id); // find index of your object
                    this.pdata.data.splice(i, 1);
                    swal("Deleted!", "User has been deleted has been deleted!", "success");
                });
            }
        },

        getProviders(page = 1) {
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get("/api/providers" + p).then(response => {
                this.pdata = response.data;
            });
        },

        details(data) {
            this.$router.push({ name: "providerRXHistory", params:{id:data.user_id} })
        }

    }
};
</script>
