<template>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data table</h4>
            <div class="row">
                <div class="col-md-12">
                    <form @submit.prevent="addUser">
                        <div class="form-group">
                            <label>Name</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="user.name"
                            />
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="user.author"
                            />
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Add User
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
            user: {}
        };
    },
    methods: {
        addUser() {
            this.axios
                .post("/api/users", this.user)
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
