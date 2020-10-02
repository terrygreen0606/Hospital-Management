<template>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new item</h4>
            <div class="">
                <form class="pt-3 row">
                    <div class="form-group col-md-6">
                        <label>Item Name</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="product.name"
                        />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Item NDC</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="product.ndc"
                        />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Price</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="product.price"
                        />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Size</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="product.size"
                        />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Vendor</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="product.vendor"
                        />
                    </div>
                    <div class="form-group col-md-6 pt-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            Update Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            product: {},
            success: false
        };
    },
    methods: {
        addItem() {
            this.axios.put(`/api/products`, this.product).then(response => {
                this.$router.push({ name: "allitems" });
            });
        }
    }
};
</script>
