import Vue from 'vue'
import Router from 'vue-router'
import productIndex from '../components/models/products/index.vue'
import productForm from '../components/models/products/newProduct/index.vue'
import categoriesIndex from '../components/models/categories/index.vue'
import attributesIndex from '../components/models/attributes/index.vue'
import parametersIndex from '../components/models/parameters/index.vue'
import permissionsIndex from '../components/models/permissions/index.vue'
import rolesIndex from '../components/models/roles/index.vue'
import usersIndex from '../components/models/users/index.vue'
import purchasesIndex from '../components/models/purchases/index.vue'
import home from "../components/public/home";
import publicProductIndex from '../components/public/products/index.vue'

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
            component: productIndex,
        },
        {
            path: '/admin/products/create',
            name: 'productForm',
            component: productForm,
        },
        {
            path: '/admin/categories',
            name: 'categoriesIndex',
            component: categoriesIndex,
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
            path: '/product',
            name: 'publicProductIndex',
            component: publicProductIndex,
        },
    ]
})
