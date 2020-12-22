<template>
    <div>
        <a-row type="flex" justify="space-between" style="padding: 5px 0px">
            <img class="purchase-summary-img"
                 :src="product.images[0]"/>
            <div>
                <p class="purchase-summary-product-title">1 x {{product.name}}</p>
                <ul class="purchase-summary-product-attribute-list ">
                    <li v-for="attributeValue in product.attributeValueSelected" :key="attributeValue.value_id">
                        {{  attributeValue.attribute }} {{ attributeValue.value }}
                    </li>
                </ul>
            </div>
            <p class="purchase-summary-product-price">{{ product.price | currency }}</p>
        </a-row>
    </div>
</template>
<script>
export default {
    props: ['product']
}
</script>
