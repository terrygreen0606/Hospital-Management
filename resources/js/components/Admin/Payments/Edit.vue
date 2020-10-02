<template>
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Data table</h4>
    <div class="row">
      <div class="col-md-12">
                <form @submit.prevent="updatePayment">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="payment.name">
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" class="form-control" v-model="payment.author">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Payment</button>
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
                payment: {}
            }
        },
        created() {
            this.axios
                .get(`/api/payments/${this.$route.params.id}`)
                .then((response) => {
                    this.payment = response.data;
                    // console.log(response.data);
                });
        },
        methods: {
            updatePayment() {
                this.axios
                    .put(`/api/payments/${this.$route.params.id}`, this.payment)
                    .then((response) => {
                        this.$router.push({name: 'home'});
                    });
            }
        }
    }
</script>