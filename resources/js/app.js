/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 */
const files = require.context('./components/Common/', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import App from './app.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import 'es6-promise/auto';
import VueAuth from '@websanova/vue-auth';
import auth from './auth';
import VueSignaturePad from 'vue-signature-pad';
import VueHtmlToPaper from "vue-html-to-paper";
import { routes } from './routes';
import Pagination from 'laravel-vue-pagination';

import CustomDataTable from './components/data-table/data-table.vue';

import VueNumber from 'vue-number-animation';

Vue.use(VueNumber);

Vue.component('custom-data-table', CustomDataTable);


const router = new VueRouter({
	history: true,
	mode: 'history',
	routes,
});

Vue.router = router;
Vue.use(VueRouter);

Vue.use(VueSignaturePad);

Vue.use(VueAxios, axios);
Vue.use(VueAuth, auth);

Vue.use(VueHtmlToPaper, {
	name: "_blank",
	specs: ["fullscreen=yes", "titlebar=no", "scrollbars=yes"],
	styles: [
		"/css/main.css"
	]
});

router.beforeEach((to, from, next) => {
	const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);
	if (nearestWithTitle) {
		document.title = nearestWithTitle.meta.title;
	}

	next();
});

const app = new Vue({
	el: '#app',
	router: router,
	render: h => h(App),
});