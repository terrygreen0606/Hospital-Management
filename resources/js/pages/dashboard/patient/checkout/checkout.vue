<template>

    <div class="content">
        <div class="content-body">
            <div class="col-12">
                <form id="payment-form" class="row no-gutters">
                    <div class="col-md-12 px-2 grid-margin">
                        <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                        <p>{{ $route.meta.subtitle }}</p>
                    </div>
                    <div class="w-100">
                        <div class="row m-0">
                            <div class="col-lg-7 px-0 px-md-1 px-lg-1 px-xl-1">
                                <div
                                    v-for="order in invoice.invoice_orders"
                                    :key="order.id">
                                    <div 
                                        class="row m-0 shadow rounded p-lg-1 border mb-2 position-relative"
                                        v-if="order.current_transaction_status != 'Completed'">
                                
                                            <div style="position: absolute; top: 10px; right: -1px; padding: 5px 10px; border-top-left-radius: 5px; border-bottom-left-radius: 5px; z-index: 1;" class="bg-danger text-white">
                                                QTY: {{ order.dispensed_quantity }}
                                            </div>

                                            <div class="col-lg-3 px-0 position-relative">
                                                <div style="position: absolute; top: 10px; left: 0px; background: rgba(0,0,0,0.3); padding: 5px 10px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                                                    <span class="text-success"><strong>${{ order.total_price_paid }}</strong></span>
                                                </div>
                                                <img src="/images/item-placeholder.png" class="w-100 mb-1"> 
                                            </div>
                                            <div class="col-lg-9">
                                                <p class="text-primary mb-0">{{ order.dispensed_item_name }}</p>
                                                <small>ITEM DESCRIPTION</small>
                                                
                                                <hr>

                                                <p class="text-primary mb-0">{{ order.rx_number }} - {{ order.refill_number }}</p>
                                                <small>ORDER NUMBER - REFILL NUMBER</small>

                                                <hr>

                                                <div class="checkbox checkbox-primary checkbox-icon mb-1">
                                                    <input
                                                        :value="order.total_price_paid"
                                                        @change="setTotal(order, $event)"
                                                        type="checkbox"
                                                        :id="order.id"
                                                        >
                                                    <label :for="order.id" class="text-secondary">
                                                        <small class="float-left" style="margin-top: 2px;">
                                                            <i class="bx bx-check"></i> INCLUDE ITEM ON CHECKOUT
                                                        </small>
                                                    </label>
                                                </div> 
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 px-0 px-md-1 px-lg-1 px-xl-1">
                                <div class="border shadow rounded" style="padding: 15px 5px;">
                                    <div
                                        v-if="signatureSaved == 'success'"
                                        class="alert alert-success alert-dismissible fade show"
                                        role="alert"
                                    >
                                        {{ signatureMsg }}
                                        <button
                                            type="button"
                                            class="close"
                                            data-dismiss="alert"
                                            aria-label="Close"
                                        >
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div
                                        v-if="signatureSaved == 'failed'"
                                        class="alert alert-danger alert-dismissible fade show"
                                        role="alert"
                                        >
                                        {{ signatureMsg }}
                                        <button
                                            type="button"
                                            class="close"
                                            data-dismiss="alert"
                                            aria-label="Close"
                                        >
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div
                                        v-bind:class="{
                                            alert: activeError,
                                            'alert-danger': activeError
                                        }"
                                        role="alert"
                                        v-html="errorText"
                                        ></div>

                                    <div
                                        v-if="processing"
                                        class="alert alert-info fade show"
                                        role="alert"
                                        >
                                        Processing request... Please wait.
                                        <button
                                            type="button"
                                            class="close"
                                            data-dismiss="alert"
                                            aria-label="Close"
                                        >
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="payment-info-wrapper">

                                        <label>Change Shipping Service</label>
                                        <select
                                            class="form-control form-control-sm-sm w-100"
                                            v-model="shipping"
                                            @change="addShipping(shipping.cost)"
                                        >
                                            <option
                                                :selected="true"
                                                :value="{
                                                    type:
                                                        'Free Shipping (3-5 days)',
                                                    cost: '0.00'
                                                }"
                                            >
                                                Free($0.00 3-5 days)
                                            </option>
                                            <option
                                                :value="{
                                                    type:
                                                        'Expedited Shipping (1-3 days)',
                                                    cost: '25.00'
                                                }"
                                            >
                                                Expedited($25.00 1-3 days)
                                            </option>
                                        </select>
                                    </div>

                                    <div class="row justify-content-center mt-1">
                                        <label class="col-md-12"><span class="payment-info-wrapper">Your Signature</span></label>
                                        <!-- <div class="col-1"></div> -->
                                        <VueSignaturePad
                                            height="94px"
                                            ref="signaturePad"
                                            class="col-10 col-md-10 col-lg-11 col-xl-11 mb-1 px-3 border rounded sigPad"
                                        />

                                        <div class="col-12">
                                            <div class="payment-info-wrapper">
                                                <button
                                                    @click.prevent="clearsign"
                                                    class="btn btn-warning btn-rounded btn-icon mb-1"
                                                >
                                                    <i class="bx bx-x-circle"></i>
                                                </button>
                                                <button
                                                    @click.prevent="savesign"
                                                    class="btn btn-primary btn-rounded btn-icon mb-1"
                                                >
                                                    <i class="bx bxs-check-circle"></i>
                                                </button>
                                            </div>
                                                
                                        </div>
                                        
                                        <div class="col-12 mb-1">
                                            <div class="payment-info-wrapper">
                                                <label>Card Information</label>
                                                <div id="card-element"></div>
                                            </div>
                                        </div>

                                        <div class="mt-3 mb-2 w-100 text-center">
                                            <h4 class="text-bold mb-0">
                                                <span>${{ isFloat(total) ? total : total + '.00' }}</span>
                                            </h4>
                                            <p class="text-primary">Total Payable</p>
                                        </div>

                                        <div v-if="stripe_key != null || stripe_secret != null" class="form-group col-md-12 mt-1">
                                            <div class="payment-info-wrapper">
                                                <button
                                                    class="btn btn-success btn-block"
                                                    type="submit"
                                                    @click.prevent="paymentSubmit"
                                                >
                                                    Finalize Payment
                                                </button>
                                            </div>
                                        </div>

                                        <div v-else class="form-group col-md-12 mt-1">
                                            <div class="payment-info-wrapper">
                                                <div class="alert bg-rgba-warning alert-dismissible mb-2" role="alert">
                                                    <p class="mb-0 text-center">
                                                        Pharmacy has not yet setup a payment method
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-body border shadow rounded mt-2">
                                    <div class="payment-info-wrapper" id="patient-information-wrapper">
                                        
                                        <h5 class="mb-0 text-primary">
                                            PATIENT INFORMATION
                                        </h5>
                                        <small>Edit patient information on this panel.</small>

                                        <div class="mt-1">
                                            <a
                                                class="w-100 text-left"
                                                data-toggle="collapse"
                                                href="#collapseOne"
                                                role="button"
                                                aria-expanded="true"
                                                aria-controls="collapseOne"
                                                data-target="#collapseOne"
                                            >
                                                <h5>
                                                    {{ invoice.user.name }}
                                                    <i class="ti-pencil float-right"></i>
                                                </h5>
                                                <h6 style="text-overflow: ellipsis">
                                                    {{ invoice.patient_data.address }},
                                                    {{ invoice.patient_data.city }},<br />
                                                    {{ invoice.patient_data.state }}
                                                    {{ invoice.patient_data.zip_code }}
                                                </h6>
                                            </a>
                                        </div>


                                        <div class="row m-0 mt-1">
                                            <div class="col-12 px-0 text-left">
                                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#patient-info-modal">
                                                    <i class="bx bxs-edit-alt"></i> Edit Patient
                                                </button>
                                                
                                            </div>
                                        </div>
                                    </div>

                                        

                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="sameHeight col-md-4">
                        <div class="card bg-color">
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="patient-info-modal" tabindex="-1" aria-labelledby="pateint-info-modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="pateint-info-modal-label">Patient Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Patient Name</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                v-model="invoice.user.name"
                            />
                        </div>

                        <div class="row">
                            <div class="form-group col-md-7">
                                <label>Email Address</label>
                                <input
                                    type="email"
                                    class="form-control form-control-sm"
                                    required
                                    v-model="invoice.user.email"
                                />
                            </div>

                            <div class="form-group col-md-5">
                                <label>Phone Number</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="invoice.user.phone"
                                />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Shipping Address</label>
                            <input
                                class="form-control form-control-sm"
                                v-model="invoice.patient_data.address"
                            />
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>City</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="invoice.patient_data.city"
                                />
                            </div>
                            <div class="form-group col-md-3">
                                <label>State</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="invoice.patient_data.state"
                                />
                            </div>
                            <div class="form-group col-md-5">
                                <label>Zip Code</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="invoice.patient_data.zip_code"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
