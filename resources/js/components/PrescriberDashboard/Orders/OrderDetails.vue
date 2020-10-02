<template>
    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bold">
                Order Detail
            </h4>
        </div>
        <div class="col-md-12">
            <div class="table-responsive table-hover pmd-table-card">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <td>Name:</td>
                                <td>{{ data.patient ? data.patient.name : '' }}</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>{{ data.patient ? data.patient.email : '' }}</td>
                            </tr>
                            <tr>
                                <td>Phone:</td>
                                <td>{{ data.patient ? data.patient.phone : '' }}</td>
                            </tr>
                            <tr>
                                <td>Category:</td>
                                <td>{{ data.patient ? data.patient.patient.category : '' }}</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>{{ data.patient ? data.patient.patient.address + ', ' + data.patient.patient.city + ', ' + data.patient.patient.state + ', ' + data.patient.patient.zipcode  : '' }}</td>
                            </tr>
                            <tr>
                                <td>Dispensed Item:</td>
                                <td id="itemDispensed">{{ data.order ? data.order.dispensed_item_name : '' }}</td>
                            </tr>
                            <tr>
                                <td>Item NDC:</td>
                                <td id="itemNDC">{{ data.order ? data.order.dispensed_item_ndc : '' }}</td>
                            </tr>
                            <tr>
                                <td>Doctor NPI:</td>
                                <td id="itemPrescriber">{{ data.order ? data.order.prescriber_npi : '' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                            <div style="text-align:center">
                                <iframe 
                                    frameborder="1"
                                    width="500px"
                                    height="400px"
                                    id="vidSrc"
                                    ></iframe><br>
                                    <button id="playBtn" class="btn btn-sm btn-primary" @click="playVid()">
                                        Play Video
                                    </button>
                            </div>
                    </div>


                    <div class="col-md-12 div">

                        <h4 class="font-weight-bold hdr">
                            Patient History
                        </h4>

                        <table id="invoice-listing" class="table pmd-table">
                            <thead>
                                <tr>
                                    <th>RX Number</th>
                                    <th>Dispensed Item</th>
                                    <th>NDC</th>
                                    <th>Date Filled</th>
                                    <th>Status</th>
                                    <th>Pharmacy Name</th>
                                    <th>Doctor NPI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="p in orders.data" 
                                    :key="p.id"
                                    style = "cursor: pointer;"
                                    @click="getDetails(p.id)"
                                    >
                                        <td>{{ p.rx_number }}</td>
                                        <td>{{ p.dispensed_item_name }}</td>
                                        <td>{{ p.dispensed_item_ndc }}</td>
                                        <td>{{ p.date_filled }}</td>
                                        <td>{{ p.rx_status }}</td>
                                        <td>{{ p.pharmacy_name }}</td>
                                        <td>{{ p.prescriber_npi }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td colspan="9" class="text-left pl-2">
                                    <pagination
                                        :limit="1"
                                        :data="orders"
                                        @pagination-change-page="getOrders"
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
            data: {},
            orders: {},
            vidSrc: ''
        };
    }, 
    created() {
        this.axios
            .get(`/api/getOrderData/${this.$route.params.user_id}/${this.$route.params.order_id}`)
            .then((response) => {
                this.data = response.data;
                this.vidSrc = response.data.order.video;
            });
    },  
    mounted() {
        setTimeout(() => {
            this.getOrders()
        }, 3000); 
    },
    methods: {
        getOrders(page = 1){
            let p = page == 1 ? "" : "?page=" + page;
            this.axios
                .get(`/api/getOrders/${this.data.patient_id}` + p)
                .then((response) => {
                    this.orders = response.data;
                });
        },
        getDetails(id) {
            this.axios
                .get(`/api/orders/${id}`)
                .then((response) => {
                    document.getElementById('itemPrescriber').innerHTML = response.data.prescriber_npi
                    document.getElementById('itemNDC').innerHTML = response.data.dispensed_item_ndc
                    document.getElementById('itemDispensed').innerHTML = response.data.dispensed_item_name
                    document.getElementById('vidSrc').setAttribute('src', response.data.video)
                });
        },
        playVid() {
            document.getElementById('vidSrc').setAttribute('src', this.vidSrc)
            document.getElementById('playBtn').style.display = 'none';
        }
    }
};
</script>

<style scoped>
    .div {
        margin-top: 5rem;
        border: 0;
        border-top: 2px solid rgba(0, 0, 0, 0.1);
        margin-bottom: 5rem;
    }
    .hdr {
        margin-top: 2rem;
    }
</style>
