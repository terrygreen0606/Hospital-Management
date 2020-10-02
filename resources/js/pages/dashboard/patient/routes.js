import Base from '../../../components/Common/Base.vue';

import DashboardHome from './home/home.vue';

import PatientOrders from './orders/orders.vue';

import Checkout from './checkout/checkout.vue';

import PatientInvoices from './invoices/invoices.vue';
import PatientInvoice from './invoices/_invoice-info.vue';

import PatientPayments from './payments/payments.vue';

import PatientEducation from './education/education.vue';
 
let routes = [
	{
		path: '/checkout/:invoice',
		name: 'checkout',
		component: Checkout,
		meta: {
			auth: true,
			titleIcon: 'bx bx-basket',
			title: 'Checkout Page',
			subtitle: 'Finalize your orders by managing your orders and payments below.'
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
				name: 'patient_dashboard',
				path: '',
				component: DashboardHome,
				meta: {
					auth: true,
					titleIcon: 'bx bx-pie-chart-alt',
					title: 'Patient Dashboard',
					subtitle: 'Summarizes every data the current user has on this page.'
				}
			},
			{
				name: 'patient_invoices',
				path: 'invoices',
				component: PatientInvoices,
				meta: {
					auth: true,
					titleIcon: 'bx bx-receipt',
					title: 'Patient Invoices',
					subtitle: 'Finalize your orders by managing your invoices and payments below.'
				}
			},
			{
				name: 'patient_orders',
				path: 'orders',
				component: PatientOrders,
				meta: {
					auth: true,
					titleIcon: 'bx bx-shopping-bag',
					title: 'Patient Orders - RX Orders',
					subtitle: 'Review your ordered items below.'
				}
			},
			{
				name: 'patient_payments',
				path: 'payments',
				component: PatientPayments,
				meta: {
					auth: true,
					titleIcon: 'bx bx-receipt',
					title: 'Patient Payments',
					subtitle: 'Review your payments on this page.'
				}
			},
			{
				name: 'patient_education',
				path: 'education',
				component: PatientEducation,
				meta: {
					auth: true,
					titleIcon: 'bx bx-book',
					title: 'Patient Learning',
					subtitle: 'Learn the items you have just purchased recently on this page.'
				}
			},
			{
				name: 'patient_view_invoice',
				path: '/invoice_details/:id',
				component: PatientInvoice,
				meta: {
					auth: true,
					titleIcon: 'bx bx-receipt',
					title: 'View Receipt - RX Orders',
					subtitle: 'Review receipt of purchased items base on receipt ID.'
				}
			},

			// {
			// 	path: '/checkout/:invoice',
			// 	name: 'checkout',
			// 	component: CheckoutPage,
			// 	meta: {
			// 		auth: true,
			// 		title: 'Checkout - RX Orders'
			// 	}
			// },
		]
	}
];

export default routes;

