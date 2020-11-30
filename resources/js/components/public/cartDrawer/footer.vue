<template>
    <div>
        <a-row type="flex" justify="space-between">
            <h2 class="bold">SUBTOTAL</h2>
            <h2 class="bold"> $12455.53 </h2>
        </a-row>
            <a-button type="primary" block size="large" @click="goToPurchaseIndex()">
                Comprar
            </a-button>
    </div>
</template>

<script>
export default {
    methods: {
        goToPurchaseIndex(){
            this.$store.commit('TOGGLE_SHOW_CART_SIDEBAR')
            this.$router.push({name: 'publicPurchaseIndex'})
        }
    }
}
</script>
