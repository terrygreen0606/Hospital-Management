<template>
    <div class="content">
        <div class="content-body">
            <div class="row m-0">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="mb-3">
                                        <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                                        <p>{{ $route.meta.subtitle }}</p>
                                    </div>

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

                                    <table class="table" style="margin-bottom: 7rem !important;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NAME</th>
                                                <th>EMAIL </th>
                                                <th>WEB ADDRESS</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody v-if="pdata.data.length > 0">
                                            <tr 
                                                v-for="provider in pdata.data"
                                                :key="provider.id"
                                                style = "cursor: pointer;"
                                                >
                                                <td>{{ provider.id }}</td>
                                                <td>{{ provider.name }}</td>
                                                <td>{{ provider.user.email }}</td>
                                                <td >
                                                    <span v-if="provider.web_address">{{ provider.web_address }}</span>
                                                    <span v-else class="text-danger">N/A</span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="dropdown">
                                                        <button class="btn btn-block btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            OPTIONS
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <router-link :to="{ name: 'pharmacy_rx_history', params: { id: provider.id } }" class="dropdown-item">
                                                                <i class="bx bx-archive mr-1"></i> Open Details
                                                            </router-link>
                                                            <router-link :to="{ name: 'edit_pharmacy', params: { pharmacy: provider.id } }" class="dropdown-item">
                                                                <i class="bx bx-edit-alt mr-1"></i> Update Record
                                                            </router-link>
                                                            <a href="javascript:void(0)" class="dropdown-item" @click="deleteProvider(provider.id)">
                                                                <i class="bx bx-trash-alt mr-1"></i> Delete Record
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
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
                                        
                                        <tfoot class="d-table-footer" v-if="pdata.data.length > 0">
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
            pdata: { data: [] },
            search: ''
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
        
        searchQuery() {
            this.axios.get("/api/providers?s=" + this.search).then(response => {
                this.pdata = response.data;
            });
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
