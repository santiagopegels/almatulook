import Vue from 'vue'
import Router from 'vue-router'
import productForm from '../components/models/products/newProduct/index.vue'
import parametersIndex from '../components/models/parameters/index.vue'
import permissionsIndex from '../components/models/permissions/index.vue'
import shipmentTypesIndex from '../components/models/shipmentTypes/index.vue'
import rolesIndex from '../components/models/roles/index.vue'
import purchasesIndex from '../components/models/purchases/index.vue'
import home from "../components/public/home";
import publicProductIndex from '../components/public/products/index.vue'
import publicPurchaseIndex from '../components/public/purchases/index.vue'
import cartResumeIndex from '../components/public/cartResume/index.vue'
import store from '../store/index'


Vue.use(Router)
export const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: home,
            beforeEnter: (to, from, next) => {
                if (to.query.site_id === 'MLA') {
                    store.dispatch('storePayment', to.query)
                }
                next()
            }
        },
        {
            path: '/admin/products',
            name: 'productIndex',
            component: () => import(/* webpackChunkName: "js/admin-products" */ '../components/models/products/index.vue'),
        },
        {
            path: '/admin/products/create',
            name: 'productForm',
            component: () => import(/* webpackChunkName: "js/admin-products" */ '../components/models/products/newProduct/index.vue'),
        },
        {
            path: '/admin/categories',
            name: 'categoriesIndex',
            component: () => import(/* webpackChunkName: "js/admin-categories" */ '../components/models/categories/index.vue'),
        },
        {
            path: '/admin/attributes',
            name: 'attributesIndex',
            component: () => import(/* webpackChunkName: "js/admin-attributes" */ '../components/models/attributes/index.vue'),
        },
        {
            path: '/admin/parameters',
            name: 'parametersIndex',
            component: () => import(/* webpackChunkName: "js/admin-parameters" */ '../components/models/parameters/index.vue'),
        },
        {
            path: '/admin/users',
            name: 'usersIndex',
            component: () => import(/* webpackChunkName: "js/admin-users" */ '../components/models/users/index.vue'),
        },
        {
            path: '/admin/roles',
            name: 'rolesIndex',
            component: () => import(/* webpackChunkName: "js/admin-roles" */ '../components/models/roles/index.vue'),
        },
        {
            path: '/admin/permissions',
            name: 'permissionsIndex',
            component: () => import(/* webpackChunkName: "js/admin-permissions" */ '../components/models/permissions/index.vue'),
        },
        {
            path: '/admin/purchases',
            name: 'purchasesIndex',
            component: () => import(/* webpackChunkName: "js/admin-purchases" */ '../components/models/purchases/index.vue'),
        },
        {
            path: '/admin/shipmentTypes',
            name: 'shipmentTypesIndex',
            component: () => import(/* webpackChunkName: "js/admin-shipment" */ '../components/models/shipmentTypes/index.vue'),
        },
        {
            path: '/admin/orderStatus',
            name: 'orderStatusIndex',
            component: () => import(/* webpackChunkName: "js/admin-order-status" */ '../components/models/ordersStatus/index.vue'),
        },
        //PUBLIC
        {
            path: '/product',
            name: 'publicProductIndex',
            component: publicProductIndex,
        },
        {
            path: '/purchase',
            name: 'publicPurchaseIndex',
            component: () => import(/* webpackChunkName: "js/purchases" */ '../components/public/purchases/index.vue'),
        },
        {
            path: '/cart',
            name: 'cartResumeIndex',
            component: cartResumeIndex,
        },
        {
            path: '/profile',
            name: 'profileIndex',
            component: () => import(/* webpackChunkName: "js/profile" */ '../components/public/profile/index.vue'),
        },
    ]
})

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.state.userLogged.isAuthenticated
    const isCheckedBagSession = store.state.userLogged.isAuthenticated

    if (!isCheckedBagSession) {
        store.dispatch('fetchUserBag')
    }
    if (to.name == 'home' && !isAuthenticated) {
        store.dispatch('fetchUserLogged')
        next()
    } else next()
})


