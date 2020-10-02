<template>
    <div class="row">
        <div class="col-md-4">
            <h4 class="font-weight-bold">
                All Line Items
                <br />
            </h4>
            <pagination
                :limit="2"
                size="small"
                :data="items"
                @pagination-change-page="getItems"
            ></pagination>
        </div>

        <div class="col-md-4 offset-md-4">
            <div class="justify-content-lg-end">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <div class="input-group-text ti-search"></div>
                    </div>
                    <input
                        class="form-control form-control-sm"
                        placeholder="Type query and hit enter"
                        v-model="search"
                        v-on:keyup="searchQuery"
                    />
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="table-responsive pmd-table-card">
                <table id="item-listing" class="table pmd-table">
                    <thead>
                        <tr>
                            <th>NDC</th>
                            <th>Name</th>
                            <!-- <th>Price</th>
                            <th>Vendor</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items.data" :key="item.id">
                            <td data-title="NDC">
                                {{ item.ndc }}
                            </td>
                            <td data-title="Name">
                                {{ item.name }}
                            </td>
                            <!-- <td

                                data-title="Price"
                            >
                                ${{ item.price }}
                            </td>
                            <td

                                data-title="Vendor"
                            >
                                {{ item.vendor }}
                            </td> -->
                            <td>
                                <router-link
                                    :to="{
                                        name: 'edititem',
                                        params: { id: item.id }
                                    }"
                                    tag="button"
                                    class="btn btn-dark btn-rounded btn-icon"
                                >
                                    <i class="ti-pencil"></i>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <td colspan="6" class="text-left pl-2">
                            <pagination
                                :limit="1"
                                :data="items"
                                @pagination-change-page="getItems"
                            ></pagination>
                        </td>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            items: {},
            search: ""
        };
    },
    mounted() {
        this.getItems();
    },
    methods: {
        getItems(page = 1) {
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get("/api/products" + p).then(response => {
                this.items = response.data;
            });
        },

        searchQuery() {
            this.axios.get("/api/products?s=" + this.search).then(response => {
                this.items = response.data;
            });
        }
    }
};
</script>
