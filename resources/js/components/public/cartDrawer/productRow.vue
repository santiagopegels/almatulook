<template>
    <div>
        <a-row type="flex" justify="space-between">
            <img v-if="" class="cart-drawer-content-item-list-img"
                 :src="product.images.length > 0 ? product.images[0] : logo"/>

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
import logo from '../../../../../public/img/logo/logo.png'
export default {
    props: ['product'],
    data(){
        return {
            logo: logo
        }
    },
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
