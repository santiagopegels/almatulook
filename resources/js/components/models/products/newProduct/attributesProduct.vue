<template>
    <div class="content-dashed" v-show="showAttributes">
        <div v-for="(stockData, stockDataIndex) in selected_product.stocks" :key="stockDataIndex"
             class="form-row justify-content-center">
            <div v-for="(attribute, index) in selected_category.attributesIds" :key="index"
                 class="form-group col-lg-3 col-xs-12">
                <label class="text-justify text-dark">{{ attribute.name }}</label>
                <treeselect
                    multiple
                    :normalizer="normalizer"
                    :options="attribute.values"
                    v-model="selected_product.stocks[stockDataIndex][attribute.name]"
                    :name="`attribute['${stockDataIndex}']${attribute.name}`"
                    :id="`attribute['${stockDataIndex}']${attribute.name}`"
                />
            </div>
            <div class="form-group col-lg-2">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock"
                       class="form-control"
                       v-model="selected_product.stocks[stockDataIndex].stock"
                       :name="`attribute['${stockDataIndex}']stock`"
                       :id="`attribute['${stockDataIndex}']stock`"
                />
            </div>
            <button class="close align-items-center pt-2"
                    type="button"
                    title="Eliminar"
                    @click="removeElement(stockDataIndex)"
            >
                <i class="fa fa-times"></i>
            </button>
        </div>
        <span class="border-bottom"></span>
        <div class="text-center mt-2">
            <button type="button"
                    class="btn btn-success"
                    @click="() => this.addStockData()">
                Agregar Stock
            </button>
        </div>
    </div>
</template>

<script>
import {
    mapGetters
} from "vuex";
import Treeselect from '@riophae/vue-treeselect'

export default {
    components: {
        Treeselect
    },
    data() {
        return {
            stockData: [],
            attributesStockData: [],
            showAttributes: false,
            syncStockAttribute:false
        }
    },
    computed: {
        ...mapGetters(["selected_category", "isLoading", "page", "selected_product"]),
        hasCategories() {
            return Boolean(this.selected_category.id > 0);
        },
    },
    watch: {
        async selected_category() {
            if (this.selected_category.id) {
                this.selected_product.stocks = []
                await this.addStockData()
            }
        }
    },
    methods: {
        normalizer(node) {
            return {
                id: node.id,
                label: node.name,
            }
        },
        async addStockData() {
            if (!this.attributesStockData.length > 0) {
                if (this.selected_product.id && !this.syncStockAttribute) {
                    await this.selected_product.attributes.forEach(attributesArray => {
                        let selectElement = {}
                        attributesArray['attributes'].forEach(attribute => {
                            selectElement[attribute.attribute] = []
                            selectElement[attribute.attribute][0] = attribute.value_id
                        })
                        selectElement.stock = Number(attributesArray.stock)
                        this.$store.commit('PUSH_STOCK_DATA_PRODUCT', selectElement)
                    })
                    this.syncStockAttribute = true
                } else {
                    let stockData = {}
                    await this.selected_category.attributesIds.forEach(item => this.attributesStockData[item.name] = [])
                    stockData = {...this.attributesStockData}
                    stockData.stock = 1
                    await this.$store.commit('PUSH_STOCK_DATA_PRODUCT', stockData)
                }
            }
            this.showAttributes = true
        },

        removeElement(index) {
            this.selected_product.stocks.splice(index, 1);
        }
    }
}
</script>
