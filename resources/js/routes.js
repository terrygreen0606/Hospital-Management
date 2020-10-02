import Home from './components/Home.vue';
import Base from './components/Common/Base.vue';

import Register from './components/Auth/Register.vue';
import Login from './components/Auth/Login.vue';

// ADMIN DASHBOARD

import AllOrders from './components/Admin/Orders/All.vue';
import AddOrder from './components/Admin/Orders/Add.vue';
import EditOrder from './components/Admin/Orders/Edit.vue';
import OrderDetail from './components/Admin/Orders/OrderDetails.vue'

import RefreshInvoices from './components/Admin/Invoices/Refresh.vue';
import AllInvoices from './components/Admin/Invoices/All.vue';
import EditInvoice from './components/Admin/Invoices/Edit.vue';
import Invoice from './components/Admin/Invoices/Invoice.vue';

import Invoices from './components/Invoices.vue';
// import Checkout from './components/Checkout.vue';
import Payments from './components/Payments.vue';
import Payment from './components/Payment.vue';

import AllPayments from './components/Admin/Payments/All.vue';
import PendingPayments from './components/Admin/Payments/Pending.vue';

// PATIENT DASHBOARD
import PatientDashboard from './components/Patient/Dashboard.vue';
import PatientOrders from './components/Patient/Orders.vue';
// import PatientInvoices from './components/Patient/Invoices.vue';
import PatienPayments from './components/Patient/Payments.vue';
// import PatientInvoice from './components/Patient/Invoice.vue';
// import PatientLearn from './components/Patient/PatientEducation.vue';

// Pharmacy Dashboard
import PharmacyDashboard from './components/Pharmacy/Dashboard.vue';
import PharmacyPatient from './components/Pharmacy/Patient/All.vue';
import PharmacyAddPatient from './components/Pharmacy/Patient/New.vue';


import PharmacyAllDoctors from './components/Pharmacy/Doctors/doctors.vue';
import PharmacyAddDoctor from './components/Pharmacy/Doctors/_add-doctor.vue';
import PharmacyEditDoctor from './components/Pharmacy/Doctors/_edit-doctor.vue';
import PharmacyImportDoctors from './components/Pharmacy/Doctors/_import-doctors.vue';
import PharmacyDoctorInfo from './components/Pharmacy/Doctors/_info-doctor.vue';
import PharmacyDoctorFormulary from './components/Pharmacy/Doctors/_formulary-doctor.vue';


import PharmacyAllOrders from './components/Pharmacy/Orders/All.vue';
import PharmacyAllInvoice from './components/Pharmacy/Orders/Invoice.vue';
import PharmacyPayment from './components/Pharmacy/Payments.vue';
import PharmacyShipment from './components/Pharmacy/Shipments.vue';

import PharmacyDuplicateOrders from './components/Pharmacy/Duplicates.vue';

import PharmacySettings from './components/Pharmacy/Settings/Stripe.vue';




import Export from './components/Export.vue';

import ImportUsers from './components/Users/Import.vue';
import AllUsers from './components/Users/All.vue';
import AddUser from './components/Users/Add.vue';
import EditUser from './components/Users/Edit.vue';
import EditProfile from './components/Users/Edit.vue';

import ImportPrescribers from './components/Prescribers/Import.vue';
import AllPrescribers from './components/Prescribers/All.vue';
import AddPrescriber from './components/Prescribers/Add.vue';
import EditPrescriber from './components/Prescribers/Edit.vue';
import AdminPrescriberHistory from './components/Prescribers/RXHistory.vue';
import AdminPrescriberFormulary from './components/Prescribers/Formulary.vue';

import ImportItems from './components/Items/Import.vue';
import AllItems from './components/Items/All.vue';
import AddItem from './components/Items/Add.vue';
import EditItem from './components/Items/Edit.vue';

// import ImportOrders from './components/Orders/Import.vue';
// import AllOrders from './components/Orders/All.vue';
// import AddOrder from './components/Orders/Add.vue';
// import EditOrder from './components/Orders/Edit.vue';
// import OrderDetail from './components/Orders/OrderDetails.vue'

