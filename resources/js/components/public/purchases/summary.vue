<template>
    <div>
        <a-card title="Resumen de la Compra" style="background-color: #fafafa; width:100%; box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1);">
            <a-button slot="extra" type="default" @click="handleMoreProducts()">
                Editar
            </a-button>
            <p>6 Items</p>
            <summary-purchase-product />
            <summary-purchase-product />
            <summary-purchase-product />
            <a-button type="default" size="small" @click="handleMoreProducts()">
               <a-icon :type="moreProductsButton.icon"/>{{moreProductsButton.text}}
            </a-button>
            <a-divider></a-divider>
            <a-row type="flex" justify="space-between" class="bold">
                <a-col>
                    Subtotal
                </a-col>
                <a-col>
                    $2080,90
                </a-col>
            </a-row>
            <a-row type="flex" justify="space-between" class="bold">
                <a-col>
                    Costo de envío
                </a-col>
                <a-col>
                    $249,00
                </a-col>
            </a-row>
            <a-divider></a-divider>
            <a-row type="flex" justify="space-between" class="bold">
                <a-col>
                    <h1>Total</h1>
                </a-col>
                <a-col>
                    <h1>$4249,00</h1>
                </a-col>
            </a-row>
        </a-card>
    </div>
</template>
<script>
export default {
    data(){
        return {
            moreProductsButton:{
                text: 'Ver más...',
                showMore: false,
                icon: 'right-circle'
            }
        }
    },
    methods: {
        handleMoreProducts(){
            if(this.moreProductsButton.showMore){
                this.moreProductsButton.showMore = !this.moreProductsButton.showMore
                this.moreProductsButton.text = 'Ver más...'
                this.moreProductsButton.icon = 'right-circle'
            } else {
                this.moreProductsButton.showMore = !this.moreProductsButton.showMore
                this.moreProductsButton.text = 'Ver menos...'
                this.moreProductsButton.icon = 'down-circle'
            }
        }
    }
}
</script>
