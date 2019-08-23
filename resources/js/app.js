/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.compoent(key.split('/').pop().split('.')[0], files(key).default));
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'
import Vuetify from 'vuetify'
import Vuelidate from 'vuelidate'
import Vue from 'vue'
import { TiptapVuetifyPlugin } from 'tiptap-vuetify'
import VueFormWizard from 'vue-form-wizard'
Vue.use(VueFormWizard)
Vue.use(Vuelidate)
Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(TiptapVuetifyPlugin, {
  // optional, default to 'md' (default vuetify icons before v2.0.0)
  iconsGroup: 'md'
})
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
let routes = [{
    path: '/home',
    component: require('./components/Dashboard.vue').default
}, {
    path: '/paket-tour',
    component: require('./components/paketTour.vue').default
}, {
    path: '/booking-list',
    meta: {
        breadcrumb: 'Booking List',
    },
    component: require('./components/BookingList/bookingList.vue').default
}, {
    path: '/group-menu',
    name: 'Group Menu',
    meta: {
        breadcrumb: 'Group Menu',
    },
    component: require('./components/GroupMenu/groupMenu.vue').default
}, {
    path: '/menu-list',
    name: 'Menu List',
    meta: {
        breadcrumb: 'Menu List',
    },
    component: require('./components/MenuList/menuList.vue').default
}, {
    path: '/role',
    name: 'Role',
    meta: {
        breadcrumb: 'Role',
    },
    component: require('./components/Role/Role.vue').default
}, {
    path: '/privilege',
    name: 'Privilege',
    meta: {
        breadcrumb: 'Privilege',
    },
    component: require('./components/Privilege/Privilege.vue').default
}, {
    path: '/administrator-user',
    name: 'Administrator User',
    meta: {
        breadcrumb: 'Administrator User',
    },
    component: require('./components/AdministratorUser/AdministratorUser.vue').default
}, {
    path: '/agent-user',
    name: 'Agent User',
    meta: {
        breadcrumb: 'Agent User',
    },
    component: require('./components/AgentUser/AgentUser.vue').default
},{
    path: '/destination',
    name: 'Destination',
    meta: {
        breadcrumb: 'Destination',
    },
    component: require('./components/Destination/destination.vue').default
}, {
    path: '/additional',
    name: 'Additional',
    meta: {
        breadcrumb: 'additional',
    },
    component: require('./components/Additional/additional.vue').default
}, {
    path: '/itinerary',
    name: 'Itinerary',
    meta: {
        breadcrumb: 'itinerary',
    },
    component: require('./components/Itinerary/Itinerary.vue').default
}, {
    path: '/itinerary/create',
    name: 'Create Itinerary',
    meta: {
        breadcrumb: 'Create Itinerary',
    },
    component: require('./components/Itinerary/CreateItinerary.vue').default
}, {
    path: '/itinerary/detail/:id/:dt',
    name: 'Detail Itinerary',
    meta: {
        breadcrumb: 'Detail Itinerary',
    },
    component: require('./components/Itinerary/DetailItinerary.vue').default
}, {
    path: '/tour-leader',
    component: require('./components/TourLeader/tourLeader.vue').default
}, {
    path: '/income-report',
    component: require('./components/Finance/incomeReport.vue').default
}, {
    path: '/income-statement',
    component: require('./components/Finance/incomeStatement.vue').default
}, {
    path: '/customer-statistic',
    component: require('./components/Report/customerStatistic.vue').default
}, {
    path: '/sales-statistic',
    component: require('./components/Report/salesStatistic.vue').default
}, {
    path: '/customer-report',
    component: require('./components/Report/customerReport.vue').default
}, {
    path: '/sales-report',
    component: require('./components/Report/salesReport.vue').default
}, {
    path: '/payment-report',
    component: require('./components/Report/paymentReport.vue').default
}, ]

const router = new VueRouter({
  mode:'history',
  routes // short for `routes: routes`
})


Vue.prototype.$globals = 'tes';
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('datatable-component', require('./components/Datatable.vue').default);
Vue.component('filter-bar-component', require('./components/FilterBar.vue').default);

let app = new Vue({
    el: '#app',
    router,
    mounted(){
        let accounting = document.createElement('script')
        accounting.setAttribute('src', '/js/accounting/accounting.js')
        document.head.appendChild(accounting)
    },
});
