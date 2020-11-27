<template>
    <div>
        <a-row type="flex" justify="space-between">
            <h2 class="bold">SUBTOTAL</h2>
            <h2 class="bold"> $12455.53 </h2>
        </a-row>
        <router-link :to="{name: 'publicPurchaseIndex'}">
            <a-button type="primary" block size="large">
                Comprar
            </a-button>
        </router-link>
    </div>
</template>

<script>
export default {}
</script>
