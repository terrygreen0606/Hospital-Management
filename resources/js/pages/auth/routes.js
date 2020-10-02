import Login from './login/login.vue';
import Register from './register/register.vue';

let routes = [
	{
		path: '/login',
		name: 'login',
		component: Login,
		meta: {
			auth: false,
			title: 'Login - RX Orders'
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
];

export default routes;