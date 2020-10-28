import Vue from 'vue'
import Router from 'vue-router'
import productIndex from './components/models/products/index.vue'

Vue.use(Router)
export const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/admin/products',
            name: 'productIndex',
            component: productIndex,
        },
    ]
})
