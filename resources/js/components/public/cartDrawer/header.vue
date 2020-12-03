<template>
    <div>
        <a-row type="flex" justify="space-between">
            <a-row>
                <a-icon type="close-square" class="cart-drawer-header-icon" @click="onClose"/>
            </a-row>
            <a-row type="flex">
                <a-space :size="20">
                    <a href="/login">
                        <a-avatar style="backgroundColor:#9E7B1A" icon="login"/>
                    </a>
                </a-space>
            </a-row>
        </a-row>
        <br>
        <a-row>
            <h2 class="cart-drawer-title">Mi Carrito</h2>
        </a-row>
    </div>
</template>
<script>
export default {
    methods: {
        onClose() {
            this.$store.commit('TOGGLE_SHOW_CART_SIDEBAR')
        },
    }
}
</script>
