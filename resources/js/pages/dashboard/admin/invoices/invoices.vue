<template>
    <div class="content">
        <div class="content-body">
            <div class="row m-0">
                <div class="col-md-12 px-1">
                    <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                    <p>{{ $route.meta.subtitle }}</p>

                    <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cancelled-tab" data-toggle="tab" href="#cancelled" role="tab" aria-controls="cancelled" aria-selected="false">Cancelled</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">Completed</a>
                        </li>
                    </ul>
                    <div class="tab-content px-0" id="myTabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
                            <div class="table-responsive pmd-table-card">
                                <table id="invoice-listing" class="table pmd-table" style="margin-bottom: 9.1vh;">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Patient</th>
                                            <th>Created On</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="invoice in invoices.data" :key="invoice.id">
                                            <template v-if="invoice.status === 'Open'">
                                                <td data-title="Number">{{ invoice.number }}</td>
                                                <td data-title="Patient">
                                                    {{ invoice.user.name }}
                                                </td>
                                                <td data-title="Created on">
                                                    {{ invoice.created_at }}
                                                </td>
                                                <td data-title="Status" class="text-capitalize">
                                                    {{ invoice.status }}
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-block btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            OPTIONS
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="javascript:void(0)" class="dropdown-item" @click="deleteInvoice(invoice.id)">
                                                                <i class="bx bx-trash mr-1"></i> Delete Record
                                                            </a>
                                                            <router-link :to="{ name: 'view_invoice', params: { id: invoice.id } }" class="dropdown-item">
                                                                <i class="bx bx-show mr-1"></i> Open Details
                                                            </router-link>
                                                        </div>
                                                    </div>


                                                            <!-- <router-link
                                                                :to="{
                                                                    name: 'view_invoice',
                                                                    params: { id: invoice.id }
                                                                }"
                                                                tag="button"
                                                                class="btn btn-dark btn-rounded btn-icon"
                                                            >
                                                                <i class="bx bx-show"></i>
                                                            </router-link>
                                                    <button
                                                        @click="deleteInvoice(invoice.id)"
                                                        class="btn btn-danger btn-rounded btn-icon"
                                                    >
                                                        <i class="bx bx-trash"></i>
                                                    </button> -->
                                                </td>
                                            </template>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="6" class="text-left pl-2">
                                            <pagination
                                                :limit="1"
                                                :data="invoices"
                                                @pagination-change-page="getInvoices"
                                            ></pagination>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="table-responsive pmd-table-card">
                                <table id="invoice-listing" class="table pmd-table" style="margin-bottom: 9.1vh;">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Patient</th>
                                            <th>Created On</th>
                                            <th>Status</th>
                                            <th>Invoice Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="invoice in invoices.data" :key="invoice.id">
                                            <template v-if="invoice.status === 'Pending'">
                                                <td data-title="Number">{{ invoice.number }}</td>
                                                <td data-title="Patient">
                                                    {{ invoice.user.name }}
                                                </td>
                                                <td data-title="Created on">
                                                    {{ invoice.created_at }}
                                                </td>
                                                <td data-title="Status" class="text-capitalize">
                                                    {{ invoice.status }}
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-block btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            OPTIONS
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="javascript:void(0)" class="dropdown-item" @click="deleteInvoice(invoice.id)">
                                                                <i class="bx bx-trash mr-1"></i> Delete Record
                                                            </a>
                                                            <router-link :to="{ name: 'view_invoice', params: { id: invoice.id } }" class="dropdown-item">
                                                                <i class="bx bx-show mr-1"></i> Open Details
                                                            </router-link>
                                                        </div>
                                                    </div>
                                                    <!-- <router-link
                                                        :to="{
                                                            name: 'view_invoice',
                                                            params: { id: invoice.id }
                                                        }"
                                                        tag="button"
                                                        class="btn btn-dark btn-rounded btn-icon"
                                                    >
                                                        <i class="bx bx-show"></i>
                                                    </router-link>
                                                    <button
                                                        @click="deleteInvoice(invoice.id)"
                                                        class="btn btn-danger btn-rounded btn-icon"
                                                    >
                                                        <i class="bx bx-trash"></i>
                                                    </button> -->
                                                </td>
                                            </template>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="6" class="text-left pl-2">
                                            <pagination
                                                :limit="1"
                                                :data="invoices"
                                                @pagination-change-page="getInvoices"
                                            ></pagination>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                            <div class="table-responsive pmd-table-card">
                                <table id="invoice-listing" class="table pmd-table" style="margin-bottom: 9.1vh;">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Patient</th>
                                            <th>Created On</th>
                                            <th>Status</th>
                                            <th>Invoice Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="invoice in invoices.data" :key="invoice.id">
                                            <template v-if="invoice.status === 'Cancelled'">
                                                <td data-title="Number">{{ invoice.number }}</td>
                                                <td data-title="Patient">
                                                    {{ invoice.user.name }}
                                                </td>
                                                <td data-title="Created on">
                                                    {{ invoice.created_at }}
                                                </td>
                                                <td data-title="Status" class="text-capitalize">
                                                    {{ invoice.status }}
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-block btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            OPTIONS
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="javascript:void(0)" class="dropdown-item" @click="deleteInvoice(invoice.id)">
                                                                <i class="bx bx-trash mr-1"></i> Delete Record
                                                            </a>
                                                            <router-link :to="{ name: 'view_invoice', params: { id: invoice.id } }" class="dropdown-item">
                                                                <i class="bx bx-show mr-1"></i> Open Details
                                                            </router-link>
                                                        </div>
                                                    </div>
                                                    <!-- <router-link
                                                        :to="{
                                                            name: 'view_invoice',
                                                            params: { id: invoice.id }
                                                        }"
                                                        tag="button"
                                                        class="btn btn-dark btn-rounded btn-icon"
                                                    >
                                                        <i class="bx bx-show"></i>
                                                    </router-link>
                                                    <button
                                                        @click="deleteInvoice(invoice.id)"
                                                        class="btn btn-danger btn-rounded btn-icon"
                                                    >
                                                        <i class="bx bx-trash"></i>
                                                    </button> -->
                                                </td>
                                            </template>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="6" class="text-left pl-2">
                                            <pagination
                                                :limit="1"
                                                :data="invoices"
                                                @pagination-change-page="getInvoices"
                                            ></pagination>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                            <div class="table-responsive pmd-table-card">
                                <table id="invoice-listing" class="table pmd-table" style="margin-bottom: 9.1vh;">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Patient</th>
                                            <th>Created On</th>
                                            <th>Status</th>
                                            <th>Invoice Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="invoice in invoices.data" :key="invoice.id">
                                            <template v-if="invoice.status === 'Completed'">
                                                <td data-title="Number">{{ invoice.number }}</td>
                                                <td data-title="Patient">
                                                    {{ invoice.user.name }}
                                                </td>
                                                <td data-title="Created on">
                                                    {{ invoice.created_at }}
                                                </td>
                                                <td data-title="Status" class="text-capitalize">
                                                    {{ invoice.status }}
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-block btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            OPTIONS
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="javascript:void(0)" class="dropdown-item" @click="deleteInvoice(invoice.id)">
                                                                <i class="bx bx-trash mr-1"></i> Delete Record
                                                            </a>
                                                            <router-link :to="{ name: 'view_invoice', params: { id: invoice.id } }" class="dropdown-item">
                                                                <i class="bx bx-show mr-1"></i> Open Details
                                                            </router-link>
                                                        </div>
                                                    </div>
                                                    <!-- <router-link
                                                        :to="{
                                                            name: 'view_invoice',
                                                            params: { id: invoice.id }
                                                        }"
                                                        tag="button"
                                                        class="btn btn-dark btn-rounded btn-icon"
                                                    >
                                                        <i class="bx bx-show"></i>
                                                    </router-link>
                                                    <button
                                                        @click="deleteInvoice(invoice.id)"
                                                        class="btn btn-danger btn-rounded btn-icon"
                                                    >
                                                        <i class="bx bx-trash"></i>
                                                    </button> -->
                                                </td>
                                            </template>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="6" class="text-left pl-2">
                                            <pagination
                                                :limit="1"
                                                :data="invoices"
                                                @pagination-change-page="getInvoices"
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
    </div>
</template>

<script>
import swal from 'sweetalert';

export default {
    data() {
        return {
            invoices: {}
        };
    },
    mounted() {
        this.getInvoices();
    },
    methods: {
        async deleteInvoice(id) {
            const willDelete = await swal({
                title: "Are you sure?",
                text: "Are you sure that you want to delete this user?",
                icon: "warning",
                dangerMode: true,
                buttons: true,
            });
            
            if (willDelete) {
                this.axios.delete(`/api/invoices/${id}`).then(response => {
                    let i = this.invoices.map(item => item.id).indexOf(id); // find index of your object
                    this.invoices.splice(i, 1);
                        swal("Deleted!", "User has been deleted has been deleted!", "success");
                    });
            }
        },
        
        getInvoices(page = 1) {
            let p = page == 1 ? "" : "?page=" + page;
            this.axios.get("/api/invoices" + p).then(response => {
                this.invoices = response.data;
            });

            // this.axios.get("/api/invoices?showStatus=true").then(response => {
            //     this.invoices = response.data;
            // });
        }
    }
};
</script>
