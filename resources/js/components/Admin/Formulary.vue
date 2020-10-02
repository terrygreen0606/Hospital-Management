<template>
    <div class="row">
        <div class="col-md-6">
            <h2 class="font-weight-bold">
                Formulary
            </h2>
        </div>
        <div class="col-md-6 mb-3">
            <form
                enctype="multipart/form-data"
                novalidate
                action="/data/import"
                method="POST"
                    >
                <div class="form-group">
                    <input
                        type="hidden"
                        name="table"
                        value="formulary"
                    />
                    <input
                        type="file"
                        name="csv"
                        class="btn btn-info float-right ml-1"
                        style="height: 45px"
                    />
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary float-right">Import data</button>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive pmd-table-card">
                <table id="payment-listing" class="table table-stripped table-hover">
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
                        <tr 
                            v-for="f in formula.data" 
                            :key="f.id" 
                            style="cursor:pointer"
                            @click="getPrescribers(f)">
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
</template>

<script>
export default {
    data() {
        return {
            formula: {}
        };
    },
    mounted() {
        this.getFormularies();
    },
    methods: {
        getFormularies(page = 1) {
            let p = page == 1 ? "" : "?page=" + page;
            this.axios
                .get(`/api/formularies` + p)
                .then(response => {
                    this.formula = response.data;
                });
        },
        getPrescribers(data) {
            console.log(data)
            this.$router.push({ name: "formularyPrescribers", params:{non_premium:data.non_premium, premium:data.premium} })
        }
    }
};
</script>