export default {
    data() {
        return {
            invoice: {
                user: {},
                patient_data: {},
                invoice_orders: [],
                payment: {}
            },

            orders: [],
            amounts: [],
            shipping: { type: "Free Shipping (3-5 days)", cost: "0.00" },
            subtotal: "0.0",
            total: 0,

            signatureSaved: false,
            signatureMsg: "Successfuly saved signature",

            activeError: false,
            errorText: "",
            stripe: null,
            card: null,
            cvc: null,
            exp: null,
            processing: false,

            countCheck: 0,
            selectedItems: [],
            shippingCost: 0,

            stripe_key: null,
            stripe_secret: null
        };
    },

    created() {
        this.axios
            .get(`/api/invoices/${this.$route.params.invoice}`)
            .then(response => {
                console.log("Asdasdas", response.data)
                this.invoice = response.data;
            });
    },


    mounted() {

        this.axios
            .get(`/api/invoices/${this.$route.params.invoice}`)
            .then(response => {
                this.invoice = response.data;

                let pharmacy_id = response.data.patient_data.pharmacy_id

                this.axios.get(`/api/stripeAccount?user_id=` + pharmacy_id).then(res => {
                    this.stripe_key = res.data.stripe_key
                    this.stripe_secret = res.data.stripe_secret

                    if(this.stripe_key != null) {
                        this.stripe = Stripe(this.stripe_key);

                        // this.stripe = Stripe(`pk_test_4oBzO12w7nLcBlZ6XSpJdmoS00sQpzim5j`);

                        const elements = this.stripe.elements();

                        var style = {
                            base: {
                                color: '#32325d',
                                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                fontSmoothing: 'antialiased',
                                fontSize: '16px',
                                '::placeholder': {
                                color: '#aab7c4'
                                }
                            },
                            invalid: {
                                color: '#fa755a',
                                iconColor: '#fa755a'
                            }
                        };

                        var user_card = elements.create('card', {style: style, hidePostalCode: true});
                        user_card.mount('#card-element');
                        this.card = user_card;
                    }
                }).catch((err) => {
                    console.log("Error: ", err);
                });
            }).catch((error) => {
                console.log("Error on fetching invoices in checkout: ", error);
            });
    },

    methods: {
        
        clearsign() {
            this.$refs.signaturePad.undoSignature();
        },
        isFloat(n) {
            return n === +n && n !== (n|0);
        },
        savesign() {
            var self = this;
            const { isEmpty, data } = this.$refs.signaturePad.saveSignature();

            if (!isEmpty) {
                this.axios
                    .post(`/api/signature`, { signature: data })
                    .then(response => {
                        self.axios
                            .put(`/api/invoices/${self.invoice.id}`, {
                                signature: response.data
                            })
                            .then(res => {
                                if (res.data.error) {
                                    self.signatureSaved = "failed";
                                    self.signatureMsg = res.data.message;
                                } else {
                                    self.signatureSaved = "success";
                                }
                            });
                    });
            }
        },

        setTotal(order, event) {
            let amount = parseFloat(event.target.value);
            if(event.target.checked){
                this.selectedItems.push(order.id)
                this.countCheck++;
                this.total += amount;
            }else{
                this.selectedItems.indexOf(order.id) !== -1 && this.selectedItems.splice(this.selectedItems.indexOf(order.id), 1)
                this.countCheck--;
                this.total -= amount;
            }

            this.total = Math.round(this.total * 100) / 100
        },

        addShipping(cost) {
            var shipped = parseFloat(cost);
            if (shipped == 0) {
                this.total -= this.shippingCost;
            } else {
                this.shippingCost = shipped;
                this.total += shipped;
                
            }
        },

        paymentSubmit() {
            if(this.countCheck > 0){
                let itemCounter = document.getElementsByClassName('itemCounter') 
                let status = "completed";
                let invoice_status =  (itemCounter.length == this.countCheck) ? "completed" : "pending";

                let cardData = {
                    name: this.invoice.user.name
                };

                console.log("THIS STRIPE: ", this.stripe);

                this.stripe.createToken(this.card, cardData).then(result => {
                    if (result.error && result.error.message) {
                        this.signatureSaved = false;
                        this.signatureMsg = result.error.message;
                    } else {
                        var payload = {
                            name: this.invoice.user.name,
                            phone: this.invoice.user.phone,
                            user_id: this.invoice.user.id,
                            invoice_id: this.invoice.id,
                            orders: this.selectedItems,
                            invoice_number: this.invoice.number,
                            email: this.invoice.user.email,
                            address: this.invoice.patient_data.address,
                            amount: this.total,
                            shipping: this.shipping,
                            token: result.token.id,
                            status: status,
                            invoice_status: invoice_status,
                            stripe_secret: this.stripe_secret
                        };

                        this.processing = true;

                        this.axios
                            .put(
                                `/api/orders/${this.selectedItems}`,
                                {current_transaction_status: "Completed"}
                            )
                            .then(response => {});

                        this.axios
                            .put(
                                `/api/patients/${this.invoice.patient_data.id}`,
                                this.invoice.patient_data
                            )
                            .then(response => {});

                        this.axios
                            .put(
                                `/api/users/${this.invoice.user.id}`,
                                this.invoice.user
                            )
                            .then(response => {
                                this.axios
                                    .post(`/api/payments`, payload)
                                    .then(res => {
                                        var error = res.data.error;
                                        if (error) {
                                            this.activeError = true;
                                            this.errorText = result.data.message;
                                        } else {
                                            this.$router.push({
                                                path: `/complete/${res.data.payment.id}`
                                            });
                                        }
                                    });
                            });

                        this.activeError = false;
                        this.errorText = "";
                        this.ccName = "";
                        this.card.clear();
                        this.cvc.clear();
                        this.exp.clear();
                    }
                });
            } else{
                alert("Please select atleast one item!");
            }
        },

        array_filter(arr) {
            var index = -1,
                arr_length = arr ? arr.length : 0,
                resIndex = -1,
                result = [];

            while (++index < arr_length) {
                var value = arr[index];

                if (value) {
                    result[++resIndex] = value;
                }
            }

            return result;
        }
    }
};
</script>

