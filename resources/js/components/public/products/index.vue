<template>
    <div>
        <header-layout/>
        <header-menu/>
        <cart-drawer/>
        <a-row style="padding: 10px;">
            <a-col :xs="{span: 24}"
                   :sm="{span: 12}"
                   :md="{span: 11}"
                   :lg="{span: 10}"
                   :xxl="{span: 10}">
        <product-images-carousel />
            </a-col>
            <a-col style="margin-top: 30px"
                    :xs="{span: 23, offset:1}"
                   :sm="{span: 11, offset:1}"
                   :md="{span: 11, offset:1}"
                   :lg="{span: 11, offset:1}"
                   :xxl="{span: 11, offset:1}">
                <p style="font-size: 3rem; margin-bottom: 0">{{selected_product.name}}</p>
                <p style="font-size: 1.2rem">Item N° {{ selected_product.id }}</p>
                <p style="font-size: 2.5rem; margin-bottom: 0" class="bold">{{ selected_product.price | currency}}</p>
                <a-divider></a-divider>
                <product-attribute-select-content />
                <a-divider></a-divider>
                <a-button style="margin-top:10px; width:97%; height: 50px;" size="large" block type="primary" @click="addToCart()">
                    Agregar a la Bolsa
                </a-button>
            </a-col>
        </a-row>
        <footer-layout />
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    computed: {
        ...mapGetters(['selected_product'])
    },
    methods: {
        async addToCart(){

            await this.$store.commit('PUSH_BAG_PRODUCT', this.selected_product)
            await this.$store.commit('TOGGLE_SHOW_CART_SIDEBAR')
        }
    }
}
</script>
