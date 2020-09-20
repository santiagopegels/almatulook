<template>
    <div class="content-dashed" v-show="hasCategories">
        <div v-for="{n} in stockRows"  class="form-row justify-content-center">
            <div v-for="attribute in selected_category.attributesIds" class="form-group col-lg-2 col-xs-12">
                <label class="text-justify text-dark">{{ attribute.name }}</label>
                <treeselect
                    multiple
                    :normalizer="normalizer"
                    :options="attribute.values"
                />
            </div>
            <div class="form-group col-lg-1">
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock"
                   class="form-control"
            />
            </div>
            <button class="close align-items-center pt-2" type="button" title="Eliminar">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <span class="border-bottom"></span>
        <div class="text-center mt-2">
            <button type="button"
                    class="btn btn-success"
                    @click="() => this.stockRows++"
            >
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
    data(){
        return {
            stockRows: 1,
        }
    },
    computed: {
        ...mapGetters(["selected_category", "isLoading", "page"]),
        hasCategories() {
            return Boolean(this.selected_category.id > 0);
        },
    },
    methods: {
        normalizer(node) {
            return {
                id: node.id,
                label: node.name,
            }
        },
    }
}
</script>
