<template>
    <!-- BEGIN: Content-->
    <div class="content">
        <div class="content-body">
            <div class="row m-0">
                <div class="col-md-12 px-2">
                    <div class="mb-3" style="margin-left: 5px; margin-right: 5px;">
                        <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                        <p>{{ $route.meta.subtitle }}</p>
                    </div>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a 
                                class="nav-link active"
                                href="#bills" 
                                data-toggle="tab"
                                role="tab" 
                                aria-controls="bills" 

                                aria-selected="true"
                                id="all-tab" 
                                @click="currentTab = 'bills'"
                            >Pay Your Bills</a>
                        </li>
                        <li class="nav-item">
                            <a 
                                class="nav-link"
                                href="#orders" 
                                data-toggle="tab"
                                role="tab" 
                                aria-controls="orders" 

                                aria-selected="true"
                                id="pending-tab"
                                @click="currentTab = 'orderHistory'"
                            >Order History</a>
                        </li>
                        <li class="nav-item">
                            <a 
                                class="nav-link"
                                href="#education" 
                                data-toggle="tab"
                                role="tab" 
                                aria-controls="education" 

                                aria-selected="true"
                                id="pending-tab"
                                @click="currentTab = 'patientEducation'"
                            >Patient Education</a>
                        </li>
                        <li class="nav-item">
                            <a 
                                class="nav-link"
                                href="#shipments" 
                                data-toggle="tab"
                                role="tab" 
                                aria-controls="shipments" 

                                aria-selected="true"
                                id="pending-tab"
                                @click="currentTab = 'shipment'"
                            >Shipments</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="bills" role="tabpanel" aria-labelledby="bills-tab">
                            <!-- <h1>BILLS</h1> -->
                            <bills-component v-if="currentTab == 'bills'" />
                        </div>
                        <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                            <!-- <h1>ORDER HISTORY</h1> -->
                            <orders-component v-if="currentTab == 'orderHistory'" />
                        </div>
                        <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
                            <!-- <h1>PATIENT EDUCATION</h1> -->
                            <education-component v-if="currentTab == 'patientEducation'" />
                        </div>
                        <div class="tab-pane fade" id="shipments" role="tabpanel" aria-labelledby="shipments-tab">
                            <!-- <h1>PATIENT EDUCATION</h1> -->
                            <shipments-component v-if="currentTab == 'shipment'" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
</template>
<script>
import Bills from './_bills.vue';
import Orders from './_orders.vue';
import Education from './_education.vue';
import Shipments from './_shipments.vue';

export default {
    components: {
        'bills-component': Bills,
        'orders-component': Orders,
        'education-component': Education,
        'shipments-component': Shipments
    },
    data() {
        return {
            currentTab: 'bills',
            phone: null
        };
    },

    mounted() {
        
    },

    methods: {
        
        refreshReports() {
            this.axios.post(`/api/reports`).then(response => {
                this.$router.go(0);
            });
        },

        getOrders(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            this.axios
                .get(`/api/orders?user_id=${this.$auth.user().id}` + p)
                .then(response => {
                    this.orders = response.data;
                });
        },

        getInvoices(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;
            this.axios
                .get(`/api/invoices?user_id=${this.$auth.user().id}` + p)
                .then(response => {
                    this.invoices = response.data;
                });
        }
    }
};
</script>
