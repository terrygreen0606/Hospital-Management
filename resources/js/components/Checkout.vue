<template>

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <form id="payment-form" class="row no-gutters">
                        <div class="col-md-12 grid-margin">
                            <h4 class="font-weight-bold">
                                Checkout now
                                <router-link to="/" class="font-weight-bold float-right">
                                    <i class="ti-home"></i>
                                </router-link>
                            </h4>
                            <h6 class="">Select your prescription and pay</h6>
                        </div>
                        <div class="sameHeight col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><i class="bx bx-check"></i></th>
                                                <th>Item Description</th>
                                                <th>Order Number - Refill Number</th>
                                                <th>Dispensed Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class="border-0"
                                                v-for="order in invoice.invoice_orders"
                                                :key="order.id"
                                                >
                                                <template v-if="
                                                            order.current_transaction_status !==
                                                                'Completed' &&
                                                                order.current_transaction_status !==
                                                                    'Cancelled'
                                                        ">
                                                    <td align="left">
                                                        <fieldset>
                                                            <div class="checkbox checkbox-primary checkbox-icon">
                                                                <input
                                                                    :value="order.total_price_paid"
                                                                    @change="setTotal(order, $event)"
                                                                    type="checkbox"
                                                                    :id="order.id"
                                                                    >
                                                                <label :for="order.id"><i class="bx bx-check"></i></label>
                                                            </div>  
                                                        </fieldset>
                                                    </td>
                                                    <td data-title="Item Name">{{ order.dispensed_item_name }}</td>
                                                    <td data-title="RX Number" >
                                                        {{ order.rx_number }}-{{
                                                            order.refill_number
                                                        }}
                                                    </td>
                                                    <td data-title="Dispensed Quantity">
                                                        {{order.dispensed_quantity}}
                                                    </td>
                                                    <td data-title="Amount" lass="text-right" >
                                                        ${{ order.total_price_paid }}
                                                    </td>
                                                </template>
                                            </tr>

                                            <tr>
                                                <td colspan="4" >
                                                    {{ shipping.type }}
                                                </td>
                                                <td>
                                                    ${{ shipping.cost }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <hr>
                                    <a
                                        class="w-100 text-left"
                                        data-toggle="collapse"
                                        href="#user-details"
                                        role="button"
                                        aria-expanded="false"
                                        aria-controls="user-details"
                                    >
                                        <h5>
                                            {{ invoice.user.name }}
                                            <i class="ti-pencil float-right"></i>
                                        </h5>
                                        <h6 style="text-overflow: ellipsis">
                                            {{ invoice.patient.address }},
                                            {{ invoice.patient.city }},<br />
                                            {{ invoice.patient.state }}
                                            {{ invoice.patient.zip_code }}
                                        </h6>
                                    </a>
                                    <div class="collapse" id="user-details">
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
                                                v-model="invoice.patient.address"
                                            />
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label>City</label>
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    v-model="invoice.patient.city"
                                                />
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>State</label>
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    v-model="invoice.patient.state"
                                                />
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label>Zip Code</label>
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    v-model="invoice.patient.zip_code"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sameHeight col-md-4">
                            <div class="card bg-color">
                                <div class="card-body" style="background-color: '#f5f5f5">
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

                                    <div class="px-4 col-md-12">

                                        <label>Change Shipping Service</label>
                                        <select
                                            class="form-control form-control-sm form-control form-control-sm-sm w-100"
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
                                        <h4 class="my-1 text-bold">Total: <span class="float-right">${{ isFloat(total) ? total : total + '.00' }}</span></h4>
                                    </div>

                                    <div class="px-4 row justify-content-center">
                                        <label class="col-md-12">Your Signature</label>
                                        <VueSignaturePad
                                            height="94px"
                                            ref="signaturePad"
                                            class="col-md-10 mb-1 px-2 border rounded sigPad"
                                        />
                                        <div class="col-md-1 mb-1 justify-content-sm-between">
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

                                        <div class="form-group col-md-12">
                                            <label for="card-number">Card Number</label>
                                            <span
                                                id="card-number"
                                                class="form-control form-control-sm stripe-element-container"
                                            >
                                                <!-- Stripe Card Element -->
                                            </span>
                                        </div>

                                        <div class="form-group col-5 col-md-6">
                                            <label for="card-cvc">CVC</label>
                                            <span
                                                id="card-cvc"
                                                class="form-control form-control-sm stripe-element-container"
                                            >
                                                <!-- Stripe CVC Element -->
                                            </span>
                                        </div>

                                        <div class="form-group col-7 col-md-6">
                                            <label for="card-exp">Expiration</label>
                                            <span
                                                id="card-exp"
                                                class="form-control form-control-sm stripe-element-container"
                                            >
                                                <!-- Stripe Card Expiry Element -->
                                            </span>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <button
                                                class="btn btn-primary btn-block"
                                                type="submit"
                                                @click.prevent="paymentSubmit"
                                            >
                                                Pay
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            invoice: {
                user: {},
                patient: {},
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
            shippingCost: 0
        };
    },

    created() {
        this.axios
            .get(`/api/invoices/${this.$route.params.invoice}`)
            .then(response => {
                console.log(response.data)
                this.invoice = response.data;
            });
    },

    mounted: function() {
        this.stripe = Stripe(`pk_test_4oBzO12w7nLcBlZ6XSpJdmoS00sQpzim5j`);

        const elements = this.stripe.elements();

        const style = {
            base: {
                fontSize: "16px",
                color: "#495057",
                fontFamily:
                    'apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif'
            }
        };

        // Card number
        this.card = elements.create("cardNumber", {
            placeholder: "Card number",
            style: style
        });
        this.card.mount("#card-number");

        // CVC
        this.cvc = elements.create("cardCvc", {
            placeholder: "CVC",
            style: style
        });
        this.cvc.mount("#card-cvc");

        // Card expiry
        this.exp = elements.create("cardExpiry", {
            placeholder: "Expiry MM/YY",
            style: style
        });
        this.exp.mount("#card-exp");
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
                            address: this.invoice.patient.address,
                            amount: this.total,
                            shipping: this.shipping,
                            token: result.token.id,
                            status: status,
                            invoice_status: invoice_status
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
                                `/api/patients/${this.invoice.patient.id}`,
                                this.invoice.patient
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

<style scoped>
    .row.no-gutters {
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
    }

</style>
