<template>
    <div>
        <a-row type="flex" justify="space-between">
            <h2 class="bold">SUBTOTAL (Sin Envío)</h2>
            <h2 class="bold"> {{  getSubtotal | currency }}</h2>
        </a-row>
            <a-button :class="{'swingHorizontal': !bagProducts.length >0}" :disabled="!bagProducts.length >0" type="primary" block size="large" @click="goToPurchaseIndex()">
                Comprar
            </a-button>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    computed: {
      ...mapGetters(['bagProducts']),
        getSubtotal(){
          const subtotalReducer = (subtotal, product) => subtotal + Number(product.price);
          return this.bagProducts.reduce(subtotalReducer, 0)
        }
    },
    watch: {
    },
    methods: {
        goToPurchaseIndex(){
            this.$store.commit('TOGGLE_SHOW_CART_SIDEBAR')
            this.$router.push({name: 'publicPurchaseIndex'})
        }
    }
}
</script>
