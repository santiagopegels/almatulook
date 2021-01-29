/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

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
import {
    Button,
    Layout,
    Row,
    Col,
    Card,
    Carousel,
    Input,
    Icon,
    Avatar,
    Badge,
    Pagination,
    Checkbox,
    Form,
    Space,
    Spin,
    Select,
    Menu,
    Divider,
    Drawer,
    Cascader,
    Modal,
    Steps,
    Radio,
    InputNumber,
    Dropdown,
    Empty
} from 'ant-design-vue';
import Transitions from 'vue2-transitions';

Modal.install(Vue)
Vue.prototype.$confirm = Modal.confirm;

Vue.config.baseurl = process.env.MIX_APP_URL;
console.log('MIX_APP_URL', process.env.MIX_APP_URL);

Vue.component('paginate', Paginate);
Vue.component(Button.name, Button);
Vue.component(Layout.name, Layout);
Vue.component(Layout.Content.name, Layout.Content);
Vue.component(Layout.Footer.name, Layout.Footer);
Vue.component(Layout.Sider.name, Layout.Sider);
Vue.component(Row.name, Row);
Vue.component(Col.name, Col)
Vue.component(Card.name, Card);
Vue.component(Card.Meta.name, Card.Meta);
Vue.component(Carousel.name, Carousel);
Vue.component(Input.name, Input);
Vue.component(Input.Search.name, Input.Search);
Vue.component(Icon.name, Icon);
Vue.component(Avatar.name, Avatar);
Vue.component(Badge.name, Badge);
Vue.component(Pagination.name, Pagination);
Vue.component(Checkbox.name, Checkbox);
Vue.component(Checkbox.Group.name, Checkbox.Group);
Vue.component(Form.name, Form);
Vue.component(Form.Item.name, Form.Item)
Vue.component(Space.name, Space);
Vue.component(Spin.name, Spin);
Vue.component(Select.name, Select)
Vue.component(Select.Option.name, Select.Option);
Vue.component(Menu.name, Menu);
Vue.component(Menu.Item.name, Menu.Item)
Vue.component(Divider.name, Divider);
Vue.component(Drawer.name, Drawer);
Vue.component(Cascader.name, Cascader);
Vue.component(Modal.name, Modal);
Vue.component(Steps.name, Steps);
Vue.component(Steps.Step.name, Steps.Step);
Vue.component(Radio.name, Radio);
Vue.component(Radio.Group.name, Radio.Group);
Vue.component(InputNumber.name, InputNumber);
Vue.component(Dropdown.name, Dropdown);
Vue.component(Empty.name, Empty);
Vue.use(Vuex);
Vue.use(Toasted);
Vue.use(Vuelidate);
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
