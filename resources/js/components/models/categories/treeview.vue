<template>
    <div class="card card-accent-primary">
        <div class="card-header">
            <i class="icon-settings"></i>
            Árbol de Categorías
            <span class="float-right">
        </span>
        </div>
        <div class="card-body" v-if="hasCategories">
            <v-jstree
                ref="tree"
                text-field-name="name"
                :data="getCategories"
                size="large"
                show-checkbox
                @item-click="itemClick"
            ></v-jstree>
    </div>
    </div>
</template>

<script>
import VJstree from 'vue-jstree'
import {mapGetters} from 'vuex'
export default{
    components: {
        VJstree
    },
    props: {
        newRootNode: {
            type: Object,
        },
    },
    data: function () {
        return {
            model: "categories",
        }
    },
    mounted(){
      this.fetchAll()
    },
    computed: {
        ...mapGetters(["isLoading", "categoriesAll", "selected_category"]),
        hasCategories() {
            return Boolean(this.categoriesAll.length>0);
        },
        getCategories() {
            return this.categoriesAll;
        },
    },
    watch: {
         newRootNode: async function (newCategory){
            if(newCategory.id){
                let newRootNodeTreeObject = await this.$refs.tree.initializeDataItem(newCategory)
                await this.$store.commit('REMOVE_CATEGORY_FROM_ALL', newCategory)
                await this.$store.commit('PUSH_CATEGORY_ALL', newRootNodeTreeObject)
            }
        }
    },
    methods: {
        async itemClick (node) {
            node.model.opened = true
            node.model.attributesIds = await this.getChildrenIds(node.model.attributesIds)
            await this.$store.commit("SET_SELECTED_CATEGORY", node.model);
        },
        async fetchAll() {
            await this.$store.dispatch("fetchAll", {
                model: this.model,
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        async getChildrenIds(values) {
            if (!values) return [];
            return values.map(function (value) {
                if(value.id){
                    return value.id
                } else {
                    return value
                }
            });
        },
    }
}
</script>
