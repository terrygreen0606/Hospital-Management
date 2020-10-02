<template>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data table</h4>
            <div class="row">
                <div class="col-md-12">
                    <form @submit.prevent="updateOrder">
                        <div class="form-group">
                            <label>Name</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="order.name"
                            />
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="order.author"
                            />
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Update Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            order: {}
        };
    },
    created() {
        this.axios
            .get(`/api/orders/${this.$route.params.id}`)
            .then(response => {
                this.order = response.data;
                // console.log(response.data);
            });
    },
    methods: {
        updateOrder() {
            this.axios
                .post(`/api/orders/${this.$route.params.id}`, this.order)
                .then(response => {
                    this.$router.push({ name: "home" });
                });
        }
    }
};
</script>
