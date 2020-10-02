<template>

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="font-weight-bold">All Orders<br /></h4>
                        <pagination
                            :limit="2"
                            size="small"
                            :data="orders"
                            @pagination-change-page="getOrders"
                        ></pagination>
                    </div>
                    <div class="col-md-4 offset-md-4">

                        <form
                            enctype="multipart/form-data"
                            novalidate
                            action="/data/import"
                            method="POST"
                            >
                            <input
                                type="hidden"
                                name="table"
                                value="order"
                            />
                            <input
                                type="hidden"
                                name="id"
                                :value="this.$auth.user().id"
                            />

                            <fieldset>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-primary" type="submit">Upload</button>
                                    </div>
                                    <div class="custom-file">
                                        <input
                                            type="file" 
                                            lass="custom-file-input"
                                            name="csv"
                                            id="inputGroupFile01"
                                            aria-describedby="inputGroupFileAddon01"
                                            required
                                            >
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="col-md-12" v-if="$route.query.success">
                        <div
                            class="alert alert-success alert-dismissible fade show"
                            role="alert"
                        >
                            All orders have been imported successfully. Corresponding
                            invoices have been generated.
                            <router-link to="/admin/invoice" class="alert-link">
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

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">All</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="NimbleALL-tab" data-toggle="tab" href="#NimbleALL" role="tab" aria-controls="NimbleALL" aria-selected="false">Payment Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="D-Print-tab" data-toggle="tab" href="#D-Print" role="tab" aria-controls="D-Print" aria-selected="false">D-Print</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="E-Auto-Refills-tab" data-toggle="tab" href="#E-Auto-Refills" role="tab" aria-controls="E-Auto-Refills" aria-selected="false">E-Auto Refills</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                                <div class="table-responsive pmd-table-card">
                                    <table id="order-listing" class="table table-hover records">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Rx Number</th>
                                                <th>Patient</th>
                                                <th>Doctor</th>
                                                <th>Priority</th>
                                                <th>Dispensed Item Name</th>
                                                <th>Transaction Status</th>
                                                <th>Date Filled</th>
                                                <th>Date Imported</th>
                                                <th>Rx Status</th>
                                                <th>Allowed Refills</th>
                                                <th>Rx Total Qty Remaining</th>
                                                <th>Refills Remaining</th>
                                                <th>Refill Number</th>
                                                <th>Quantity</th>
                                                <th>Days Supply</th>
                                                <th>Total Price</th>
                                                <th>Paid Amount</th>
                                                <th>Dispensed Item NDC</th>
                                                <th>Pharmacy Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr 
                                                v-for="order in orders.data"
                                                :key="order.id"
                                                @click="orderDetails(order)"
                                                style = "cursor: pointer;"
                                                >
                                                <td data-title="RX #">{{ order.rx_number }}</td>
                                                <td data-title="Patient">{{ order.user.name }}</td>
                                                <td data-title="Prescriber">
                                                    <span v-if="order.prescriber">
                                                        {{ order.prescriber.name }}
                                                    </span>
                                                    <span v-else>N/A</span>
                                                </td>
                                                <td data-title="Priority">{{ order.priority }}</td>
                                                <td data-title="Item">
                                                    {{ order.dispensed_item_name }}
                                                </td>
                                                <td data-title="Trans Status">
                                                    {{ order.current_transaction_status }}
                                                </td>
                                                <td data-title="Date Filled">
                                                    {{ order.date_filled }}
                                                </td>
                                                <td data-title="Date Imported">
                                                    {{ order.created_at }}
                                                </td>
                                                <td data-title="RX Status">
                                                    {{ order.rx_status }}
                                                </td>
                                                <td data-title="Allowed Refills">
                                                    {{ order.number_of_refills_allowed }}
                                                </td>
                                                <td data-title="Quantity Remaining">
                                                    {{ order.rx_total_quantity_remaining }}
                                                </td>
                                                <td data-title="Remaining Refills">
                                                    {{ order.refills_remaining }}
                                                </td>
                                                <td data-title="Refill #">
                                                    {{ order.refill_number }}
                                                </td>
                                                <td data-title="Dispensed Quantity">
                                                    {{ order.dispensed_quantity }}
                                                </td>
                                                <td data-title="Days Supply">
                                                    {{ order.days_supply }}
                                                </td>
                                                <td data-title="Amount Due">
                                                    {{ order.total_price_paid }}
                                                </td>
                                                <td data-title="Paid Amount">
                                                    {{ order.patient_paid_amount }}
                                                </td>
                                                <td data-title="Item NDC">
                                                    {{ order.dispensed_item_ndc }}
                                                </td>
                                                <td data-title="Pharmacy">
                                                    {{ order.pharmacy_name }}
                                                </td>
                                                <td>
                                                    <router-link
                                                        :to="{
                                                            name: 'editorder',
                                                            params: { id: order.id }
                                                        }"
                                                        tag="button"
                                                        class="btn btn-dark btn-rounded btn-icon"
                                                    >
                                                        <i class="bx bx-edit-alt"></i>
                                                    </router-link>
                                                    <button
                                                        @click="deleteOrder(order.id)"
                                                        class="btn btn-danger btn-rounded btn-icon"
                                                    >
                                                        
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <td colspan="6" class="text-left pl-2">
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

                            <div class="tab-pane fade show" id="NimbleALL" role="tabpanel" aria-labelledby="NimbleALL-tab">
                                <div class="table-responsive pmd-table-card">
                                    <table id="order-listing" class="table table-hover records">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Rx Number</th>
                                                <th>Patient</th>
                                                <th>Doctor</th>
                                                <!-- <th>Transaction Status Date</th> -->
                                                <th>Priority</th>
                                                <th>Dispensed Item Name</th>
                                                <th>Transaction Status</th>
                                                <th>Date Filled</th>
                                                <th>Date Imported</th>
                                                <!--    <th>Date Written</th> -->
                                                <th>Rx Status</th>
                                                <!-- <th>Status Changed On</th> -->
                                                <th>Allowed Refills</th>
                                                <!-- <th>Directions Translated</th> -->
                                                <th>Rx Total Qty Remaining</th>
                                                <th>Refills Remaining</th>
                                                <th>Refill Number</th>
                                                <th>Quantity</th>
                                                <th>Days Supply</th>
                                                <th>Total Price</th>
                                                <th>Paid Amount</th>
                                                <th>Dispensed Item NDC</th>
                                                <th>Pharmacy Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr 
                                                v-for="order in orders.data"
                                                :key="order.id"
                                                @click="orderDetails(order)"
                                                style = "cursor: pointer;"
                                                >
                                                <template v-if="order.priority  === 'NimbleALL'">
                                                    <td data-title="RX #">{{ order.rx_number }}</td>
                                                    <td data-title="Patient">{{ order.user.name }}</td>
                                                    <td data-title="Prescriber">
                                                        <span v-if="order.prescriber">
                                                            {{ order.prescriber.name }}
                                                        </span>
                                                        <span v-else>N/A</span>
                                                    </td>
                                                    <!-- <td>{{ order.current_transaction_status_date }}</td> -->
                                                    <td data-title="Priority">{{ order.priority }}</td>
                                                    <td data-title="Item">
                                                        {{ order.dispensed_item_name }}
                                                    </td>
                                                    <td data-title="Trans Status">
                                                        {{ order.current_transaction_status }}
                                                    </td>
                                                    <td data-title="Date Filled">
                                                        {{ order.date_filled }}
                                                    </td>
                                                    <td data-title="Date Imported">
                                                        {{ order.created_at }}
                                                    </td>
                                                    <!-- <td>{{ order.date_written }}</td> -->
                                                    <td data-title="RX Status">
                                                        {{ order.rx_status }}
                                                    </td>
                                                    <!-- <td>{{ order.rx_status_changed_on }}</td> -->
                                                    <td data-title="Allowed Refills">
                                                        {{ order.number_of_refills_allowed }}
                                                    </td>
                                                    <!-- <td data-title="">{{ order.directions_translated }}</td> -->
                                                    <td data-title="Quantity Remaining">
                                                        {{ order.rx_total_quantity_remaining }}
                                                    </td>
                                                    <td data-title="Remaining Refills">
                                                        {{ order.refills_remaining }}
                                                    </td>
                                                    <td data-title="Refill #">
                                                        {{ order.refill_number }}
                                                    </td>
                                                    <td data-title="Dispensed Quantity">
                                                        {{ order.dispensed_quantity }}
                                                    </td>
                                                    <td data-title="Days Supply">
                                                        {{ order.days_supply }}
                                                    </td>
                                                    <td data-title="Amount Due">
                                                        {{ order.total_price_paid }}
                                                    </td>
                                                    <td data-title="Paid Amount">
                                                        {{ order.patient_paid_amount }}
                                                    </td>
                                                    <td data-title="Item NDC">
                                                        {{ order.dispensed_item_ndc }}
                                                    </td>
                                                    <td data-title="Pharmacy">
                                                        {{ order.pharmacy_name }}
                                                    </td>
                                                    <td>
                                                        <router-link
                                                            :to="{
                                                                name: 'editorder',
                                                                params: { id: order.id }
                                                            }"
                                                            tag="button"
                                                            class="btn btn-dark btn-rounded btn-icon"
                                                        >
                                                            <i class="bx bx-edit-alt"></i>
                                                        </router-link>
                                                        <button
                                                            @click="deleteOrder(order.id)"
                                                            class="btn btn-danger btn-rounded btn-icon"
                                                        >
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </template>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <td colspan="6" class="text-left pl-2">
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

                            <div class="tab-pane fade show" id="D-Print" role="tabpanel" aria-labelledby="D-Print-tab">
                                <div class="table-responsive pmd-table-card">
                                    <table id="order-listing" class="table table-hover records">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Rx Number</th>
                                                <th>Patient</th>
                                                <th>Doctor</th>
                                                <!-- <th>Transaction Status Date</th> -->
                                                <th>Priority</th>
                                                <th>Dispensed Item Name</th>
                                                <th>Transaction Status</th>
                                                <th>Date Filled</th>
                                                <th>Date Imported</th>
                                                <!--    <th>Date Written</th> -->
                                                <th>Rx Status</th>
                                                <!-- <th>Status Changed On</th> -->
                                                <th>Allowed Refills</th>
                                                <!-- <th>Directions Translated</th> -->
                                                <th>Rx Total Qty Remaining</th>
                                                <th>Refills Remaining</th>
                                                <th>Refill Number</th>
                                                <th>Quantity</th>
                                                <th>Days Supply</th>
                                                <th>Total Price</th>
                                                <th>Paid Amount</th>
                                                <th>Dispensed Item NDC</th>
                                                <th>Pharmacy Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr 
                                                v-for="order in orders.data"
                                                :key="order.id"
                                                @click="orderDetails(order)"
                                                style = "cursor: pointer;"
                                                >
                                                <template v-if="order.priority  === 'D-Print'">
                                                    <td data-title="RX #">{{ order.rx_number }}</td>
                                                    <td data-title="Patient">{{ order.user.name }}</td>
                                                    <td data-title="Prescriber">
                                                        <span v-if="order.prescriber">
                                                            {{ order.prescriber.name }}
                                                        </span>
                                                        <span v-else>N/A</span>
                                                    </td>
                                                    <!-- <td>{{ order.current_transaction_status_date }}</td> -->
                                                    <td data-title="Priority">{{ order.priority }}</td>
                                                    <td data-title="Item">
                                                        {{ order.dispensed_item_name }}
                                                    </td>
                                                    <td data-title="Trans Status">
                                                        {{ order.current_transaction_status }}
                                                    </td>
                                                    <td data-title="Date Filled">
                                                        {{ order.date_filled }}
                                                    </td>
                                                    <td data-title="Date Imported">
                                                        {{ order.created_at }}
                                                    </td>
                                                    <!-- <td>{{ order.date_written }}</td> -->
                                                    <td data-title="RX Status">
                                                        {{ order.rx_status }}
                                                    </td>
                                                    <!-- <td>{{ order.rx_status_changed_on }}</td> -->
                                                    <td data-title="Allowed Refills">
                                                        {{ order.number_of_refills_allowed }}
                                                    </td>
                                                    <!-- <td data-title="">{{ order.directions_translated }}</td> -->
                                                    <td data-title="Quantity Remaining">
                                                        {{ order.rx_total_quantity_remaining }}
                                                    </td>
                                                    <td data-title="Remaining Refills">
                                                        {{ order.refills_remaining }}
                                                    </td>
                                                    <td data-title="Refill #">
                                                        {{ order.refill_number }}
                                                    </td>
                                                    <td data-title="Dispensed Quantity">
                                                        {{ order.dispensed_quantity }}
                                                    </td>
                                                    <td data-title="Days Supply">
                                                        {{ order.days_supply }}
                                                    </td>
                                                    <td data-title="Amount Due">
                                                        {{ order.total_price_paid }}
                                                    </td>
                                                    <td data-title="Paid Amount">
                                                        {{ order.patient_paid_amount }}
                                                    </td>
                                                    <td data-title="Item NDC">
                                                        {{ order.dispensed_item_ndc }}
                                                    </td>
                                                    <td data-title="Pharmacy">
                                                        {{ order.pharmacy_name }}
                                                    </td>
                                                    <td>
                                                        <router-link
                                                            :to="{
                                                                name: 'editorder',
                                                                params: { id: order.id }
                                                            }"
                                                            tag="button"
                                                            class="btn btn-dark btn-rounded btn-icon"
                                                        >
                                                            <i class="bx bx-edit-alt"></i>
                                                        </router-link>
                                                        <button
                                                            @click="deleteOrder(order.id)"
                                                            class="btn btn-danger btn-rounded btn-icon"
                                                        >
                                                            
                                                        <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </template>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <td colspan="6" class="text-left pl-2">
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

                            <div class="tab-pane fade show" id="E-Auto-Refills" role="tabpanel" aria-labelledby="E-Auto-Refills-tab">
                                <div class="table-responsive pmd-table-card">
                                    <table id="order-listing" class="table table-hover records">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Rx Number</th>
                                                <th>Patient</th>
                                                <th>Doctor</th>
                                                <!-- <th>Transaction Status Date</th> -->
                                                <th>Priority</th>
                                                <th>Dispensed Item Name</th>
                                                <th>Transaction Status</th>
                                                <th>Date Filled</th>
                                                <th>Date Imported</th>
                                                <!--    <th>Date Written</th> -->
                                                <th>Rx Status</th>
                                                <!-- <th>Status Changed On</th> -->
                                                <th>Allowed Refills</th>
                                                <!-- <th>Directions Translated</th> -->
                                                <th>Rx Total Qty Remaining</th>
                                                <th>Refills Remaining</th>
                                                <th>Refill Number</th>
                                                <th>Quantity</th>
                                                <th>Days Supply</th>
                                                <th>Total Price</th>
                                                <th>Paid Amount</th>
                                                <th>Dispensed Item NDC</th>
                                                <th>Pharmacy Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr 
                                                v-for="order in orders.data"
                                                :key="order.id"
                                                @click="orderDetails(order)"
                                                style = "cursor: pointer;"
                                                >
                                                <template v-if="order.priority  === 'E-Auto Refills'">
                                                    <td data-title="RX #">{{ order.rx_number }}</td>
                                                    <td data-title="Patient">{{ order.user.name }}</td>
                                                    <td data-title="Prescriber">
                                                        <span v-if="order.prescriber">
                                                            {{ order.prescriber.name }}
                                                        </span>
                                                        <span v-else>N/A</span>
                                                    </td>
                                                    <!-- <td>{{ order.current_transaction_status_date }}</td> -->
                                                    <td data-title="Priority">{{ order.priority }}</td>
                                                    <td data-title="Item">
                                                        {{ order.dispensed_item_name }}
                                                    </td>
                                                    <td data-title="Trans Status">
                                                        {{ order.current_transaction_status }}
                                                    </td>
                                                    <td data-title="Date Filled">
                                                        {{ order.date_filled }}
                                                    </td>
                                                    <td data-title="Date Imported">
                                                        {{ order.created_at }}
                                                    </td>
                                                    <!-- <td>{{ order.date_written }}</td> -->
                                                    <td data-title="RX Status">
                                                        {{ order.rx_status }}
                                                    </td>
                                                    <!-- <td>{{ order.rx_status_changed_on }}</td> -->
                                                    <td data-title="Allowed Refills">
                                                        {{ order.number_of_refills_allowed }}
                                                    </td>
                                                    <!-- <td data-title="">{{ order.directions_translated }}</td> -->
                                                    <td data-title="Quantity Remaining">
                                                        {{ order.rx_total_quantity_remaining }}
                                                    </td>
                                                    <td data-title="Remaining Refills">
                                                        {{ order.refills_remaining }}
                                                    </td>
                                                    <td data-title="Refill #">
                                                        {{ order.refill_number }}
                                                    </td>
                                                    <td data-title="Dispensed Quantity">
                                                        {{ order.dispensed_quantity }}
                                                    </td>
                                                    <td data-title="Days Supply">
                                                        {{ order.days_supply }}
                                                    </td>
                                                    <td data-title="Amount Due">
                                                        {{ order.total_price_paid }}
                                                    </td>
                                                    <td data-title="Paid Amount">
                                                        {{ order.patient_paid_amount }}
                                                    </td>
                                                    <td data-title="Item NDC">
                                                        {{ order.dispensed_item_ndc }}
                                                    </td>
                                                    <td data-title="Pharmacy">
                                                        {{ order.pharmacy_name }}
                                                    </td>
                                                    <td>
                                                        <router-link
                                                            :to="{
                                                                name: 'editorder',
                                                                params: { id: order.id }
                                                            }"
                                                            tag="button"
                                                            class="btn btn-dark btn-rounded btn-icon"
                                                        >
                                                            <i class="bx bx-edit-alt"></i>
                                                        </router-link>
                                                        <button
                                                            @click="deleteOrder(order.id)"
                                                            class="btn btn-danger btn-rounded btn-icon"
                                                        >
                                                            
                                                        <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </template>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <td colspan="6" class="text-left pl-2">
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
            </div>
        </div>
    </div>