<style>
    /*.InputElement {
        display: block !important;
        width: 100% !important;
        height: calc(1.4em + 0.94rem + 3.7px) !important;
        padding: 0.47rem 0.8rem !important;
        font-size: 1rem !important;
        font-weight: 400 !important;
        line-height: 1. !important;
        color: #475F7B !important;
        background-color: #FFFFFF !important;
        background-clip: padding-box !important;
        border: 1px solid #DFE3E7 !important;
        border-radius: 0.267rem !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
    }*/

    .StripeElement {
        box-sizing: border-box;

        height: 40px;

        padding: 10px 12px;

        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;

        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }

    .payment-info-wrapper {
        padding: 0px 12px !important;
    }

    /*signature-buttons-wrapper*/

    /*@media all and (max-width: 699px) and (min-width: 520px), (min-width: 1151px) {

    }
    padding: 0px 25px !important;*/


    /*.row.no-gutters {
        margin-right: 0;
        margin-left: 0;

        & > [class^="col-"],
        & > [class*=" col-"] {
            padding-right: 0;
            padding-left: 0;
        }
    }

    .sameHeight {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display:         flex;
        flex-wrap: wrap;
        }
    .sameHeight > [class*='col-'] {
        display: flex;
        flex-direction: column;
    }

    .bg-color {
        background-color: #e2e2e2;
    }

    .sigPad {
        background-color: #fff;
    }*/

</style>
