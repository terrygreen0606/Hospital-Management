<template>
    <div class="content">
        <div class="content-body">
            <div class="row m-0">
                <div class="col-12">
                    <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                    <p>{{ $route.meta.subtitle }}</p>
                    
                    <div class="table-responsive">

                        <div class="row m-0 mb-2">
                            <div class="col-lg-4 px-0">
                                <input type="text" class="form-control" placeholder="Search Item Name Here..." v-model="search" name="">
                            </div>
                        </div>

                        <custom-data-table 
                            :headers="dataTableHeaders"
                            :records="orders"
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
                                        <p class="text-primary mb-0">{{ scope.record.data.pharmacy_name }}</p>
                                        <small>PHARMACY NAME</small>
                                    </div>
                                </div>
                            </template>
                        </custom-data-table>

                        <div class="row m-0">
                            <div class="col-md-4 col-lg-2 px-0 mt-3">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            Page: 
                                        </span>
                                    </div>
                                    
                                    <select class="form-control text-right" v-model="currentPage">
                                        <option v-for="counter in totalPages" :value="counter">{{ counter }}</option>
                                    </select>
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
import QueryString from 'query-string';

export default {
    data() {
        return {
            orders: [],
            // response: null,
            search: '',
            searchWait: null,

            currentPage: 1,
            totalPages: 1,

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
                    label: 'RX Status',
                    index: 'rx_status'
                },
                {
                    label: 'Total Price',
                    index: 'total_price'
                },
                {
                    label: 'Pharmacy Name',
                    index: 'pharmacy_name'
                }
            ],

        };
    },

    watch : {
        search (value) {
            if (this.searchWait) {
                clearTimeout(this.searchWait);
            }

            this.searchWait = setTimeout(() => {
                this.currentPage = 1;
                this.getOrders(1);
            }, 1000);
        },

        currentPage (value) {
            this.getOrders(value);
        }
    },

    mounted() {
        this.getOrders()
    },

    methods: {
        getOrders(page = 1) {
            let p = page == 1 ? "" : "&page=" + page;

            let queries = {
                page: page,
                user_id: this.$auth.user().id
            };

            if (this.search) {
                queries['searchQuery'] = this.search;
            }

            let stringifiedQuery = QueryString.stringify(queries);

            // .get(`/api/orders?user_id=${this.$auth.user().id}` + p)
            this.axios.get(`/api/orders?` + stringifiedQuery).then(response => {
                this.totalPages = response.data.last_page;
                this.orders = [];
                for (let counter = 0; counter < response.data.data.length; counter++) {
                    let currentData = response.data.data[counter];
                    this.orders.push({
                        data: {
                            rx_number: currentData.rx_number,
                            dispensed_name: currentData.dispensed_item_name,
                            rx_status: currentData.rx_status,
                            total_price: currentData.total_price_paid,
                            pharmacy_name: currentData.patient_data.pharmacy.name
                        },
                        full_record: currentData,
                    });
                }
            });
        }
    }
};
</script>
