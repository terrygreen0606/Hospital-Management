<template>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Orders</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>RX NUMBER</th>
                                            <th>DISPENSED NAME</th>
                                            <th>RX STATUS</th>
                                            <th>TRACKING NUMBER</th>
                                            <th>TOTAL PRICE</th>
                                            <th>DISPENSED ITEM NDC</th>
                                            <th>PHARMACY NAME</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="order in orders.data"
                                            :key="order.id"
                                            >
                                            <td data-title="RX #">
                                                {{ order.rx_number }}
                                            </td>
                                            <td data-title="Item Name">
                                                {{ order.dispensed_item_name }}
                                            </td>
                                            <td data-title="RX Status">
                                                {{ order.current_transaction_status }}
                                            </td>
                                            <td data-title="Tracking">
                                                {{ order.tracking_number }}
                                            </td>
                                            <td data-title="Amount">
                                                {{ order.total_price_paid }}
                                            </td>
                                            <td data-title="Item NDC">
                                                {{ order.dispensed_item_ndc }}
                                            </td>
                                            <td data-title="Pharmacy">
                                                {{ order.pharmacy_name }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
</template>
<script>
export default {
    data() {
        return {
            orders: []
        };
    },

    mounted() {
        this.getOrders()
    },

    methods: {
        getOrders(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            this.axios
                .get(`/api/orders?user_id=${this.$auth.user().id}` + p)
                .then(response => {
                    this.orders = response.data;
                });
        }
    }
};
</script>
