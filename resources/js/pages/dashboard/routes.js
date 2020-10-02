import AdminDashboardRoutes from './admin/routes.js';
import PatientDashboardRoutes from './patient/routes.js';


let routes = [
	...AdminDashboardRoutes,
	...PatientDashboardRoutes
];

export default routes;