// import RefreshInvoices from './components/Invoices/Refresh.vue';
// import AllInvoices from './components/Invoices/All.vue';
// import EditInvoice from './components/Invoices/Edit.vue';
// import Invoice from './components/Invoices/Invoice.vue';
// import Invoices from './components/Invoices.vue';

import AllReceipts from './components/Receipts/All.vue';
import Receipts from './components/Receipts.vue';
import Receipt from './components/Receipts/Receipt.vue';

// import AllPayments from './components/Payments/All.vue';
// import PendingPayments from './components/Payments/Pending.vue';

import RXdata from './components/RXData/allrxdata.vue';
import Pioneer from './components/Pioneer/pioneerApi.vue';

import Formulary from './components/Admin/Formulary.vue';
import FormularyPrescriber from './components/Admin/FormularyPrescriber.vue';
import IntakeQ from './components/Admin/IntakeQApi.vue';

import Provider from './components/Provider/Index.vue';
import NewProvider from './components/Provider/Add.vue';
import EditProvider from './components/Provider/Edit.vue';
import AdminProviderHistory from './components/Provider/RXHistory.vue';

import ProviderHome from './components/ProviderDashboard/Dashboard.vue'
import RXHistory from './components/ProviderDashboard/RXHistory.vue'
import PatientDetail from './components/ProviderDashboard/PatientDetail.vue'

import PrescriberHome from './components/PrescriberDashboard/Dashboard.vue'
import PrescriberRXHistory from './components/PrescriberDashboard/RXHistory.vue'
import PrescriberPatientDetail from './components/PrescriberDashboard/PatientDetail.vue'
import PrescriberFormulary from './components/PrescriberDashboard/Formulary.vue'

import Settings from './components/Settings.vue';


import AuthRoutes from './pages/auth/routes.js';
import DashboardRoutes from './pages/dashboard/routes.js';

