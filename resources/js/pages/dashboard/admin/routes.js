import Base from '../../../components/Common/Base.vue';

import Home from './home/home.vue';
import RxData from './home/rxdata.vue';

import Formulary from './formulary/formulary.vue';
import FormularyPrescriber from './formulary/formularyPrescriber.vue';

import AllPatients from './patients/patients.vue';
import PatientForm from './patients/_add-patient.vue';

import AllPharmacies from './pharmacies/pharmacies.vue';
import PharmacyForm from './pharmacies/_add-pharmacy.vue'; 
import EditPharmacy from './pharmacies/_edit-pharmacy.vue';
import PharmacyInfo from './pharmacies/_info-pharmacy.vue';

import DuplicateOrders from './order_duplicates/index.vue';

import AllDoctors from './doctors/doctors.vue';
import AddDoctor from './doctors/_add-doctor.vue';
import EditDoctor from './doctors/_edit-doctor.vue';
import ImportDoctors from './doctors/_import-doctors.vue';
import DoctorInfo from './doctors/_info-doctor.vue';
import DoctorFormulary from './doctors/_formulary-doctor.vue';

import AllOrders from './orders/orders.vue';
import OrderInformation from './orders/_details-order.vue';
import EditOrder from './orders/_edit-order.vue';
import AllShipments from './orders/shipments.vue';
import OrderArchives from './orders/archives.vue';

import AllInvoices from './invoices/invoices.vue';
import InvoiceInfo from './invoices/_info-invoice.vue';

import AllPayments from './payments/payments.vue';

