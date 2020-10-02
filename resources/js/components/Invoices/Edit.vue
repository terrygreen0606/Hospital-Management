<template>
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Data table</h4>
    <div class="row">
      <div class="col-md-12">
                <form @submit.prevent="updateInvoice">
                    <div class="form-group">
                        <label>Number</label>
                        <input type="text" class="form-control" v-model="invoice.number">
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" class="form-control" v-model="invoice.amount">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Invoice</button>
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
            }
        },
        created() {
            this.axios
                .get(`/api/invoices/${this.$route.params.id}`)
                .then((response) => {
                    this.invoice = response.data;
                    // console.log(response.data);
                });
        },
        methods: {
            updateInvoice() {
                this.axios
                    .post(`/api/invoices/${this.$route.params.id}`, this.invoice)
                    .then((response) => {
                        this.$router.push({number: 'home'});
                    });
            }
        }
    }
</script>