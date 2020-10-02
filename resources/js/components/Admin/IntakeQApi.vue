<template>
    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bold">
                IntakeQ API
                <router-link to="/" class="font-weight-bold float-right">
                    <i class="ti-home"></i>
                </router-link>
            </h4>
        </div>
        <div class="col-md-12">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="new-tab" data-toggle="tab" href="#new" role="tab" aria-controls="new" aria-selected="true">New Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="partial-tab" data-toggle="tab" href="#partial" role="tab" aria-controls="partial" aria-selected="false">Partial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="full-tab" data-toggle="tab" href="#full" role="tab" aria-controls="full" aria-selected="false">100% Match</a>
                </li>
            </ul>


            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="new" role="tabpanel" aria-labelledby="new-tab">
                    <div class="table-responsive pmd-table-card">
                        <table id="payment-listing" class="table pmd-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Match</th>
                                    <th>Matches</th>
                                    <th>Mismatches</th>
                                    <th>Date Received</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="p in new_data.data" :key="p.id">
                                    <td>{{ p.id }}</td>
                                    <td>{{ p.name }}</td>
                                    <td>{{ p.match_type }}</td>
                                    <td>{{ p.matches }}</td>
                                    <td>{{ p.mismatches }}</td>
                                    <td>{{ p.created_at }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td colspan="6" class="text-left pl-2">
                                    <pagination
                                        :limit="1"
                                        :data="new_data"
                                        @pagination-change-page="getNewData"
                                    ></pagination>
                                </td>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show" id="partial" role="tabpanel" aria-labelledby="partial-tab">
                    <div class="table-responsive pmd-table-card">
                        <table id="payment-listing" class="table pmd-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Match</th>
                                    <th>Matches</th>
                                    <th>Mismatches</th>
                                    <th>Date Received</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="p in partial_data.data" :key="p.id">
                                    <td>{{ p.id }}</td>
                                    <td>{{ p.name }}</td>
                                    <td>{{ p.match_type }}</td>
                                    <td>{{ p.matches }}</td>
                                    <td>{{ p.mismatches }}</td>
                                    <td>{{ p.created_at }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td colspan="6" class="text-left pl-2">
                                    <pagination
                                        :limit="1"
                                        :data="partial_data"
                                        @pagination-change-page="getPartialData"
                                    ></pagination>
                                </td>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade show" id="full" role="tabpanel" aria-labelledby="full-tab">
                    <div class="table-responsive pmd-table-card">
                        <table id="payment-listing" class="table pmd-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Match</th>
                                    <th>Matches</th>
                                    <th>Mismatches</th>
                                    <th>Date Received</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="p in full_data.data" :key="p.id">
                                    <td>{{ p.id }}</td>
                                    <td>{{ p.name }}</td>
                                    <td>{{ p.match_type }}</td>
                                    <td>{{ p.matches }}</td>
                                    <td>{{ p.mismatches }}</td>
                                    <td>{{ p.created_at }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td colspan="6" class="text-left pl-2">
                                    <pagination
                                        :limit="1"
                                        :data="full_data"
                                        @pagination-change-page="getFullData"
                                    ></pagination>
                                </td>
                            </tfoot>
                        </table>
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
            new_data: {},
            partial_data: {},
            full_data: {}
        };
    },
    mounted() {
        this.getNewData();
        this.getPartialData();
        this.getFullData();
    },
    methods: {
        getNewData(page = 1) {
            let p = page == 1 ? "" : "page=" + page;
            let q = "New Data"
            this.axios
                .get(`/api/intakeq/`+q+`?` + p)
                .then(response => {
                    this.new_data = response.data;
                });
        },


        getPartialData(page = 1) {
            let p = page == 1 ? "" : "page=" + page;
            let q = "Partial"
            this.axios
                .get(`/api/intakeq/`+q+`?` + p)
                .then(response => {
                    this.partial_data = response.data;
                });
        },

        getFullData(page = 1) {
            let p = page == 1 ? "" : "page=" + page;
            let q = "100% Match"
            this.axios
                .get(`/api/intakeq/`+q+`?` + p)
                .then(response => {
                    this.full_data = response.data;
                });
        }
    }
};
</script>
