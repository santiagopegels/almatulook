/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.axios = require('axios');

window.Vue = require('vue')

import store from './store/index';
import Paginate from 'vuejs-paginate';
import 'es6-promise/auto';
import Vuex from 'vuex';
import Vuelidate from 'vuelidate';
import Toasted from 'vue-toasted';
import VueCurrencyInput from 'vue-currency-input'
import {router} from './router/router'
import Antd from 'ant-design-vue';
import Transitions from 'vue2-transitions';


Vue.config.baseurl = process.env.MIX_APP_URL;
console.log('MIX_APP_URL', process.env.MIX_APP_URL);

Vue.component('paginate', Paginate);
Vue.use(Vuex);
Vue.use(Toasted);
Vue.use(Vuelidate);
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

/**
 * forms
 */

Vue.component('upload-images', require('./components/forms/upload-images.vue').default);
Vue.component('previous-button', require('./components/public/purchases/wizardSteps/previousButton.vue').default);

/**
 * models
 */

//PUBLIC
Vue.component('home', require('./components/public/home.vue').default);
Vue.component('main-content', require('./components/public/mainContent.vue').default);

// layout
Vue.component('header-layout', require('./components/public/layouts/header.vue').default);
Vue.component('footer-layout', require('./components/public/layouts/footer.vue').default);
Vue.component('cart-drawer', require('./components/public/layouts/cartDrawer.vue').default);
Vue.component('home-product-card', require('./components/public/products/productCard.vue').default);
Vue.component('header-menu', require('./components/public/layouts/headerMenu.vue').default);
Vue.component('header-menu-item', require('./components/public/layouts/headerMenuItem.vue').default);
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
Vue.component('product-attribute-select-content', require('./components/public/products/attributeSelectContent.vue').default);
Vue.component('product-attribute-select', require('./components/public/products/attributeSelect.vue').default);

//Cart Resume
Vue.component('cart-resume-index', require('./components/public/cartResume/index.vue').default);
Vue.component('cart-resume-content', require('./components/public/cartResume/content.vue').default);
Vue.component('cart-resume-product-row', require('./components/public/cartResume/productRow.vue').default)
Vue.component('cart-resume-summary', require('./components/public/cartResume/summary.vue').default);

//Profile
Vue.component('profile-index', require('./components/public/profile/index.vue').default);

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