let routes = [{
		path: '/admin',
		meta: { title: 'Administrator Dashboard', titleIcon: 'bx bxs-pie-chart-alt-2' },
		component: Base,
		children: [
			{
				name: 'admin_dashboard',
				path: '',
				component: Home,
				meta: {
					auth: true,
					title: 'Dashboard - RX Admin'
				}
			},
			{
				name: 'admin_rx_data',
				path: 'rxdata',
				component: RxData,
				meta: {
					auth: true,
					titleIcon: 'bx bx-film',
					title: 'Patient Education',
					subtitle: 'View and Manage patient education videos'
				}
			},
			{
				path: 'formulary',
				component: Base,
				children: [
					{
						name: 'formulary',
						path: '',
						component: Formulary,
						meta: {
							auth: true,
							title: 'Formulary - RX Orders'
						}
					},
					{
						name: 'adminFormularyPrescribers',
						path: 'prescribers',
						component: FormularyPrescriber,
						meta: {
							auth: true,
							title: 'Formulary Prescribers - RX Orders'
						}
					},
				]
			},
			{
				path: 'patient',
				component: Base,
				children: [
					{
						name: 'all_patients',
						path: '',
						component: AllPatients,
						meta: {
							auth: true,
							titleIcon: 'bx bx-list-ul',
							title: 'All Patient - RX Patients',
							subtitle: 'Manage the patients that are currently registered in your platform on this page.'
						}
					},
					{
						name: 'add_patients',
						path: 'add',
						component: PatientForm,
						meta: {
							auth: true,
							titleIcon: 'bx bx-plus',
							title: 'Add Patient - RX Patients',
							subtitle: 'Create a new patient record in your platform by filling up the form below.'
						}
					}
				]
			},
			{
				path: 'pharmacy',
				component: Base,
				meta: {
					auth: true,
					title: 'Pharmacy'
				},
				children: [
					{
						name: 'all_pharmacy',
						path: '',
						component: AllPharmacies,
						meta: {
							auth: true,
							titleIcon: 'bx bx-store',
							title: 'Pharmacy - RX Pharmacy',
							subtitle: 'Manage the pharmacies that are currently registered in your platform on this page.'
						}
					},
					{
						name: 'add_pharmacy',
						path: 'add',
						component: PharmacyForm,
						meta: {
							auth: true,
							titleIcon: 'bx bx-plus-circle',
							title: 'Pharmacy - RX Pharmacy',
							subtitle: 'Create a new pharmacy record information in your platform by filling up the form below.'
						}
					},
					{
						name: 'edit_pharmacy',
						path: 'edit/:pharmacy',
						component: EditPharmacy,
						meta: {
							auth: true,
							titleIcon: 'bx bxs-edit-alt',
							title: 'Edit Pharmacy - RX Pharmacy',
							subtitle: 'Edit pharmacy information by filling up the given form below.'
						}
					},
					{
						name: 'pharmacy_rx_history',
						path: 'history/:id',
						component: PharmacyInfo,
						meta: {
							auth: true,
							titleIcon: 'bx bx-line-chart',
							title: 'Pharmacy Information - RX Pharmacy',
							subtitle: 'Review pharmacy information based on the given information below.'
						}
					}
				]
			},
			{
				path: 'doctor',
				component: Base,
				meta: {
					auth: true,
					title: 'Prescribers - RX Prescribers'
				},
				children: [
					{
						name: 'all_doctors',
						path: '',
						component: AllDoctors,
						meta: {
							auth: true,
							titleIcon: 'bx bx-ambulance',
							title: 'Prescribers - RX Prescribers',
							subtitle: 'Manage the prescriber that are currently registered in your platform on this page.'
						}
					},
					{
						name: 'doctor_import',
						path: 'import',
						component: ImportDoctors,
						meta: {
							auth: true,
							titleIcon: 'bx bx-import',
							title: 'Import Prescribers - RX Prescribers',
							subtitle: 'Import prescribers from a pdf below so that it can be saved in the database.'
						}
					},
					{
						name: 'add_doctor',
						path: 'add',
						component: AddDoctor,
						meta: {
							auth: true,
							titleIcon: 'bx bx-plus-circle',
							title: 'Add Prescribers - RX Prescriberss',
							subtitle: 'Create a new prescriber record information in your platform by filling up the form below.'
						}
					},
					{
						name: 'edit_doctor',
						path: ':id/edit',
						component: EditDoctor,
						meta: {
							auth: true,
							titleIcon: 'bx bxs-edit-alt',
							title: 'Edit Prescribers - RX Prescribers',
							subtitle: 'Edit prescriber information by filling up the given form below.'
						}
					},
					{
						name: 'doctor_rx_history',
						path: 'history',
						component: DoctorInfo,
						meta: {
							auth: true,
							titleIcon: 'bx bxs-id-card',
							title: 'Prescriber RX History - RX Prescribers',
							subtitle: 'This page displays the information about a prescriber. The information of the prescriber is given below.'
						}
					},
					{
						name: 'doctor_admin_formulary',
						path: 'formulary',
						component: DoctorFormulary,
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
					title: 'Orders - RX Orders'
				},
				children: [
					{
						name: 'all_orders',
						path: '',
						component: AllOrders,
						meta: {
							auth: true,
							titleIcon: 'bx bx-table',
							title: 'Orders - RX Orders',
							subtitle: 'Manage order information in your platform on this page.'
						}
					},
					{
						name: 'order_information',
						path: 'details/:order_id/:user_id',
						component: OrderInformation,
						meta: {
							auth: true,
							titleIcon: 'bx bx-file',
							title: 'Order Information - RX Orders',
							subtitle: 'Review order information in your platform on this page.'
						}
					},
					{
						name: 'editorder',
						path: 'edit/:id',
						component: EditOrder,
						meta: {
							auth: true,
							titleIcon: 'bx bxs-edit-alt',
							title: 'Edit Order - RX Orders',
							subtitle: 'Edit order information in your platform on this page.'
						}
					},
				]
			},
			{
				name: 'all_duplicate_orders',
				path: 'order-duplicate',
				component: DuplicateOrders,
				meta: {
					auth: true,
					titleIcon: 'bx bx-table',
					title: 'Orders Duplicates - RX Orders',
					subtitle: 'List of orders that might duplicate/disrupt existing data.'
				}
			},
			{
				path: 'invoice',
				component: Base,
				meta: {
					auth: true,
					title: 'Orders - RX Orders'
				},
				children: [
					{
						name: 'all_invoice',
						path: '',
						component: AllInvoices,
						meta: {
							auth: true,
							titleIcon: 'bx bx-file',
							title: 'Invoices - RX Invoices',
							subtitle: 'Manage invoices that are saved in your platform on this page.'
						}
					},
					{
						name: 'view_invoice',
						path: '/details/:id',
						component: InvoiceInfo,
						meta: {
							auth: true,
							titleIcon: 'bx bxs-receipt',
							title: 'View Invoice - RX Invoices',
							subtitle: 'Review the invoice information of your customer on this page.'
						}
					},
					{
						name: 'all_payments',
						path: 'payments',
						component: AllPayments,
						meta: {
							auth: true,
							titleIcon: 'bx bx-file',
							title: 'Payments - RX Payments',
							subtitle: 'Manage payments that are saved in your platform on this page.'
						}
					}
				]
			},
			{
				name: 'all_shipments',
				path: 'shipments',
				component: AllShipments,
				meta: {
					auth: true,
					titleIcon: 'bx bx-file',
					title: 'RX Shipments',
					subtitle: 'Manage shipments that are saved in your platform on this page.'
				}
			},
			{
				name: 'archives',
				path: 'archives',
				component: Base,
				meta: {
					auth: true,
					title: 'Archives',
				},
				children: [
					{
						name: 'orders',
						path: 'orders',
						component: OrderArchives,
						meta: {
							auth: true,
							titleIcon: 'bx bx-archive',
							title: 'Order Archives',
							subtitle: 'Manage old orders.',
						},
					},
				],
			}
			// {
			// 	path: 'payments',
			// 	component: Base,
			// 	meta: {
			// 		auth: true,
			// 		title: 'Payments - RX Orders'
			// 	},
			// 	children: [
			// 		{
			// 			name: 'allpayments',
			// 			path: '',
			// 			component: AllPayments,
			// 			meta: {
			// 				auth: true,
			// 				title: 'Payments - RX Orders'
			// 			}
			// 		},
			// 		// {
			// 		// 	name: 'pendingpayments',
			// 		// 	path: 'pending',
			// 		// 	component: PendingPayments,
			// 		// 	meta: {
			// 		// 		auth: true,
			// 		// 		title: 'Pending Payments - RX Orders'
			// 		// 	}
			// 		// }
			// 	]
			// },
		]
	}];

	export default routes;