export const routes = [

	...AuthRoutes,
	...DashboardRoutes,

	{
		path: '',
		name: 'home',
		component: Home,
		meta: {
			auth: true,
			title: 'Home - RX Orders'
		}
	},
	{
		path: '/complete/:id',
		name: 'completed',
		component: Payment,
		meta: {
			auth: true,
			title: 'Payment - RX Orders'
		}
	},
	{
		path: '/payments',
		name: 'payments',
		component: Payments,
		meta: {
			auth: true,
			title: 'My Payments - RX Orders'
		}
	},

	{
		path: '/patient',
		component: Base,
		meta: {
			auth: true,
			title: 'Orders - RX Orders'
		},
		children: [
			{
				name: 'all_patient_orders',
				path: 'orders',
				component: PatientOrders,
				meta: {
					auth: true,
					title: 'Patient Orders - RX Orders'
				}
			},
		]
	},
	{
		path: '/pharmacy',
		component: Base,
		meta: {
			auth: true,
			title: 'Orders - RX Orders'
		},
		children: [
			{
				name: 'pharmacy_dashboard',
				path: '',
				component: PharmacyDashboard,
				meta: {
					auth: true,
					title: 'Paharmacy Dashboard - RX Orders'
				}
			},
			{
				path: 'patient',
				component: Base,
				meta: {
					auth: true,
					title: 'Pharmacy Patients - RX Orders'
				},
				children: [
					{
						name: 'pharmacy_patient',
						path: '',
						component: PharmacyPatient,
						meta: {
							auth: true,
							title: 'Pharmacy Patients - RX Orders'
						}
					},
					{
						name: 'pharmacy_new_patient',
						path: 'new',
						component: PharmacyAddPatient,
						meta: {
							auth: true,
							title: 'Pharmacy Patients - RX Orders'
						}
					}
				]
			},
			{
				path: 'doctor',
				component: Base,
				meta: {
					auth: true,
					title: 'Pharmacy Prescriber - RX Orders'
				},
				children: [
					{
						name: 'pharmacy_all_doctors',
						path: '',
						component: PharmacyAllDoctors,
						meta: {
							auth: true,
							titleIcon: 'bx bx-ambulance',
							title: 'Prescribers - RX Prescribers',
							subtitle: 'Manage the prescribers that are currently registered in your platform on this page.'
						}
					},
					{
						name: 'pharmacy_doctor_import',
						path: 'import',
						component: PharmacyImportDoctors,
						meta: {
							auth: true,
							titleIcon: 'bx bx-import',
							title: 'Import Prescriber - RX Prescribers',
							subtitle: 'Import prescriber from a pdf below so that it can be saved in the database.'
						}
					},
					{
						name: 'pharmacy_add_doctor',
						path: 'add',
						component: PharmacyAddDoctor,
						meta: {
							auth: true,
							titleIcon: 'bx bx-plus-circle',
							title: 'Add Prescriber - RX Prescribers',
							subtitle: 'Create a new prescriber record information in your platform by filling up the form below.'
						}
					},
					{
						name: 'pharmacy_edit_doctor',
						path: ':id/edit',
						component: PharmacyEditDoctor,
						meta: {
							auth: true,
							titleIcon: 'bx bxs-edit-alt',
							title: 'Edit Prescriber - RX Prescriber',
							subtitle: 'Edit prescriber information by filling up the given form below.'
						}
					},
					{
						name: 'pharmacy_doctor_rx_history',
						path: 'history',
						component: PharmacyDoctorInfo,
						meta: {
							auth: true,
							titleIcon: 'bx bxs-id-card',
							title: 'Prescriber RX History - RX Prescribers',
							subtitle: 'This page displays the information about a prescriber. The information of the prescriber is given below.'
						}
					},
					{
						name: 'pharmacy_doctor_admin_formulary',
						path: 'formulary',
						component: PharmacyDoctorFormulary,
						meta: {
							auth: true,
							titleIcon: 'bx bx-id-card',
							title: 'Prescriber RX Formulary - RX Prescribers',
							subtitle: 'This page displays the information about a prescriber. The information of the prescriber is given below.'
						}
					}
				]
			},
			{
				path: 'order',
				component: Base,
				meta: {
					auth: true,
					title: 'Pharmacy Orders - RX Orders'
				},
				children: [
					{
						name: 'pharmacy_order',
						path: '',
						component: PharmacyAllOrders,
						meta: {
							auth: true,
							title: 'Pharmacy Orders - RX Orders'
						}
					},
					{
						name: 'pharmacy_invoice',
						path: 'invoice',
						component: PharmacyAllInvoice,
						meta: {
							auth: true,
							title: 'Pharmacy Invoice - RX Orders'
						}
					},
					{
						name: 'pharmacy_new_order',
						path: 'new',
						component: PharmacyAddPatient,
						meta: {
							auth: true,
							title: 'Pharmacy Orders - RX Orders'
						}
					}
				]
			},
			{
				name: 'order_duplicates',
				path: 'order-duplicates',
				component: PharmacyDuplicateOrders,
				meta: {
					auth: true,
					title: 'Pharmacy Duplicate Orders - RX Orders'
				}
			},
			{
				name: 'pharmacy_payments',
				path: 'payments',
				component: PharmacyPayment,
				meta: {
					auth: true,
					title: 'Payments - RX Orders'
				}
			},
			{
				name: 'pharmacy_shipments',
				path: 'shipments',
				component: PharmacyShipment,
				meta: {
					auth: true,
					title: 'Payments - RX Orders'
				}
			},
			{
				name: 'pharmacy_settings',
				path: 'settings',
				component: Base,
				meta: {
					auth: true,
					title: 'Pharmacy Settings - RX Orders'
				},
				children: [
					{
						name: 'pharmacy_stripe',
						path: 'stripe',
						component: PharmacySettings,
						meta: {
							auth: true,
							title: 'Pharmacy Settings - RX Orders'
						}
					}
				]
			}

		]
	},
	{
		path: '/prescriber',
		component: Base,
		meta: {
			auth: true,
			title: 'Orders - RX Orders'
		},
		children: [
			{
				name: 'prescriber_home',
				path: '',
				component: PrescriberHome,
				meta: {
					auth: true,
					title: 'Dashboard - RX Orders'
				}
			},
			{
				name: 'prescriber_rx_history',
				path: 'rxhistory',
				component: PrescriberRXHistory,
				meta: {
					auth: true,
					title: 'Dashboard - RX Orders'
				}
			},
			{
				name: 'prescriber_rx_shipments',
				path: 'shipments',
				component: () => import('./components/PrescriberDashboard/Shipments.vue'),
				meta: {
					auth: true,
					title: 'My Shipments'
				}
			},
			{
				path: 'patients',
				component: Base,
				meta: {
					auth: true,
					title: 'My Patients - RX Orders'
				},
				children: [
					{
						name: 'prescriber_rx_all_patients',
						path: '',
						component: () => import('./components/PrescriberDashboard/Patient/All.vue'),
						meta: {
							auth: true,
							title: 'My Patients - RX Orders'
						}
					},
					{
						name: 'prescriber_rx_patients_new',
						path: 'new',
						component: () => import('./components/PrescriberDashboard/Patient/New.vue'),
						meta: {
							auth: true,
							title: 'My Patients - RX Orders'
						}
					},
				]
			},
			{
				name: 'prescriber_rx_details',
				path: 'details/:id',
				component: PrescriberPatientDetail,
				meta: {
					auth: true,
					title: 'Patient Details - RX Orders'
				}
			},
			{
				name: 'prescriber_formulary',
				path: 'formulary',
				component: PrescriberFormulary,
				meta: {
					auth: true,
					title: 'Prescriber Formulary - RX Orders'
				}
			}
		]
	}

];

