<template>
    <a-row style="padding-top: 20px;" type="flex" justify="center">
        <a-col :xs="{span: 22}"
               :sm="{span: 22}"
               :md="{span: 14, offset: 1}"
               :lg="{span: 14, offset: 1}"
               :xxl="{span: 10, offset: 1}">
            <a-row type="flex" align="middle">
                <h1 style="padding: 4px;">Mi Carrito</h1>
                <h3 style="padding: 6px">{{ getTotalBagProducts }} Productos</h3>
            </a-row>
            <cart-resume-product-row v-for="product in bagProducts" :key="product.id" :product="product"/>
        </a-col>
        <a-col class="resume-cart-summary-content"
               :xs="{span: 22}"
               :sm="{span: 22}"
               :md="{span: 7, offset: 1}"
               :lg="{span: 7, offset: 1}"
               :xxl="{span: 8, offset: 3}">
            <router-link :to="{name:'publicPurchaseIndex'}">
            <a-button style="margin-bottom: 10px" type="primary" size="large" block>Finalizar Compra</a-button>
            </router-link>
            <cart-resume-summary/>
        </a-col>
    </a-row>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    computed: {
        ...mapGetters(['bagProducts']),
        getTotalBagProducts() {
            return this.bagProducts.length
        },
    },
}
</script>
