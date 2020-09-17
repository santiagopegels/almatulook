<template>
    <div v-if="showSelect">
        <treeselect
            v-model="value"
            placeholder="Seleccione una categoría"
            :multiple="multiple"
            :defaultExpandLevel="Infinity"
            noResultsText="No se encontraron resultados"
            noOptionsText="No existe categoría"
            noChildrenText="Fin de la subcategoría"
            :options="getCategories"/>
    </div>
</template>

<script>
// import the component
import Treeselect from '@riophae/vue-treeselect'
// import the styles
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
            showSelect: false
        }
    },
    mounted() {
        this.fetchAll()
    },
    computed: {
        ...mapGetters(["isLoading", "categoriesAll", "selected_category"]),
        hasCategories() {
            return Boolean(this.categoriesAll.length > 0);
        },
        getCategories() {
            return this.categoriesAll;
        },
    },
    methods: {
        async fetchAll() {
            await this.$store.dispatch("fetchAll", {
                model: this.model,
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
            
            //Generar funcion recursiva para obtener los labels
            await this.categoriesAll.map(item => item.label = item.name)
            this.showSelect = true
        },
    }
}
</script>
