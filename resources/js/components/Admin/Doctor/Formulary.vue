<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="font-weight-bold">
                                Formulary
                            </h2>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive pmd-table-card">
                                <table id="payment-listing" class="table table-stripped">
                                    <thead>
                                        <tr>
                                            <th>Drug Name</th>
                                            <th>Strength</th>
                                            <th>Form</th>
                                            <th>Quantity</th>
                                            <th>Disease State</th>
                                            <th>Premium</th>
                                            <th>Non Premium</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="f in formula.data" :key="f.id">
                                            <td>{{f.drug_name}}</td>
                                            <td>{{f.strength}}</td>
                                            <td>{{f.form}}</td>
                                            <td>{{f.qty}}</td>
                                            <td>{{f.disease_state}}</td>
                                            <td>{{f.premium}}</td>
                                            <td>{{f.non_premium}}</td>
                                            <td>{{f.category}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="8" class="text-left pl-2">
                                            <pagination
                                                :limit="1"
                                                :data="formula"
                                                @pagination-change-page="getFormularies"
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
            formula: {},
            status: null
        };
    },
    mounted() {
        this.getFormularies();
        // console.log(this.props)
    },
    methods: {
        getFormularies(page = 1) {
            let p = page == 1 ? "" : "?page=" + page;
                this.axios
                    .get(`/api/myFormularies/${this.$route.params.status}` + p)
                    .then(response => {
                        this.formula = response.data;
                    });
        }
    }
};
</script>
