/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * Importing Vuex
 * para acessar propriedades pelo vue: $store.state.foo
 */
import Vuex from 'Vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        teste:"teste vuex",
        item: {},
        transacao: {status: '', mensagem: ''}
    }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('home-component', require('./components/HomeComponent.vue').default);
Vue.component('marcas-component', require('./components/MarcasComponent.vue').default);
Vue.component('input-container-component', require('./components/InputContainerComponent.vue').default);
Vue.component('table-component', require('./components/TableComponent.vue').default);
Vue.component('card-component', require('./components/CardComponent.vue').default);
Vue.component('alert-component', require('./components/AlertComponent.vue').default);
Vue.component('paginate-component', require('./components/PaginateComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});
