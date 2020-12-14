<template>
    <div>
        <a-row type="flex" justify="space-between">
            <img class="cart-drawer-content-item-list-img"
                 :src="product.images[0]"/>

            <h3>{{product.name}}</h3>

            <h3 style="font-weight: bold">{{product.price | currency }}</h3>
        </a-row>
        <a-row type="flex" justify="end">
            <a-icon type="delete" class="cart-drawer-content-delete-icon" @click="showConfirm(product)"/>
        </a-row>
        <a-divider></a-divider>
    </div>
</template>
<script>
import store from '../../../store/index'
export default {
    props: ['product'],
    methods: {
        showConfirm(product) {
            let self = this
            this.$confirm({
                title: '¿Desea quitar el producto de su carrito?',
                content: `El producto ${this.product.name} será removido de su carrito de compras.`,
                cancelText: 'Cancelar',
                onOk() {
                    self.$store.commit('REMOVE_BAG_PRODUCT', product)
                },
                onCancel() {},
            });
        },
    }
}
</script>
