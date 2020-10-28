import Vue from 'vue'
import Router from 'vue-router'
import productIndex from './components/models/products/index.vue'
import productForm from './components/models/products/newProduct/index.vue'
import categoriesIndex from './components/models/categories/index.vue'

Vue.use(Router)
export const router = new Router({
    mode: 'history',
    routes: [
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
    ]
})
