<template>
    <div class="content-dashed" v-show="hasCategories">
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
            let stockData = {}
            await this.selected_category.attributesIds.forEach(item => this.attributesStockData[item.name] = [])
            stockData = {...this.attributesStockData}
            stockData.stock = 1
            await this.$store.commit('PUSH_STOCK_DATA_PRODUCT', stockData)
        },

        async removeElement(index) {
            if(this.selected_product.id){
                if(confirm('¿Estás seguro de que quieres eliminar este elemento?')){
                    await this.$store.dispatch("deleteStock", {
                            product_id: this.selected_product.id,
                            attributes: this.selected_product.stocks[index]
                    }).then(response => {
                        this.selected_product.stocks.splice(index, 1);
                    })
                }
            }else {
                this.selected_product.stocks.splice(index, 1);
            }
        }
    }
}
</script>
