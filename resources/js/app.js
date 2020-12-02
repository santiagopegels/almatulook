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
import VueCurrencyInput from 'vue-currency-input'
import vSelect from 'vue-select'
import {router} from './router/router'
import VueSweetalert2 from 'vue-sweetalert2';
import Antd from 'ant-design-vue';
import Transitions from 'vue2-transitions'


Vue.config.baseurl = process.env.MIX_APP_URL;
console.log('MIX_APP_URL', process.env.MIX_APP_URL);

Vue.component('paginate', Paginate);
Vue.component('v-select', vSelect)
Vue.use(Vuex);
Vue.use(Toasted);
Vue.use(VueDayjs);
Vue.use(Vuelidate);
Vue.use(VueSweetalert2);
Vue.use(Antd);
Vue.use(Transitions)


const pluginCurrencyInputOptions = {
    globalOptions: {currency: {prefix: '$'}, locale: 'nl'}
}
Vue.use(VueCurrencyInput, pluginCurrencyInputOptions);

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
    },
    {
        type: 'success',
        theme: "bubble",
        position: "top-right",
        duration: 4000,
        fullWidth: false,
        closeOnSwipe: true,
        singleton: true,
        icon: {
            name: '✓',
        },
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
 * forms
 */

Vue.component('upload-images', require('./components/forms/upload-images.vue').default);

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
Vue.component('attributes-checkbox', require('./components/models/attributes/checkbox.vue').default);

// values
Vue.component('values-form', require('./components/models/values/form.vue').default);
Vue.component('values-list', require('./components/models/values/lists.vue').default);
Vue.component('values-index', require('./components/models/values/index.vue').default);
Vue.component('values-filters', require('./components/models/values/filters.vue').default);
Vue.component('values-checkbox', require('./components/models/values/checkbox.vue').default);

// categories
Vue.component('categories-form', require('./components/models/categories/form.vue').default);
Vue.component('categories-list', require('./components/models/categories/lists.vue').default);
Vue.component('categories-index', require('./components/models/categories/index.vue').default);
Vue.component('categories-filters', require('./components/models/categories/filters.vue').default);
Vue.component('categories-treeview', require('./components/models/categories/treeview.vue').default);
Vue.component('categories-subcategories', require('./components/models/categories/subcategoriesInput.vue').default);
Vue.component('categories-checkbox-attributes', require('./components/models/categories/checkboxAttributes.vue').default);
Vue.component('categories-select', require('./components/models/categories/select.vue').default);

// parameters
Vue.component('parameters-list', require('./components/models/parameters/lists.vue').default);
Vue.component('parameters-index', require('./components/models/parameters/index.vue').default);
Vue.component('parameters-filters', require('./components/models/parameters/filters.vue').default);
Vue.component('parameters-form', require('./components/models/parameters/form.vue').default);

// products
Vue.component('products-list', require('./components/models/products/lists.vue').default);
Vue.component('products-index', require('./components/models/products/index.vue').default);
Vue.component('products-filters', require('./components/models/products/filters.vue').default);
Vue.component('products-card', require('./components/models/products/card.vue').default);


// new products
Vue.component('new-product-index', require('./components/models/products/newProduct/index.vue').default);
Vue.component('new-product-form', require('./components/models/products/newProduct/form.vue').default);
Vue.component('new-product-attributes', require('./components/models/products/newProduct/attributesProduct.vue').default);

// purchase
Vue.component('purchases-list', require('./components/models/purchases/lists.vue').default);
Vue.component('purchases-index', require('./components/models/purchases/index.vue').default);


//PUBLIC
Vue.component('home', require('./components/public/home.vue').default);
Vue.component('main-content', require('./components/public/mainContent.vue').default);

// layout
Vue.component('header-layout', require('./components/public/layouts/header.vue').default);
Vue.component('footer-layout', require('./components/public/layouts/footer.vue').default);
Vue.component('cart-drawer', require('./components/public/layouts/cartDrawer.vue').default);
Vue.component('home-product-card', require('./components/public/products/productCard.vue').default);
Vue.component('header-menu', require('./components/public/layouts/headerMenu.vue').default);
Vue.component('sider-layout', require('./components/public/layouts/sider.vue').default);
Vue.component('sider-drawer', require('./components/public/layouts/siderDrawer.vue').default);
Vue.component('sider-fixed', require('./components/public/layouts/siderFixed.vue').default);
Vue.component('filter-menu', require('./components/public/layouts/filterMenu.vue').default);


//Cart Drawer
Vue.component('cart-drawer-header', require('./components/public/cartDrawer/header.vue').default);
Vue.component('cart-drawer-content', require('./components/public/cartDrawer/content.vue').default);
Vue.component('cart-drawer-footer', require('./components/public/cartDrawer/footer.vue').default);
Vue.component('cart-drawer-product', require('./components/public/cartDrawer/productRow.vue').default);

//Product
Vue.component('product-index', require('./components/public/products/index.vue').default);
Vue.component('product-images-carousel', require('./components/public/products/imagesProduct.vue').default);
Vue.component('product-attribute-select', require('./components/public/products/attributeSelect.vue').default);

//Purchase
Vue.component('purchase-index', require('./components/public/purchases/index.vue').default);
Vue.component('first-step', require('./components/public/purchases/wizardSteps/firstStep.vue').default);
Vue.component('second-step', require('./components/public/purchases/wizardSteps/secondStep.vue').default);
Vue.component('third-step', require('./components/public/purchases/wizardSteps/thirdStep.vue').default);
Vue.component('summary-purchase', require('./components/public/purchases/summary.vue').default);
Vue.component('summary-purchase-product', require('./components/public/purchases/productSummaryRow.vue').default);
Vue.component('summary-purchase-step-guest-form', require('./components/public/purchases/wizardSteps/guestForm.vue').default);
Vue.component('summary-purchase-step-login-form', require('./components/public/purchases/wizardSteps/loginForm.vue').default);

//Cart Resume
Vue.component('cart-resume-index', require('./components/public/cartResume/index.vue').default);
Vue.component('cart-resume-content', require('./components/public/cartResume/content.vue').default);
Vue.component('cart-resume-product-row', require('./components/public/cartResume/productRow.vue').default)
Vue.component('cart-resume-summary', require('./components/public/cartResume/summary.vue').default);


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

Vue.filter('currency', function (value) {
    var formatter = new Intl.NumberFormat('es-AR', {
        style: 'currency',
        currency: 'ARS',
        minimumFractionDigits: 0
    });
    return formatter.format(value);
});

const app = new Vue({
    el: '#app',
    router,
    store
});
