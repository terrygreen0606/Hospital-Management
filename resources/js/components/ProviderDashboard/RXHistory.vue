<template>
    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bold">
                Provider RX History
            </h4>
        </div>
        <div class="col-md-12">
            <div class="table-responsive table-hover pmd-table-card">
                <table id="invoice-listing" class="table pmd-table">
                    <thead>
                        <tr>
                            <th>RX Number</th>
                            <th>Dispensed Item</th>
                            <th>NDC</th>
                            <th>Date Filled</th>
                            <th>Status</th>
                            <th>Tracking Number</th>
                            <th>Patient Name</th>
                            <th>Phone Number</th>
                            <th>Doctor NPI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr 
                            v-for="p in ppp.data" 
                            :key="p.id"
                            @click="details(p)"
                            style = "cursor: pointer;"
                            >
                                <td>{{ p.order.rx_number }}</td>
                                <td>{{ p.order.dispensed_item_name }}</td>
                                <td>{{ p.order.dispensed_item_ndc }}</td>
                                <td>{{ p.order.date_filled }}</td>
                                <td>{{ p.order.rx_status }}</td>
                                <td>{{ p.order.tracking_number }}</td>
                                <td>{{ p.patient.name }}</td>
                                <td>{{ p.patient.phone }}</td>
                                <td>{{ p.order.prescriber_npi }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <td colspan="9" class="text-left pl-2">
                            <pagination
                                :limit="1"
                                :data="ppp"
                                @pagination-change-page="getPPP"
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
            ppp: {},
            user: {}
        };
    },  
    mounted() {
        this.getPPP();
    },
    methods: {
        getPPP(page = 1) {
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get(`/api/providerHistory/${this.$auth.user().id}` + p).then(response => {
                this.ppp = response.data;
            });
        },

        details(data) {
            this.user = data;
            this.$router.push({ name: "rxDetails", params:{id:data.id} })
        }
    }
};
</script>
