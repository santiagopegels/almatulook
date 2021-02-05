<template>
    <div>
        <a-card title="Resumen de la Compra"
                style="background-color: #fafafa; width:100%; box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1);">
            <a-button slot="extra" type="default" @click="goToCartResume()">
                Editar
            </a-button>
            <p>{{ bagProducts.length }} Items</p>
            <div v-if="!moreProductsButton.showMore">
                <summary-purchase-product v-for="product in bagProducts.slice(0,3)" :key="product.id"
                                          :product="product"/>
            </div>
            <div v-else>
                <summary-purchase-product v-for="product in bagProducts" :key="product.id" :product="product"/>
            </div>
            <a-button type="default" size="small" @click="handleMoreProducts()">
                <a-icon :type="moreProductsButton.icon"/>
                {{ moreProductsButton.text }}
            </a-button>
            <a-divider></a-divider>
            <a-row type="flex" justify="space-between" class="bold">
                <a-col>
                    Subtotal
                </a-col>
                <a-col>
                    {{ getSubtotal | currency }}
                </a-col>
            </a-row>
            <a-row type="flex" justify="space-between" class="bold">
                <a-col style="display: flex">
                    Costo de envío &nbsp; <p style="font-size: 0.8rem" v-show="selected_shipment_type.id">  ({{  selected_shipment_type.name  }}) </p>
                </a-col>
                <a-col>
                     {{ selected_shipment_type.cost | currency }}
                </a-col>
            </a-row>
            <a-divider></a-divider>
            <a-row type="flex" justify="space-between" class="bold">
                <a-col>
                    <h1>Total</h1>
                </a-col>
                <a-col>
                    <h1>{{ Number(getSubtotal) + Number(selected_shipment_type.cost) | currency }}</h1>
                </a-col>
            </a-row>
        </a-card>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'

export default {
    components: {
        SummaryPurchaseProduct: () => import(/* webpackChunkName: "js/purchases" */ './productSummaryRow.vue'),
    },
    computed: {
        ...mapGetters(['bagProducts', 'shipCost', 'selected_shipment_type']),
        getSubtotal() {
            const subtotalReducer = (subtotal, product) => subtotal + Number(product.price);
            return this.bagProducts.reduce(subtotalReducer, 0)
        }
    },
    data() {
        return {
            moreProductsButton: {
                text: 'Ver más...',
                showMore: false,
                icon: 'right-circle',
            },
        }
    },
    methods: {
        handleMoreProducts() {
            if (this.moreProductsButton.showMore) {
                this.moreProductsButton.showMore = !this.moreProductsButton.showMore
                this.moreProductsButton.text = 'Ver más...'
                this.moreProductsButton.icon = 'right-circle'
            } else {
                this.moreProductsButton.showMore = !this.moreProductsButton.showMore
                this.moreProductsButton.text = 'Ver menos...'
                this.moreProductsButton.icon = 'down-circle'
            }
        },
        goToCartResume() {
            this.$router.push({name: 'cartResumeIndex'})
        }
    }
}
</script>
