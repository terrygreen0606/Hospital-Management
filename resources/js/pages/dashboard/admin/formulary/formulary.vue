<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="row">
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
                                                <th>Disease state</th>
                                                <th>Product Type</th>
                                                <th>Product Name</th>
                                                <th>Size</th>
                                                <th>Brand/Generic</th>
                                                <th>Insurance</th>
                                                <th>DRx Club</th>
                                                <th>In stock / Out of stock</th>
                                                <th>Available with Insurance</th>
                                                <th>ETA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="formula.data.length == 0">
                                                <td colspan="10" class="small text-center">Nothing to Show</td>
                                            </tr>
                                            <tr 
                                                v-else
                                                v-for="f in formula.data" 
                                                :key="f.id" 
                                                style="cursor:pointer"
                                                @click="getPrescribers(f)">
                                                <td>{{f.disease_state}}</td>
                                                <td>{{f.product_type}}</td>
                                                <td>{{f.product_name}}</td>
                                                <td>{{f.size}}</td>
                                                <td>{{f.brand}}</td>
                                                <td>{{f.insurance}}</td>
                                                <td>{{f.drx_club}}</td>
                                                <td>{{f.stock_status}}</td>
                                                <td>{{f.available_with_insurance}}</td>
                                                <td>{{f.eta}}</td>
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
            this.$router.push({ name: "adminFormularyPrescribers", params:{non_premium:data.non_premium, premium:data.premium} })
        }
    }
};
</script>
