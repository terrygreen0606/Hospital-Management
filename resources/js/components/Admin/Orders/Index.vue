<template>
    <div class="row">
        <div class="col-md-12">
            <div class="font-weight-bold">
                All Orders
            </div>
        </div>
        <div class="col-md-12" v-if="$route.query.suceess">
            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
                All orders have been imported successfully. Corresponding
                invoices have been generated.
                <router-link to="/admin/invoices" class="alert-link">
                    View Invoices
                </router-link>
                <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive pmd-table-card">
                <datatable id="order-listing" class="table pmd-table records" :columns="columns" :data="rows" filterable paginate></datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div>

</template>

<script>
    import { VuejsDatatableFactory } from 'vuejs-datatable';
    export default {
        components: { VuejsDatatableFactory },
        mounted() {
            console.log('Component mounted')
        },
        data () {
            return {
                columns: [
                    { label: 'Id', field: 'id'},
                    { label: 'Rx Number', field: 'rx_number'},
                    { label: 'Transaction Status', field: 'current_transaction_status_date'},
                    { label: 'Priority', field: 'priority'},
                    { label: 'Dispensed Item Name', field: 'dispensed_item_name'},
                    { label: 'Date Filled', field: 'date_filled'},
                    { label: 'Date Written', field: 'date_written'},
                    { label: 'RX Status', field: 'rx_status'},
                    { label: 'RX Status Change Date', field: 'rx_status_changed_on'},
                    { label: 'Refils Allowed', field: 'number_of_refills_allowed'},
                    { label: 'Directions Translated', field: 'directions_translated'},
                    { label: 'Total Quantity Remaining', field: 'rx_total_quantity_remaining'},
                    { label: 'Refills Remaining', field: 'refills_remaining'},
                    { label: 'Refill Number', field: 'refill_number'},
                ],
                rows: [],
                page: 1,
                per_page: 10,
                orders: []
            };
        },
        created() {
           this.getOrders();
        },
        methods: {
            deleteOrders(id) {
                this.axios.delete(`/api/orders/${id}`).then(response => {
                    let i = this.orders.map(item => item.id).indexOf(id); // find index of your object
                    this.orders.splice(i, 1);
                });
            },

            getOrders: function () {
                this.axios.get("/api/orders").then(response => {
                    this.rows = response.data;
                    this.orders = response.data;
                });
            }
        }

    }
</script>

<style scoped>

</style>
