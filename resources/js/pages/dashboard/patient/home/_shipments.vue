<template>
    <div class="row m-0">
        <div class="col-12 px-0">
            <div class="table-responsive">
                <!-- <div class="row m-0 mb-2">
                    <div class="col-lg-4 px-0">
                        <input type="text" class="form-control" placeholder="Search Here..." v-model="search" name="">
                    </div>
                </div> -->

                <custom-data-table 
                    :headers="dataTableHeaders"
                    :records="orders.filter(data => !search || 
                        data.data.rx_number.toLowerCase().includes(search.toLowerCase()) || 
                        data.data.dispensed_name.toLowerCase().includes(search.toLowerCase())
                    )"
                >
                    <template v-slot:information="scope">
                        <div class="row m-0">
                            <div class="col-lg-4 mb-2">
                                <p class="text-primary mb-0">{{ scope.record.data.rx_number }}</p>
                                <small>RX NUMBER</small>
                            </div>
                            <div class="col-lg-4 mb-2">
                                <p class="text-primary mb-0">{{ scope.record.data.dispensed_name }}</p>
                                <small>DISPENSED NAME</small>
                            </div>
                            <div class="col-lg-4 mb-2">
                                <p class="text-primary mb-0">{{ scope.record.data.rx_status }}</p>
                                <small>RX STATUS</small>
                            </div>

                            <div class="col-lg-4 mb-2">
                                <p class="text-primary mb-0">{{ scope.record.data.total_price }}</p>
                                <small>TOTAL PRICE</small>
                            </div>
                            <div class="col-lg-4 mb-2">
                                <p class="text-primary mb-0">{{ scope.record.data.tracking_number }}</p>
                                <small>TRACKING NUMBER</small>
                            </div>
                        </div>
                    </template>
                </custom-data-table>
            
                <router-link :to="{ name: 'patient_orders' }" class="btn btn-outline-primary mt-2" v-if="orders.length > 0 && orders.length > 10">
                    View More
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
import QueryString from 'query-string';

export default {
    data() {
        return {
            orders: [],
            response: null,
            search: '',

            dataTableHeaders: [
                {
                    label: 'RX Number',
                    index: 'rx_number'
                },
                {
                    label: 'Dispensed Name',
                    index: 'dispensed_name'
                },
                {
                    label: 'Total Price',
                    index: 'total_price'
                },
                {
                    label: 'Tracking Number',
                    index: 'tracking_number'
                }
            ],

        };
    },

    mounted() {
        this.getOrders()
    },

    methods: {
        getOrders(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            let queries = { page: page, user_id: this.$auth.user().id };
            let stringifiedQuery = QueryString.stringify(queries);
            this.axios
                .get(`/api/orders?` + stringifiedQuery)
                .then(response => {
                    this.response = response.data;
                    for (let counter = 0; counter < response.data.data.length; counter++) {
                        let currentData = response.data.data[counter];
                        let trackingNumber = (response.data.data[counter]['tracking_number'] ? response.data.data[counter]['tracking_number'] : 'N/A');

                        this.orders.push({
                            data: {
                                rx_number: currentData.rx_number,
                                dispensed_name: currentData.dispensed_item_name,
                                total_price: currentData.total_price_paid,
                                tracking_number: trackingNumber,
                            },
                            full_record: currentData,
                        });
                    }
                });
        }
    }
};
</script>
