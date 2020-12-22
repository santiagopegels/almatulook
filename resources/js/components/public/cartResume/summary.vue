<template>
    <div>
        <a-card title="Resumen de la Compra"
                style="background-color: #fafafa; width:100%; box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1);">
            <a-row type="flex" justify="space-between" class="bold">
                <a-col>
                    <h3>Subtotal ({{ getTotalBagProducts }} productos)</h3>
                </a-col>
                <a-col>
                    <h3><b>{{ getSubtotal | currency }}</b></h3>
                </a-col>
            </a-row>
            <a-row type="flex" justify="space-between" class="bold">
                <a-col>
                    <h3>Costo de envío</h3>
                </a-col>
                <a-col>
                    <h3><b> {{ shipCost |currency }} </b></h3>
                </a-col>
            </a-row>
            <a-divider></a-divider>
            <a-row type="flex" justify="space-between" class="bold">
                <a-col>
                    <h1>Total</h1>
                </a-col>
                <a-col>
                    <h1>{{ getSubtotal + shipCost | currency }}</h1>
                </a-col>
            </a-row>
        </a-card>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'

export default {
    computed: {
        ...mapGetters(['bagProducts', 'shipCost']),
        getTotalBagProducts() {
            return this.bagProducts.length
        },
        getSubtotal() {
            const subtotalReducer = (subtotal, product) => subtotal + Number(product.price);
            return this.bagProducts.reduce(subtotalReducer, 0)
        }
    }
}
</script>
