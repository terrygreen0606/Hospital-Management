<template>
    <div class="content">
        <div class="content-body">
            <div class="row">
                <div class="col-md-12 px-2">
                    <div class="mb-3" style="margin-left: 5px; margin-right: 5px;">
                        <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                        <p>{{ $route.meta.subtitle }}</p>
                    </div>

                    <div
                        style="margin-left: 5px; margin-right: 5px;"
                        class="alert alert-success alert-dismissible fade show"
                        role="alert"
                        v-if="$route.query.success"
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
                    <ul class="nav nav-tabs border-0 px-1" id="myTab" role="tablist">
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

                    <div class="d-block row m-0">
                        <div class="col-lg-5">
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

                                <fieldset>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-secondary" type="submit">Upload</button>
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
                    </div>



                    <div class="tab-content px-1 mt-1" id="myTabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                            <all-orders 
                                :order-records="orders" 
                                v-on:neworderlist="orders = $event" 
                                v-on:deleteorder="deleteOrder($event)"
                                v-on:viewdetails="orderDetails($event)"
                            />
                        </div>

                        <div class="tab-pane fade show" id="NimbleALL" role="tabpanel" aria-labelledby="NimbleALL-tab">
                            <nimble-all 
                                :order-records="orders" 
                                v-on:neworderlist="orders = $event" 
                                v-on:deleteorder="deleteOrder($event)"
                                v-on:viewdetails="orderDetails($event)"
                            />
                        </div>

                        <div class="tab-pane fade show" id="D-Print" role="tabpanel" aria-labelledby="D-Print-tab">
                            <d-print 
                                :order-records="orders" 
                                v-on:neworderlist="orders = $event" 
                                v-on:deleteorder="deleteOrder($event)"
                                v-on:viewdetails="orderDetails($event)"
                            />
                        </div>

                        <div class="tab-pane fade show" id="E-Auto-Refills" role="tabpanel" aria-labelledby="E-Auto-Refills-tab">
                            <e-auto-refills 
                                :order-records="orders" 
                                v-on:neworderlist="orders = $event" 
                                v-on:deleteorder="deleteOrder($event)"
                                v-on:viewdetails="orderDetails($event)"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import swal from 'sweetalert';

import AllOrders from './tabs/all.vue';
import NimbleAllOrders from './tabs/nimble-all.vue';
import DPrintOrders from './tabs/d-print.vue';
import EAutoRefills from './tabs/e-auto-refills.vue';

export default {
    components: {
        'all-orders': AllOrders,
        'nimble-all': NimbleAllOrders,
        'd-print': DPrintOrders,
        'e-auto-refills': EAutoRefills
    },
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
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get("/api/orders" + p).then(response => {
                this.orders = response.data;
            });
        },

        searchQuery() {
            this.axios.get("/api/orders?s=" + this.search).then(response => {
                this.orders = response.data;
            });
        },

        orderDetails(data) {
            this.$router.push({ name: "order_information", params:{order_id:data.id, user_id:data.user_id} })
        }
    }
};
</script>