</template>

<script>
import swal from 'sweetalert';
export default {
    data() {
        return {
            orders: {},
            search: ""
        };
    },
    mounted() {
        this.getOrders();
    },
    methods: {
        async deleteOrder(id) {
            const willDelete = await swal({
                title: "Are you sure?",
                text: "Are you sure that you want to delete this user?",
                icon: "warning",
                dangerMode: true,
                buttons: true,
            });
            
            if (willDelete) {
                this.axios.delete(`/api/orders/${id}`).then(response => {
                    let i = this.orders.map(item => item.id).indexOf(id); // find index of your object
                    this.orders.splice(i, 1);
                    swal("Deleted!", "User has been deleted has been deleted!", "success");
                });
            }
        },

        getOrders(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            this.axios.get("/api/getPharmacyData/"+this.$auth.user().id).then(res => {
                if(res.data.length > 0){
                    this.axios.get("/api/orders?ids=" + JSON.stringify(res.data) + p).then(response => {
                        this.orders = response.data;
                    });
                }

            });
        },

        searchQuery() {
            this.axios.get("/api/orders?s=" + this.search).then(response => {
                this.orders = response.data;
            });
        },

        orderDetails(data) {
            // this.$router.push({ name: "orderDetail", params:{order_id:data.id, user_id:data.user_id} })
        }
    }
};
</script>
