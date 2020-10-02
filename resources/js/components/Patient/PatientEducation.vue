<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="font-weight-bold">
                                About my orders
                                <router-link to="/" class="font-weight-bold float-right">
                                    <i class="ti-home"></i>
                                </router-link>
                            </h4>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive pmd-table-card">
                                <table id="payment-listing" class="table pmd-table">
                                    <thead>
                                        <tr>
                                            <th>RX Number</th>
                                            <th>Date Filled</th>
                                            <th>Name</th>
                                            <th>Play Video</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="o in orders.data" :key="o.id">
                                            <td> {{ o.rx_number }} </td>
                                            <td> {{ o.date_filled }} </td>
                                            <td> {{ o.dispensed_item_name }} </td>
                                            <td data-toggle="modal" data-target="#VideoModal">
                                                <a href="#" @click="loadVideo(o.video)"><i class="ti-control-play menu-icon"></i> Play Video</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="6" class="text-left pl-2">
                                            <pagination
                                                :limit="1"
                                                :data="orders"
                                                @pagination-change-page="getAllOrders"
                                            ></pagination>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="modal fade" id="VideoModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-md" role="document">
                                <div class="modal-content">
                                    <p data-dismiss="modal" class="closeButton">x</p>
                                    <div class="modal-body md-body">
                                        <p class="alignMe"><iframe id="vidSrc" src="" height="80%" width="80%"></iframe></p>
                                    </div>
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
export default {
    data() {
        return {
            orders: {}
        };
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
            let p = page == 1 ? "" : "&page=" + page;
            this.axios
                .get(`/api/patientEducation?type=orders&user_id=${this.$auth.user().id}` + p)
                .then(response => {
                    this.orders = response;
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
