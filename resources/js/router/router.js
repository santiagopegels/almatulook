import Vue from 'vue'
import Router from 'vue-router'
import productForm from '../components/models/products/newProduct/index.vue'
import attributesIndex from '../components/models/attributes/index.vue'
import parametersIndex from '../components/models/parameters/index.vue'
import permissionsIndex from '../components/models/permissions/index.vue'
import shipmentTypesIndex from '../components/models/shipmentTypes/index.vue'
import rolesIndex from '../components/models/roles/index.vue'
import usersIndex from '../components/models/users/index.vue'
import purchasesIndex from '../components/models/purchases/index.vue'
import home from "../components/public/home";
import publicProductIndex from '../components/public/products/index.vue'
import publicPurchaseIndex from '../components/public/purchases/index.vue'
import cartResumeIndex from '../components/public/cartResume/index.vue'
import profileIndex from '../components/public/profile/index.vue'
import store from '../store/index'


Vue.use(Router)
export const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: home,
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
            component: attributesIndex,
        },
        {
            path: '/admin/parameters',
            name: 'parametersIndex',
            component: parametersIndex,
        },
        {
            path: '/admin/users',
            name: 'usersIndex',
            component: usersIndex,
        },
        {
            path: '/admin/roles',
            name: 'rolesIndex',
            component: rolesIndex,
        },
        {
            path: '/admin/permissions',
            name: 'permissionsIndex',
            component: permissionsIndex,
        },
        {
            path: '/admin/purchases',
            name: 'purchasesIndex',
            component: purchasesIndex,
        },
        {
            path: '/admin/shipmentTypes',
            name: 'shipmentTypesIndex',
            component: shipmentTypesIndex,
        },
        {
            path: '/product',
            name: 'publicProductIndex',
            component: publicProductIndex,
        },
        {
            path: '/purchase',
            name: 'publicPurchaseIndex',
            component: publicPurchaseIndex,
        },
        {
            path: '/cart',
            name: 'cartResumeIndex',
            component: cartResumeIndex,
        },
        {
            path: '/profile',
            name: 'profileIndex',
            component: profileIndex,
        },
    ]
})

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.state.userLogged.isAuthenticated
    const isCheckedBagSession = store.state.userLogged.isAuthenticated

    if (!isCheckedBagSession){
        store.dispatch('fetchUserBag')
    }
    if (to.name == 'home' && !isAuthenticated){
        store.dispatch('fetchUserLogged')
        next()
    }
    else next()
})