export const routes1 = [
	{
		path: '',
		name: 'home',
		component: Home,
		meta: {
			auth: true,
			title: 'Home - RX Orders'
		}
	},

	{
		path: '/register',
		name: 'register',
		component: Register,
		meta: {
			auth: false,
			title: 'Register - RX Orders'
		}
	},

	{
		path: '/login',
		name: 'login',
		component: Login,
		meta: {
			auth: false,
			title: 'Login - RX Orders'
		}
	},

	// {
	// 	path: '/checkout/:invoice',
	// 	name: 'checkout',
	// 	component: Checkout,
	// 	meta: {
	// 		auth: true,
	// 		title: 'Checkout - RX Orders'
	// 	}
	// },

	{
		path: '/complete/:id',
		name: 'completed',
		component: Payment,
		meta: {
			auth: true,
			title: 'Payment - RX Orders'
		}
	},

	{
		path: '/users/:id/edit',
		name: 'profile',
		component: EditProfile,
		meta: {
			auth: true,
			title: 'Payment - RX Orders'
		}
	},

	{
		path: '/invoices',
		name: 'invoices',
		component: Invoices,
		meta: {
			auth: true,
			title: 'My Invoices - RX Orders'
		}
	},

	{
		path: '/receipts',
		name: 'receipts',
		component: Receipts,
		meta: {
			auth: true,
			title: 'My Receipts - RX Orders'
		}
	},

	{
		path: '/payments',
		name: 'payments',
		component: Payments,
		meta: {
			auth: true,
			title: 'My Payments - RX Orders'
		}
	},

	{
		path: '/admin',
		component: Base,
		children: [
			{
				name: 'admin',
				path: '',
				component: Home,
				meta: {
					auth: true,
					title: 'Dashboard - RX Orders'
				}
			},
			{
				name: 'settings',
				path: 'settings',
				component: Settings,
				meta: {
					auth: true,
					title: 'App Settings - RX Orders'
				}
			},
			{
				name: 'export',
				path: 'export',
				component: Export,
				meta: {
					auth: true,
					title: 'Export Records - RX Orders'
				}
			},
			{
				path: 'users',
				component: Base,
				meta: {
					auth: true,
					title: 'Users - RX Orders'
				},
				children: [
					{
						name: 'allusers',
						path: '',
						component: AllUsers,
						meta: {
							auth: true,
							title: 'Users - RX Orders'
						}
					},
					{
						name: 'userimport',
						path: 'import',
						component: ImportUsers,
						meta: {
							auth: true,
							title: 'Import Users - RX Orders'
						}
					},
					{
						name: 'adduser',
						path: 'add',
						component: AddUser,
						meta: {
							auth: true,
							title: 'Add User - RX Orders'
						}
					},
					{
						name: 'edituser',
						path: ':id/edit',
						component: EditUser,
						meta: {
							auth: true,
							title: 'Edit User - RX Orders'
						}
					}
				]
			},
			{
				path: 'payments',
				component: Base,
				meta: {
					auth: true,
					title: 'Payments - RX Orders'
				},
				children: [
					// {
					// 	name: 'allpayments',
					// 	path: '',
					// 	component: AllPayments,
					// 	meta: {
					// 		auth: true,
					// 		title: 'Payments - RX Orders'
					// 	}
					// },
					{
						name: 'pendingpayments',
						path: 'pending',
						component: PendingPayments,
						meta: {
							auth: true,
							title: 'Pending Payments - RX Orders'
						}
					}
				]
			},
			{
				path: 'prescribers',
				component: Base,
				meta: {
					auth: true,
					title: 'Prescribers - RX Orders'
				},
				children: [
					{
						name: 'allprescribers',
						path: '',
						component: AllPrescribers,
						meta: {
							auth: true,
							title: 'Prescribers - RX Orders'
						}
					},
					{
						name: 'prescriberimport',
						path: 'import',
						component: ImportPrescribers,
						meta: {
							auth: true,
							title: 'Import Prescribers - RX Orders'
						}
					},
					{
						name: 'addprescriber',
						path: 'add',
						component: AddPrescriber,
						meta: {
							auth: true,
							title: 'Add Prescriber - RX Orders'
						}
					},
					{
						name: 'editprescriber',
						path: ':id/edit',
						component: EditPrescriber,
						meta: {
							auth: true,
							title: 'Edit Prescriber - RX Orders'
						}
					},
					{
						name: 'prescriberRXHistory',
						path: 'history',
						component: AdminPrescriberHistory,
						meta: {
							auth: true,
							title: 'Prescriber RX History - RX Orders'
						}
					},
					{
						name: 'prescriberAdminFormulary',
						path: 'formulary',
						component: AdminPrescriberFormulary,
						meta: {
							auth: true,
							title: 'Prescriber RX History - RX Orders'
						}
					}
				]
			},
			{
				path: 'orders',
				component: Base,
				meta: {
					auth: true,
					title: 'Orders - RX Orders'
				},
				children: [
					{
						name: 'allorders',
						path: '',
						component: AllOrders,
						meta: {
							auth: true,
							title: 'Orders - RX Orders'
						}
					},
					{
						name: 'addorder',
						path: 'add',
						component: AddOrder,
						meta: {
							auth: true,
							title: 'Add Order - RX Orders'
						}
					},
					{
						name: 'editorder',
						path: ':id/edit',
						component: EditOrder,
						meta: {
							auth: true,
							title: 'Edit Order - RX Orders'
						}
					},
					{
						name: 'orderDetail',
						path: 'orderDetail',
						component: OrderDetail,
						meta: {
							auth: true,
							title: 'Details- RX Orders'
						}
					}
				]
			},
			{
				path: 'pioneer',
				name: 'pioneer',
				component: Pioneer,
				meta: {
					auth: true,
					title: 'Pioneer'
				}
			},
			{
				path: 'intakeq',
				name: 'intakeq',
				component: IntakeQ,
				meta: {
					auth: true,
					title: 'Intakeq'
				}
			},
			{
				path: 'formulary',
				name: 'formulary',
				component: Base,
				children: [
					{
						name: 'ProviderHome',
						path: '/',
						component: Formulary,
						meta: {
							auth: true,
							title: 'Formulary - RX Orders'
						}
					},
					{
						name: 'formularyPrescribers',
						path: '/prescribers',
						component: FormularyPrescriber,
						meta: {
							auth: true,
							title: 'Formulary Prescribers - RX Orders'
						}
					},
				]
			},
			{
				path: 'rxdata',
				component: Base,
				meta: {
					auth: true,
					title: 'RX Data'
				},
				children: [
					{
						name: 'allrxdata',
						path: '',
						component: RXdata,
						meta: {
							auth: true,
							title: 'Orders - RX Orders'
						}
					}
				]
			},
			{
				path: 'invoices',
				component: Base,
				meta: {
					auth: true,
					title: 'Invoices - RX Orders'
				},
				children: [
					{
						name: 'allinvoices',
						path: '',
						component: AllInvoices,
						meta: {
							auth: true,
							title: 'Invoices - RX Orders'
						}
					},
					{
						name: 'refreshinvoices',
						path: 'refresh',
						component: RefreshInvoices,
						meta: {
							auth: true,
							title: 'Refresh Invoices - RX Orders'
						}
					},
					{
						name: 'editinvoice',
						path: ':id/edit',
						component: EditInvoice,
						meta: {
							auth: true,
							title: 'Edit Invoice - RX Orders'
						}
					},
					{
						name: 'viewinvoice',
						path: '/invoices/:id',
						component: Invoice,
						meta: {
							auth: true,
							title: 'View Invoice - RX Orders'
						}
					}
				]
			},
			{
				path: 'items',
				component: Base,
				meta: {
					auth: true,
					title: 'Items - RX Orders'
				},
				children: [
					{
						name: 'allitems',
						path: '',
						component: AllItems,
						meta: {
							auth: true,
							title: 'Items - RX Orders'
						}
					},
					{
						name: 'edititem',
						path: ':id/edit',
						component: EditItem,
						meta: {
							auth: true,
							title: 'Edit Item - RX Orders'
						}
					},
					{
						name: 'additem',
						path: 'add',
						component: AddItem,
						meta: {
							auth: true,
							title: 'Add Item - RX Orders'
						}
					},
					{
						name: 'importitems',
						path: 'import',
						component: ImportItems,
						meta: {
							auth: true,
							title: 'Import Items - RX Orders'
						}
					}
				]
			},
			{
				path: 'receipts',
				component: Base,
				meta: {
					auth: true,
					title: 'Receipts - RX Orders'
				},
				children: [
					{
						name: 'allreceipts',
						path: '',
						component: AllReceipts,
						meta: {
							auth: true,
							title: 'Receipts - RX Orders'
						}
					},
					{
						name: 'viewreceipt',
						path: '/receipts/:invoice',
						component: Receipt,
						meta: {
							auth: true,
							title: 'View Receipt - RX Orders'
						}
					}
				]
			},
			{
				path: 'provider',
				component: Base,
				meta: {
					auth: true,
					title: 'Providers'
				},
				children: [
					{
						name: 'allproviders',
						path: '',
						component: Provider,
						meta: {
							auth: true,
							title: 'Providers - RX Orders'
						}
					},
					{
						name: 'addprovider',
						path: 'add',
						component: NewProvider,
						meta: {
							auth: true,
							title: 'Providers - RX Orders'
						}
					},
					{
						name: 'editprovider',
						path: 'edit/:provider',
						component: EditProvider,
						meta: {
							auth: true,
							title: 'Providers - RX Orders'
						}
					},
					{
						name: 'providerRXHistory',
						path: 'history',
						component: AdminProviderHistory,
						meta: {
							auth: true,
							title: 'Provider RX History - RX Orders'
						}
					}
				]
			}
		]
	},

	{
		path: '/provider',
		component: Base,
		children: [
			{
				name: 'ProviderHomeDashboard',
				path: '/',
				component: ProviderHome,
				meta: {
					auth: true,
					title: 'Dashboard - RX Orders'
				}
			},
			{
				name: 'RXHistory',
				path: 'rxhistory',
				component: RXHistory,
				meta: {
					auth: true,
					title: 'Dashboard - RX Orders'
				}
			},
			{
				name: 'rxDetails',
				path: 'details/:id',
				component: PatientDetail,
				meta: {
					auth: true,
					title: 'Patient Details - RX Orders'
				}
			},
			{
				name: 'rxDetails',
				path: 'details',
				component: PatientDetail,
				meta: {
					auth: true,
					title: 'Patient Details - RX Orders'
				}
			}

		]
	},

	{
		path: '/prescriber',
		component: Base,
		children: [
			{
				name: 'PrescriberHome',
				path: '/',
				component: PrescriberHome,
				meta: {
					auth: true,
					title: 'Dashboard - RX Orders'
				}
			},
			{
				name: 'PrescriberRXHistory',
				path: 'rxhistory',
				component: PrescriberRXHistory,
				meta: {
					auth: true,
					title: 'Dashboard - RX Orders'
				}
			},
			{
				name: 'PrescriberRxDetails',
				path: 'details/:id',
				component: PrescriberPatientDetail,
				meta: {
					auth: true,
					title: 'Patient Details - RX Orders'
				}
			},
			{
				name: 'PrescriberFormulary',
				path: 'formulary',
				component: PrescriberFormulary,
				meta: {
					auth: true,
					title: 'Prescriber Formulary - RX Orders'
				}
			}

		]
	}

];
