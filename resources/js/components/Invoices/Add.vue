<template>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data table</h4>
            <div class="row">
                <div class="col-md-12">
                    <form @submit.prevent="addInvoice">
                        <div class="form-group">
                            <label>Name</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="invoice.name"
                            />
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="invoice.author"
                            />
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Add Invoice
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
            invoice: {}
        };
    },
    methods: {
        addInvoice() {
            this.axios
                .post("/api/invoices", this.invoice)
                .then(response =>
                    this.$router.push({ name: "home" })
                    // console.log(response.data)
                )
                .catch(error => console.log(error))
                .finally(() => (this.loading = false));
        }
    }
};
</script>
