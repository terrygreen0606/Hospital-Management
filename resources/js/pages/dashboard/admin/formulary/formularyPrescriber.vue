<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="font-weight-bold">
                                Formulary Doctors
                            </h2>
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
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="prescriber in prescribers.data"
                                            :key="prescriber.id"
                                        >
                                            <td>{{ prescriber.npi }}</td>
                                            <td>{{ prescriber.name }}</td>
                                            <td>{{ prescriber.phone }}</td>
                                            <td>{{ prescriber.primary_address }}</td>
                                            <td>{{ prescriber.dea }}</td>
                                            <td>{{ prescriber.status }}</td>
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            prescribers: {}
        };
    },
    mounted() {
        this.getPrescribers();
    },
    methods: {
        getPrescribers(page = 1) {
            console.log(this.$route.params)
            // ${this.$route.params.id}
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get(`/api/prescribersPremium/${this.$route.params.premium}/${this.$route.params.non_premium}` + p).then(response => {
                this.prescribers = response.data;
            });
        },
    }
};
</script>
