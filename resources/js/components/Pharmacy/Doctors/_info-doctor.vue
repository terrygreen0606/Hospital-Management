<template>
    <div class="app-content content">
        <div class="content-body">
            <div class="row m-0">
                <div class="col-lg-12">
                    <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                    <p>{{ $route.meta.subtitle }}</p>
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
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            ppp: {}
        };
    },  
    mounted() {
        this.getPPP();
    },
    methods: {
        getPPP(page = 1) {
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get(`/api/prescriberHistory/${this.$route.params.id}` + p).then(response => {
                this.ppp = response.data;
            });
        },

        details(data) {
            this.$router.push({ name: "orderDetail", params:{order_id:data.order.id, user_id:data.patient.id} })
        }
    }
};
</script>
