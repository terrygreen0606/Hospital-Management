<template>
	<div class="custom-data-table-parent-wrapper" :key="'data-table-key-' + updateListener">

		<div class="row m-0 border-bottom border" style="height: 40px; overflow: hidden;">
			<div v-for="headerColumn in headers" :class="columnSizeClass" class="text-truncate" style="padding-top: 9px; padding-bottom: 5px;">
				<strong>{{ headerColumn.label }}</strong>
			</div>
			<!-- <div :class="actionColumnSizeClass" class="text-right"></div> -->
		</div>

		<div v-if="records.length > 0" class="position-relative" v-for="(record, recordIndex) in records">
			<div class="row m-0 border-left border-right" style="height: 40px; overflow: hidden; margin-bottom: -1px !important;">
				<div  v-for="(recordColumn, recordColumnIndex) in record.data" v-bind:class="{
					['col-' + (12 - columnDivisible)  + ' ' + columnSizeClass] : firstHeaderValue == recordColumnIndex,
					[columnSizeClass + ' d-none']: firstHeaderValue != recordColumnIndex
				}" class="text-truncate" style="padding-top: 9px; padding-bottom: 5px;">
					{{ recordColumn }}
				</div>
				<!-- <div :class="actionColumnSizeClass" class="text-right" style="padding-top: 10px;">
					<i class="bx bx-dots-vertical"></i>
				</div> -->

				<button class="btn btn-sm btn-primary float-right" style="position: absolute; right: 5px; top: 5px;">
					Details
				</button>

			</div>

			<div class="data-table-accordion" :id="'record-accordion-opener-' + recordIndex" style="position: absolute; top: 0px; right: 0px; height: 40px; left: 0px; z-index: 100;"></div>
			<div class="panel border border-top-0" style="margin-top: -1px; background: #f8f8f8 !important; z-index: 200 !important;">
			  <div class="py-2">
			  	<h4 class="text-info">
			  		<!-- <i class="bx bx-folder-open" style="font-size: 28px;float: left;margin-top: -2px;margin-right: 4px;"></i>  -->
			  		RECORD INFORMATION
			  	</h4>
			  	<hr>
			  	<slot name="information" v-bind:record="record"></slot>
			  </div>
			</div>

			{{ listIsDone(recordIndex) }}
		</div>

		<div v-if="records.length <= 0">
			<div class="row m-0 border-left border-right border-bottom">
				<div class="col-12 text-center my-3">
					<h4>No record to be displayed...</h4>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		props: ['headers', 'records'],
		watch: {
			records (value) {
				console.log("VALUE HEHE: ", value);
				if (value.length > 0) {
					this.updateListener++;
				}
			}
		},
		data () {
			return {
				updateListener: 0,

				columnDivisible: 0,
				// actionColumnSizeClass: '',
				columnSizeClass: '',
				firstHeaderValue: '',
			}
		},

		created () {
			this.columnDivisible = 12 / this.headers.length;

			if (this.columnDivisible % 1 !== 0) {
				this.columnDivisible = Math.floor(this.columnDivisible);

				console.log("COLUMN DIVISIBLE: ", this.columnDivisible);
			}

			this.columnSizeClass = 'col-xl-' + this.columnDivisible + ' col-lg-' + this.columnDivisible + ' d-xl-block d-lg-block';

			// this.actionColumnSizeClass = 'col-' + (String)(12 - (this.columnDivisible * this.headers.length));
			this.firstHeaderValue = this.headers[0]['index'];
			// console.log("COLUMN SIZE CLASS: ", this.columnSizeClass);



			// console.log("HEADERS: ", this.headers);
			// // alert( 12 / this.headers.length);
		},

		mounted () {
			
		},

		methods: {
			listIsDone (index) {
				if (index + 1 == this.records.length) {
					// ===========================================================================
					// ACCORDION JS MECHANISM
					// SOURCE: https://www.w3schools.com/howto/howto_js_accordion.asp
					// ===========================================================================
					setTimeout(() => {
						var acc = document.getElementsByClassName("data-table-accordion");
						var i;

						for (i = 0; i < acc.length; i++) {
							acc[i].addEventListener("click", function() {
								this.classList.toggle("active");
								var panel = this.nextElementSibling;

								let splittedID = this.id.split('-');
								let currentOpenerID = splittedID[splittedID.length - 1];
								for (let counter = 0; counter < acc.length; counter++) {
									if (counter != currentOpenerID) {
										acc[counter].nextElementSibling.style.maxHeight = null;
									}
								}

								if (panel.style.maxHeight) {
									panel.style.maxHeight = null;
								} else {
									panel.style.maxHeight = panel.scrollHeight + "px";
								}
							});
						}
					}, 10);

					console.log("list is done.");

					// ===========================================================================
				}
			}
		}
	}
</script>
<style type="text/css" scoped="">
	/*// ===========================================================================*/
	/*// ACCORDION CSS MECHANISM*/
	/*// SOURCE: https://www.w3schools.com/howto/howto_js_accordion.asp*/
	/*// ===========================================================================*/
	/* Style the buttons that are used to open and close the accordion panel */
	.data-table-accordion {
		/*background-color: #eee;*/
		color: #444;
		cursor: pointer;
		/*padding: 18px;*/
		/*width: 100%;*/
		/*text-align: left;*/
		border: none;
		outline: none;
		transition: 0.3s;
	}

	/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
	.active, .data-table-accordion:hover {
		/*background-color: #ccc;*/
	}

	/* Style the accordion panel. Note: hidden by default */
	.panel {
		padding: 0px 18px;
		background-color: white;
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.3s ease-out;
	}
	/*// ===========================================================================*/
</style>