<template>
        <treeselect
            v-model="value"
            placeholder="Seleccione una categoría"
            :multiple="multiple"
            :defaultExpandLevel="1"
            noResultsText="No se encontraron resultados"
            noOptionsText="No existe categoría"
            noChildrenText="Fin de la subcategoría"
            :normalizer="normalizer"
            required
            valueFormat="object"
            :options="getCategories"/>
</template>

<script>
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import {mapGetters} from 'vuex'

export default {
    components: {Treeselect},
    props: {
        multiple: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            value: null,
            model: "categories",
        }
    },
    mounted() {
        this.fetchAll()
        if(this.selected_category.id){
            this.value = this.selected_category
        }
    },
    computed: {
        ...mapGetters(["isLoading", "categoriesAll", "selected_category", "selected_category"]),
        hasCategories() {
            return Boolean(this.categoriesAll.length > 0);
        },
        getCategories() {
            return this.categoriesAll;
        },
    },
    watch:{
        value: function (categorySelected){
            this.$store.commit("SET_SELECTED_CATEGORY", categorySelected);
        }
    },
    methods: {
        async fetchAll() {
            await this.$store.dispatch("fetchAll", {
                model: this.model,
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        normalizer(node) {
            return {
                id: node.id,
                label: node.name,
                children: node.children,
            }
        },
    }
}
</script>
