<template>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Export {{ table }} data for {{ date }}</h4>
            <div class="row">
                <div class="col-md-12" v-if="$route.query.success">
                    <div
                        class="alert alert-success alert-dismissible fade show"
                        role="alert"
                    >
                        Successfuly exported {{ $route.query.table }} data
                        <button
                            type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="col-md-12">
                    <form action="/data/export" method="POST" class="row">
                        <div class="form-group col-md-4">
                            <label for="table">Table to Export</label>
                            <select
                                v-model="table"
                                class="form-control"
                                id="table"
                                name="table"
                            >
                                <option
                                    v-for="m in tables"
                                    :value="m.k"
                                    :key="m.k"
                                >
                                    {{ m.v }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="status">Status</label>
                            <select
                                v-model="status"
                                class="form-control"
                                id="status"
                                name="status"
                            >
                                <option>Completed</option>
                                <option>Cancelled</option>
                                <option>Failed</option>
                                <option>Paid-Shipping</option>
                                <option>Shipped</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Date of Reports</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text ti-calendar"
                                    ></span>
                                </div>
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="date"
                                    name="date"
                                />
                            </div>
                        </div>

                        <div
                            class="form-group col-md-4 offset-md-8 justify-content-end"
                        >
                            <button
                                type="submit"
                                class="btn btn-primary btn-block"
                            >
                                Export {{ table }} data now
                            </button>
                        </div>
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
            tables: [
                { k: "orders", v: "Orders" },
                { k: "payments", v: "Payments" },
                { k: "invoices", v: "Invoices" }
            ],

            table: "payments",
            date: "",

            success: false,
            error: false,
            message: ""
        };
    }
};
</script>
