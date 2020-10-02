<template>
    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bold">
                Pioneer API
                <router-link to="/" class="font-weight-bold float-right">
                    <i class="ti-home"></i>
                </router-link>
            </h4>
        </div>
        <div class="col-md-12">
            <div class="table-responsive pmd-table-card">
                <table id="payment-listing" class="table pmd-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Status </th>
                            <th>Date Received</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="p in pdata.data" :key="p.id">
                            <td>{{ p.id }}</td>
                            <td>{{ p.data.substr(1, 100) }}</td>
                            <td>{{ p.status }}</td>
                            <td>{{ p.created_at }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <td colspan="6" class="text-left pl-2">
                            <pagination
                                :limit="1"
                                :data="pdata"
                                @pagination-change-page="getPioneerData"
                            ></pagination>
                        </td>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            pdata: {}
        };
    },
    mounted() {
        this.getPioneerData();
    },
    methods: {
        getPioneerData(page = 1) {
            let p = page == 1 ? "" : "page=" + page;
            this.axios
                .get(`/api/pioneer?` + p)
                .then(response => {
                    this.pdata = response.data;

                    console.log(this.pdata)
                });
        }
    }
};
</script>
