<template>

    <div class="content">
        <div class="content-body">
            <div class="row">
                <div class="col-md-12 px-2">
                    <div class="mb-3" style="margin-left: 5px; margin-right: 5px;">
                        <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>Duplicate Orders</h2>
                        <p>Review your duplicate orders that you tried to import here</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive pmd-table-card">
                        <table id="order-listing" class="table shadow border table-hover records" style="margin-bottom: 9.1vh;">
                            <thead>
                                <tr class="modified-headers">
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(order, index) in orders.data"
                                    :key="order.id"
                                    style = "cursor: pointer;"
                                    v-bind:class="{
                                        'border-top-0': index == 0
                                    }"
                                    >
                                    <td data-title="RX #">{{ order.rx_number }}</td>
                                    <td data-title="Patient">{{ order.name }}</td>
                                    <td data-title="Prescriber">
                                        <span v-if="order.prescriber">
                                            {{ order.prescriber_name }}
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
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <button class="btn btn-block btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                OPTIONS
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a href="javascript:void(0)" class="dropdown-item" @click="deleteDuplicate(order.id)">
                                                    <i class="bx bx-trash mr-1"></i> Delete Record
                                                </a>
                                                <!-- <a href="javascript:void(0)" class="dropdown-item" @click="$emit('viewdetails', order)">
                                                    <i class="bx bx-file mr-1"></i> View Details
                                                </a>
                                                <router-link :to="{ name: 'editorder', params: { id: order.id } }" class="dropdown-item">
                                                    <i class="bx bx-edit-alt mr-1"></i> Edit Order
                                                </router-link> -->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td colspan="20" class="text-left pl-2">
                                    <pagination
                                        :limit="1"
                                        :data="orders"
                                        @pagination-change-page="getDuplicates"
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
            orders: {}
        };
    },
    mounted() {
        this.getDuplicates();
    },
    methods: { 
        async deleteDuplicate(id) {
            const willDelete = await swal({
                title: "Are you sure?",
                text: "Are you sure that you want to delete this order?",
                icon: "warning",
                dangerMode: true,
                buttons: true,
            });
            
            if (willDelete) {
                this.axios.delete(`/api/duplicates/${id}`).then(response => {
                    
                    let i = this.orders.map(item => item.id).indexOf(id); // find index of your object
                    this.orders.splice(i, 1);
                });
            }
        },
        getDuplicates(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            this.axios.get("/api/duplicates?pharmacy_name="+ this.$auth.user().name + p).then(response => {
                this.orders = response.data;
            });
        }
    }
};
</script>
