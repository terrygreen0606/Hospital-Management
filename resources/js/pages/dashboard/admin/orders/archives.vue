<template>
	<div class="content">
		<div class="content-body">
			<div class="row">
				<div class="col-md-12 px-2">
                    <div class="mb-3" style="margin-left: 5px; margin-right: 5px;">
                        <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                        <p>{{ $route.meta.subtitle }}</p>
                    </div>

                    <!-- <div
                        style="margin-left: 5px; margin-right: 5px;"
                        class="alert alert-success alert-dismissible fade show"
                        role="alert"
                        v-if="$route.query.success"
                    >
                        All orders have been imported successfully. Corresponding
                        invoices have been generated.
                        <router-link to="/admin/invoice" class="alert-link">
                            View Invoices
                        </router-link>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> -->
                </div>
                <div class="col-md-12">
                	<div class="d-block row m-0">
                        <div class="col-lg-5">
                            <form
                                enctype="multipart/form-data"
                                novalidate
                                action="/data/import"
                                method="POST"
                                >
                                <input
                                    type="hidden"
                                    name="table"
                                    value="order_archive"
                                />

                                <fieldset>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-secondary" type="submit">Upload</button>
                                        </div>
                                        <div class="custom-file">
                                            <input
                                                type="file" 
                                                lass="custom-file-input"
                                                name="csv"
                                                id="inputGroupFile01"
                                                aria-describedby="inputGroupFileAddon01"
                                                required
                                                >
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="px-1 mt-1">
                    	<div class="table-responsive pmd-table-card">
	                		<table id="order-listing" class="table shadow border table-hover records" style="margin-bottom: 9.1vh;">
	                			<thead>
	                				<tr class="modified-headers">
	                					<th>RX #</th>
										<th>Prescriber</th>
										<th>Prescriber NPI</th>
										<th>Primary City</th>
										<th>Primary State</th>
										<th>Date Filled</th>
										<th>Refilled or New</th>
										<th>Item Name</th>
										<th>Item NDC</th>
										<th>Item Dosage Form</th>
										<th>Item Stock Size</th>
										<th>Quantity</th>
										<th>Pay Method</th>
										<th>Primary</th>
										<th>Pharmacy</th>
	                				</tr>
	                			</thead>
	                			<tbody>
	                				<tr v-if="archived_orders.data.length == 0">
	                					<td colspan="15" class="text-center small">Nothing to Show</td>
	                				</tr>
	                				<tr v-else v-for="order in archived_orders.data">
	                					<td>{{ order.rx_number }}</td>
										<td>{{ order.prescriber_full_name }}</td>
										<td>{{ order.prescriber_npi }}</td>
										<td>{{ order.prescriber_primary_city }}</td>
										<td>{{ order.prescriber_primary_state }}</td>
										<td>{{ order.date_filled }}</td>
										<td>{{ order.refill_or_new }}</td>
										<td>{{ order.dispensed_item_name }}</td>
										<td>{{ order.dispensed_item_ndc }}</td>
										<td>{{ order.dispensed_item_dosage_form }}</td>
										<td>{{ order.dispensed_item_stock_size }}</td>
										<td>{{ order.dispensed_quantity }}</td>
										<td>{{ order.pay_method }}</td>
										<td>{{ order.primary }}</td>
										<td>{{ order.pharmacy }}</td>
	                				</tr>
	                			</tbody>
	                			<tfoot>
					                <td colspan="15" class="text-left pl-2">
					                    <pagination
					                        :limit="1"
					                        :data="archived_orders"
					                        @pagination-change-page="getOrderArchives"
					                    ></pagination>
					                </td>
					            </tfoot>
	                		</table>
	                	</div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		data() {
			return {
				archived_orders: {},	
			};
		},
		mounted() {
			this.getOrderArchives(1);
		},
		methods: {
			getOrderArchives(page = 1) {
				let p = page == 1 ? "" : "?page=" + page;
				this.axios.get("/api/archived_orders"+p).then(response => {
					this.archived_orders = response.data.orders;
				});
			}
		},
	}
</script>