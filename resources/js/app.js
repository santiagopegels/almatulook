/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.$ = window.jQuery = require('jquery');
require('./bootstrap');
require('@coreui/coreui');

window.axios = require('axios');

window.Vue = require('vue')

import store from './store/index';
import Paginate from 'vuejs-paginate';
import 'es6-promise/auto';
import Vuex from 'vuex';
import Vuelidate from 'vuelidate';
import Toasted from 'vue-toasted';
import VueDayjs from 'vue-dayjs-plugin';

Vue.config.baseurl = process.env.MIX_APP_URL;
console.log('MIX_APP_URL', process.env.MIX_APP_URL);

Vue.component('paginate', Paginate);
Vue.use(Vuex);
Vue.use(Toasted);
Vue.use(VueDayjs);
Vue.use(Vuelidate);

// register the toast with the custom message

Vue.toasted.register('ToastedError',
    (payload) => {
        return payload.message;
    }, {
        type: 'error',
        theme: "bubble",
        position: "top-right",
        duration: 4000,
        fullWidth: false,
        closeOnSwipe: true,
        singleton: true
    }
);
Vue.toasted.register('ToastedSuccess',
    (payload) => {
        return payload.message;
    }, {
        type: 'success',
        theme: "bubble",
        position: "top-right",
        duration: 4000,
        fullWidth: false,
        closeOnSwipe: true,
        singleton: true,
        icon: {
            name: '✓',
        }
    }
);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * models
 */

// users
Vue.component('users-form', require('./components/models/users/form.vue').default);
Vue.component('users-list', require('./components/models/users/lists.vue').default);
Vue.component('users-index', require('./components/models/users/index.vue').default);
Vue.component('users-filters', require('./components/models/users/filters.vue').default);

// roles
Vue.component('roles-form', require('./components/models/roles/form.vue').default);
Vue.component('roles-list', require('./components/models/roles/lists.vue').default);
Vue.component('roles-index', require('./components/models/roles/index.vue').default);
Vue.component('roles-checkbox', require('./components/models/roles/checkbox.vue').default);

// permissions
Vue.component('permissions-form', require('./components/models/permissions/form.vue').default);
Vue.component('permissions-list', require('./components/models/permissions/lists.vue').default);
Vue.component('permissions-index', require('./components/models/permissions/index.vue').default);
Vue.component('permissions-checkbox', require('./components/models/permissions/checkbox.vue').default);
Vue.component('permissions-module', require('./components/models/permissions/module.vue').default);

// attributes
Vue.component('attributes-form', require('./components/models/attributes/form.vue').default);
Vue.component('attributes-list', require('./components/models/attributes/lists.vue').default);
Vue.component('attributes-index', require('./components/models/attributes/index.vue').default);
Vue.component('attributes-filters', require('./components/models/attributes/filters.vue').default);

// values
Vue.component('values-form', require('./components/models/values/form.vue').default);
Vue.component('values-list', require('./components/models/values/lists.vue').default);
Vue.component('values-index', require('./components/models/values/index.vue').default);
Vue.component('values-filters', require('./components/models/values/filters.vue').default);
Vue.component('values-checkbox', require('./components/models/values/checkbox.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.directive("capitalize", {
    update: function (el) {
        el.value = el.value.charAt(0).toUpperCase() + el.value.slice(1)
    }
});

Vue.directive("lowercase", {
    update: function (el) {
        el.value = el.value.toLowerCase()
    }
});

Vue.directive("hyphenate", {
    update: function (el) {
        el.value = el.value.replace(/[^a-zA-Z0-9]/g, "-")
    }
});

const app = new Vue({
    el: '#app',
    store
});
