<template>
    <div>
        <a-menu mode="horizontal" :style="{'background' : '#554B52', 'color':'white'}">
            <a-sub-menu key="categories" style="margin-left: 5px">
                <span slot="title"><a-icon type="tags"/><span>CATEGORIAS</span></span>
                <header-menu-item v-for="category in categoriesAll" :item="category" :key="category.id" :clickEvent="handleSelectCategory" />
            </a-sub-menu>
        </a-menu>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    data() {
        return {
            model: "categories",
        }
    },
    mounted() {
        if (!this.categoriesAll.data) {
            this.fetch();
        }
    },
    computed: {
        ...mapGetters(['categoriesAll'])
    },
    methods: {
        async fetch() {
            await this.$store.dispatch("fetchAll", {
                model: this.model,
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
        handleSelectCategory() {
            console.log('algo')
        }
    }
};
</script>
