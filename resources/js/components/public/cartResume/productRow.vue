<template>
    <a-row type="flex"
           style="box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1); margin-bottom:20px; padding: 10px; border: solid lightgrey 0.2px">
        <a-col class="cart-resume-product-row-content-img">
            <img class="cart-resume-product-row-img"
                 :src="product.images[0]"/>
        </a-col>
        <a-col flex="auto" class="cart-resume-product-row-info-content">
            <div style="display: flex; justify-content: space-between">
                <p class="cart-resume-product-title">{{ product.name }}</p>
                <a-icon type="delete" class="cart-resume-product-content-delete-icon" @click="showConfirm(product)"/>
            </div>

            <div style="display: flex; justify-content: space-between">
                <div>
                    <ul class="cart-resume-product-row-info-content-list-attribute">
                        <li v-for="attributeValue in product.attributeValueSelected" :key="attributeValue.value_id">
                            {{ attributeValue.attribute }} {{ attributeValue.value }}
                        </li>
                    </ul>
                </div>
                <div style="display: flex;">
                    <div style="margin-right: 10px">
                        <h5 style="margin-bottom: 0">Cantidad:</h5>
                        <a-select default-value="1" style="width: 60px">
                            <a-select-option v-for="num in 1" :key="num" :value="num">{{ num }}
                            </a-select-option>
                        </a-select>
                    </div>
                    <div class="cart-resume-product-row-info-quantity-price">
                        <h5 style="margin-bottom: 0">Total:</h5>
                        <h3 class="bold">{{ product.price | currency }}</h3>
                    </div>
                </div>
            </div>
        </a-col>
    </a-row>
</template>
<script>
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
                    self.$store.dispatch('removeProductToBag', product)
                },
                onCancel() {
                },
            });
        },
    }
}
</script>
