<template>
    <div class="card mb-3">
                    <span v-if="selected_product.id" class="mr-1">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="cancelSelectedObject()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </span>
        <div class="item-img-container">
            <img v-if="selected_product.images[index]" class="card-img-top card-img-top-custom"
                 :src="selected_product.id ? selected_product.images[index] : selected_product.images[index].binary"
                 alt="Imagen"/>
            <img v-else class="card-img-top card-img-top-custom" :src="image" alt="Imagen"/>
        </div>
        <div
            class="container-fluid scrolling-wrapper justify-content-center"
            v-if="selected_product.images && selected_product.images.length > 0"
        >
            <div class="row flex-row flex-nowrap">
                <div class="col-3" v-for="(image, index) in selected_product.images" :key="index">
                    <figure class="figure d-inline-flex">
                        <img :src="selected_product.id ? image : image.binary" class="images-thumb-card" alt="..."
                             @click="showImageByIndex(index)"/>
                    </figure>
                </div>
            </div>
        </div>

        <div class="card-body mb-0">
            <h5 class="card-title text-truncate">{{ selected_product.name ? selected_product.name : '-' }}</h5>

            <hr/>
            <div class="w-100">
                <p class="mb-0">Categoría:</p>
                <h5 class="text-truncate" v-if="selected_category.id">{{ selected_category.name }}</h5>
                <h5 class="text-truncate" v-else>-</h5>
            </div>

            <div class="w-100">
                <p class="mb-0">Precio de Venta:</p>
                <h5 class="text-truncate" v-if="selected_product.price">{{ selected_product.price | currency }}</h5>
                <h5 class="text-truncate" v-else>-</h5>
            </div>

            <div class="w-100">
                <p class="mb-0">Precio de Costo:</p>
                <h5 class="text-truncate" v-if="selected_product.cost_price">
                    {{ selected_product.cost_price | currency }}</h5>
                <h5 class="text-truncate" v-else>-</h5>
            </div>

            <div class="scroll-vertical justify-content-center">
                <div class="text-center" v-for="(stockData, stockDataIndex) in selected_product.attributes"
                     :key="stockDataIndex">
                    <div v-for="(stock, stockIndex) in stockData" :key="stockIndex">
                        <div v-if="stock.length" v-for="(attribute, attributeIndex) in stock" :key="attributeIndex">
                            {{ attribute.attribute }}: {{ attribute.value }}
                        </div>
                    </div>
                    Stock: {{ stockData.stock }}
                    <hr/>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import defaultImage from '../../../../../public/img/default-image.jpg'

export default {
    data: function () {
        return {
            image: defaultImage,
            model: "products",
            model_name: "producto",
            index: 0
        };
    },
    created() {
    },
    mounted() {
    },
    computed: {
        ...mapGetters(['selected_product', 'selected_category']),
    },
    methods: {
        showImageByIndex(index) {
            this.index = index
        },

        async cancelSelectedObject() {
            await this.$store.commit('SET_SELECTED_PRODUCT')
        },
    },
};
</script>

<style lang="scss" scoped>
.scrolling-wrapper {
    overflow-x: auto;
}
</style>
