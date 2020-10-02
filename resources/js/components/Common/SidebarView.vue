<template>
    <!-- BEGIN: Main Menu-->
    <div class="main-sidebar-view">
        <div
            class="main-menu menu-fixed menu-light menu-accordion menu-shadow"
            data-scroll-to-active="true"
        >
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mr-auto">
                        <!-- <a class="navbar-brand" href="/html/ltr/vertical-menu-boxicons-template/index.html">
                        </a> -->
                        <router-link class="navbar-brand" to="/">
                            <div class="brand-logo">
                                <img
                                    class="logo"
                                    src="/assets/images/logo.png"
                                />
                            </div>
                        </router-link>
                    </li>
                    <li class="nav-item nav-toggle">
                        <a
                            class="nav-link modern-nav-toggle pr-0"
                            data-toggle="collapse"
                            ><i
                                class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"
                            ></i
                            ><i
                                class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                                data-ticon="bx-disc"
                            ></i
                        ></a>
                    </li>
                </ul>
            </div>
            <div class="shadow-bottom"></div>
            <div class="main-menu-content">
                <ul
                    class="navigation navigation-main"
                    id="main-menu-navigation"
                    data-menu="menu-navigation"
                    data-icon-style=""
                >
                    <!-- ADMIN SIDEBAR LINKS -->
                    <template v-if="$auth.user().role == 'admin'">
                        <li class=" navigation-header">
                            <span>Dashboard</span>
                        </li>
                        <li class=" nav-item">
                            <router-link class="nav-link" to="/admin"
                                ><i class="bx bxs-home"></i
                                ><span class="menu-title"
                                    >Home</span
                                ></router-link
                            >
                        </li>
                        <li class=" nav-item has-sub">
                            <a href="#"
                                ><i class="bx bx-film"></i
                                ><span class="menu-title">RX Center</span></a
                            >
                            <ul class="menu-content">
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/admin/rxdata"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span class="menu-item"
                                            >Patient Education</span
                                        >
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/admin/formulary"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span class="menu-item"
                                            >Formulary</span
                                        >
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                        <li class=" navigation-header">
                            <span>User Data</span>
                        </li>
                        <li class=" nav-item has-sub">
                            <a href="#"
                                ><i class="bx bx-user-pin"></i
                                ><span class="menu-title">Patient</span></a
                            >
                            <ul class="menu-content">
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/admin/patient"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >All Patients</span
                                        >
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/admin/patient/add"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >Create Patient</span
                                        >
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li class=" nav-item has-sub">
                            <a href="#"
                                ><i class="bx bx-group"></i
                                ><span class="menu-title">Pharmacy</span></a
                            >
                            <ul class="menu-content">
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/admin/pharmacy"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >All Pharmacy</span
                                        >
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/admin/pharmacy/add"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >New Pharmacy</span
                                        >
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li class=" nav-item has-sub">
                            <a href="#"
                                ><i class="bx bxs-user-badge"></i
                                ><span class="menu-title">Prescriber</span></a
                            >
                            <ul class="menu-content">
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/admin/doctor"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >All Prescribers</span
                                        >
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/admin/doctor/add"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >New Prescriber</span
                                        >
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/admin/doctor/import"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >Import Prescribers</span
                                        >
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                        <li class=" navigation-header"><span>Orders</span></li>
                        <li class=" nav-item">
                            <router-link class="nav-link" to="/admin/order">
                                <i class="bx bx-cart"></i
                                ><span class="menu-title">Orders</span>
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link
                                class="nav-link"
                                to="/admin/order-duplicate"
                            >
                                <i class="bx bx-cart"></i
                                ><span class="menu-title"
                                    >Order Duplicates</span
                                >
                                <span
                                    v-if="duplicates > 0"
                                    class="badge badge-light-danger badge-pill badge-round float-right"
                                    >{{ duplicates }}</span
                                >
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link class="nav-link" to="/admin/invoice">
                                <i class="bx bx-file"></i
                                ><span class="menu-title">Invoices</span>
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link
                                class="nav-link"
                                to="/admin/invoice/payments"
                            >
                                <i class="bx bx-credit-card"></i
                                ><span class="menu-title">Payments</span>
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link class="nav-link" to="/admin/shipments">
                                <i class="bx bx-box"></i
                                ><span class="menu-title">Shipments</span>
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link
                                class="nav-link"
                                to="/admin/archives/orders"
                            >
                                <i class="bx bx-archive"></i
                                ><span class="menu-title">Archives</span>
                            </router-link>
                        </li>
                    </template>
                    <!-- END ADMIN SIDEBAR LINKS -->

                    <!-- PHARMACY SIDEBAR LINKS -->
                    <template
                        v-if="
                            $auth.user().role == 'provider' ||
                                $auth.user().role == 'pharmacy'
                        "
                    >
                        <li class=" navigation-header">
                            <span>Dashboard</span>
                        </li>
                        <li class=" nav-item">
                            <router-link class="nav-link" to="/pharmacy"
                                ><i class="bx bxs-home"></i
                                ><span class="menu-title"
                                    >Home</span
                                ></router-link
                            >
                        </li>

                        <li class=" navigation-header">
                            <span>User Data</span>
                        </li>
                        <li class=" nav-item has-sub">
                            <a href="#"
                                ><i class="bx bx-user-pin"></i
                                ><span class="menu-title">Patients</span></a
                            >
                            <ul class="menu-content">
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/pharmacy/patient"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >All Patients</span
                                        >
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/pharmacy/patient/new"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >New Patient</span
                                        >
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li class=" nav-item has-sub">
                            <a href="#"
                                ><i class="bx bxs-user-badge"></i
                                ><span class="menu-title">Prescriber</span></a
                            >
                            <ul class="menu-content">
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/pharmacy/doctor"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >All Prescribers</span
                                        >
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/pharmacy/doctor/add"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >New Prescriber</span
                                        >
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/pharmacy/doctor/import"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >Import Prescribers</span
                                        >
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                        <li class=" navigation-header"><span>Orders</span></li>
                        <li class=" nav-item">
                            <router-link class="nav-link" to="/pharmacy/order">
                                <i class="bx bx-cart"></i
                                ><span class="menu-title">Orders</span>
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link
                                class="nav-link"
                                to="/pharmacy/order-duplicates"
                            >
                                <i class="bx bx-cart"></i
                                ><span class="menu-title"
                                    >Order Duplicates</span
                                >
                                <span
                                    v-if="duplicates > 0"
                                    class="badge badge-light-danger badge-pill badge-round float-right"
                                    >{{ duplicates }}</span
                                >
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link
                                class="nav-link"
                                to="/pharmacy/order/invoice"
                            >
                                <i class="bx bx-file"></i
                                ><span class="menu-title">Invoices</span>
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link
                                class="nav-link"
                                to="/pharmacy/payments"
                            >
                                <i class="bx bx-credit-card"></i
                                ><span class="menu-title">Payments</span>
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link
                                class="nav-link"
                                to="/pharmacy/shipments"
                            >
                                <i class="bx bx-box"></i
                                ><span class="menu-title">Shipments</span>
                            </router-link>
                        </li>
                        <li class=" nav-item has-sub">
                            <a href="#"
                                ><i class="bx bxs-user-badge"></i
                                ><span class="menu-title">Settings</span></a
                            >
                            <ul class="menu-content">
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/pharmacy/settings/stripe"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >Stripe Account</span
                                        >
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                    </template>
                    <!-- END PHARMACY SIDEBAR LINKS -->

                    <!-- END PATIENT SIDEBAR LINKS -->
                    <template v-if="$auth.user().role == 'patient'">
                        <li class=" nav-item">
                            <router-link class="nav-link" to="/patient">
                                <i class="bx bxs-home"></i
                                ><span class="menu-title">Home</span>
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link class="nav-link" to="/patient/orders">
                                <i class="bx bx-cart"></i
                                ><span class="menu-title">Orders</span>
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link
                                class="nav-link"
                                to="/patient/invoices"
                            >
                                <i class="bx bx-file"></i
                                ><span class="menu-title">Invoices</span>
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link
                                class="nav-link"
                                to="/patient/payments"
                            >
                                <i class="bx bx-credit-card"></i
                                ><span class="menu-title">Payments</span>
                            </router-link>
                        </li>
                        <li class=" nav-item">
                            <router-link
                                class="nav-link"
                                to="/patient/education"
                            >
                                <i class="bx bx-book"></i
                                ><span class="menu-title"
                                    >Patient Education</span
                                >
                            </router-link>
                        </li>
                    </template>
                    <!-- END PATIENT SIDEBAR LINKS -->

                    <!-- PRESRIBER SIDEBER -->
                    <template
                        v-if="
                            $auth.user().role == 'prescriber' ||
                                $auth.user().role == 'doctor'
                        "
                    >
                        <li class=" navigation-header">
                            <span>Dashboard</span>
                        </li>
                        <li class=" nav-item">
                            <router-link class="nav-link" to="/prescriber">
                                <i class="bx bxs-home"></i>
                                <span class="menu-title">Home</span>
                            </router-link>
                        </li>

                        <li class=" navigation-header">
                            <span>User Data</span>
                        </li>
                        <li class=" nav-item has-sub">
                            <a href="#"
                                ><i class="bx bx-user-pin"></i
                                ><span class="menu-title">Patients</span></a
                            >
                            <ul class="menu-content">
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/prescriber/patients"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >All Patients</span
                                        >
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/prescriber/patients/new"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >New Patient</span
                                        >
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                        <li class=" nav-item has-sub">
                            <a href="#"
                                ><i class="bx bx-box"></i
                                ><span class="menu-title">RX Center</span></a
                            >
                            <ul class="menu-content">
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/prescriber/formulary"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >Formulary</span
                                        >
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                        <li class=" nav-item has-sub">
                            <a href="#"
                                ><i class="bx bx-folder-open"></i
                                ><span class="menu-title">RX Orders</span></a
                            >
                            <ul class="menu-content">
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/prescriber/rxhistory"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >Prescribed</span
                                        >
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        class="nav-link"
                                        to="/prescriber/shipments"
                                    >
                                        <i class="bx bx-right-arrow-alt"></i
                                        ><span
                                            class="menu-item"
                                            data-i18n="Invoice List"
                                            >Shipments</span
                                        >
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                    </template>
                    <!-- END PRESRIBER SIDEBER -->
                </ul>
            </div>
        </div>
    </div>
    <!-- END: Main Menu-->
</template>

<script>
export default {
    data() {
        return {
            isMirror: 0,
            duplicates: 0
        };
    },
    mounted() {
        let mirror = localStorage.getItem("mirrorView");
        this.isMirror = mirror ? mirror : 0;
        setInterval(() => {
            if (this.$auth.user().role == "admin") {
                this.axios.get("/api/duplicates").then(response => {
                    this.duplicates = response.data.total;
                });
            } else {
                this.axios
                    .get(
                        "/api/duplicates?pharmacy_name=" +
                            this.$auth.user().name
                    )
                    .then(response => {
                        this.duplicates = response.data.total;
                    });
            }
        }, 10000);
    }
};
</script>
