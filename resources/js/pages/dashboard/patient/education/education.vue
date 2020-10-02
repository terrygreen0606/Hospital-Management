<template>
    <div class="content">
        <div class="content-body">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-12">
                        <!-- <h4 class="font-weight-bold">
                            About my orders
                            <router-link to="/" class="font-weight-bold float-right">
                                <i class="ti-home"></i>
                            </router-link>
                        </h4> -->
                        <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                        <p>{{ $route.meta.subtitle }}</p>
                    </div>
                    <div class="col-md-12">
                       <!--  <div class="row m-0 mb-2">
                            <div class="col-lg-4 px-0">
                                <input type="text" class="form-control" placeholder="Search Here..." v-model="search" name="">
                            </div>
                        </div> -->
                        <div class="table-responsive pmd-table-card">
                            <div class="row m-0 border-bottom" v-for="order in orderList">
                                <div class="col-lg-6 py-1">
                                    <p class="d-block mb-0">{{ order.data.dispensed_item_name }}</p>
                                    <small class="text-primary">RX NUMBER: {{ order.data.rx_number }}</small>
                                </div>
                                <div class="col-lg-6 py-1 text-lg-right">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#VideoModal" @click="loadVideo(order.full_record.video)">
                                        Open Video
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade px-0 shadow-none" id="VideoModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog mx-0 shadow-none" style="margin: 0 auto !important;" role="document">
                            <div class="modal-content p-0 shadow-none" style="background: transparent !important;">
                                <!-- <p data-dismiss="modal" class="closeButton">x</p> -->
                                <div class="modal-body md-body p-0" style="background: transparent !important; margin-top: 40px;">
                                    <p class="alignMe" style="margin-top: 44px !important; width: 100% !important;">
                                        <iframe id="vidSrc" src="" height="80%" width="80%" style="border: 0px !important; width: 100% !important;"></iframe>
                                    </p>
                                
                                    <button type="button" class="btn btn-danger rounded-0 px-1" data-dismiss="modal" style="position: absolute;top: -1px !important;right: 0px !important;">
                                        <i class="bx bx-x-circle" style="font-size: 20px; margin-top: 5px;"></i>
                                    </button>
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
            // orders: {},
            orderList: [],
            search: '',
            searchWait: null,

            currentPage: 0,
            totalPages: 0,

            dataTableHeaders: [
                {
                    label: 'RX Number',
                    index: 'rx_number'
                },
                {
                    label: 'Item Name',
                    index: 'dispensed_item_name'
                }
            ],
        };
    },
    watch: {
        // search (value) {
        //     if (this.searchWait) {
        //         clearTimeout(this.searchWait);
        //     }

        //     this.searchWait = setTimeout(() => {
        //         this.currentPage = 1;
        //         this.getAllOrders(1);
        //     }, 1000);
        // },

        currentPage (value) {
            this.getAllOrders(value);
        }
    },
    mounted() {
        this.getAllOrders();

        $('#VideoModal').on("hidden.bs.modal", () => {
            let addToSource = document.getElementById('vidSrc');
            addToSource.setAttribute('src', "")
        });
    },
    methods: {
        
        getAllOrders(page = 1) {
            
            let queries = {
                page: page,
                type: 'orders',
                user_id: this.$auth.user().id
            };

            if (this.search) {
                queries['searchQuery'] = this.search;
            }

            let stringifiedQuery = QueryString.stringify(queries);

            this.axios
                .get(`/api/patientEducation?` + stringifiedQuery)
                .then(response => {

                    this.totalPages = response.data.last_page;
                    this.orderList = [];

                    for (let counter = 0; counter < response.data.length; counter++) {
                        let objectToInsert = {
                            data: {
                                rx_number: response.data[counter]['rx_number'],
                                // date_filled: response.data[counter]['date_filled'],
                                dispensed_item_name: response.data[counter]['dispensed_item_name']
                            },
                            full_record: response.data[counter]
                        }

                        this.orderList.push(objectToInsert);
                    }

                    // this.orders = response;
                }).catch((error) => {
                    console.log("ERROR: ", error);
                });
        },

        loadVideo(vid) {
            let addToSource = document.getElementById('vidSrc');
            addToSource.setAttribute('src', vid)
        }
    }
};
</script>

<style scoped>
    .modal-md {
        width: 75%
    }
    .alignMe{
        text-align: center;
        height: 650px
    }
    .closeButton {
        text-align: right;
        margin-right: 5px;
        font-size: 21px;
        cursor: pointer;
    }
</style>
