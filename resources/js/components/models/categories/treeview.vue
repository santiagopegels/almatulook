<template>
    <div class="card card-accent-primary">
        <div class="card-header">
            <i class="icon-settings"></i>
            Árbol de Categorías
            <span class="float-right">
        </span>
        </div>
        <div class="card-body" v-if="hasCategories">
            <v-jstree :data="getCategories" show-checkbox multiple allow-batch whole-row @item-click="itemClick"></v-jstree>
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
    methods: {
        itemClick (node) {
            console.log(node.model.text + ' clicked !')
        },
        async fetchAll() {
            await this.$store.dispatch("fetchAll", {
                model: this.model,
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
    }
}
</script>
