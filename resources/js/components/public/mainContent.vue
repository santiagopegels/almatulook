<template>
    <a-layout>
        <sider-layout/>
        <a-layout-content :style="{ padding: '0 24px', maxWidth:'1400px', margin: 'auto'}">
            <a-row type="flex" justify="center" v-if="isLoading">
                <a-spin style="padding:5px;" size="large"/>
            </a-row>
            <fade-transition :duration="800" group v-if="!isLoading">
                <a-row v-if="this.products.data" key="productList" type="flex" justify="center">
                    <home-product-card v-for="product in this.products.data" :key="product.id"
                                       :product="product"
                    />
                </a-row>

                <a-empty key="emptySearch" v-if="this.products.data == 0" style="margin: auto" :image="emptyBag" >
                    <span slot="description"> NO HAY COINCIDENCIAS PARA TU BÚSQUEDA </span>
                </a-empty>

                <a-pagination key="pagination" v-if="this.products.data != 0" style="text-align: center; margin-top:15px;" v-model="page"
                              :total="getTotal" show-less-items @change="fetch"/>
            </fade-transition>
        </a-layout-content>

    </a-layout>
</template>
<script>
import {FadeTransition} from 'vue2-transitions'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import {mapGetters} from "vuex";
import emptyBag from '../../../../public/img/emptyBag.png'
export default {
    components: {
        FadeTransition,
        Loading
    },
    data() {
        return {
            opacity: 0.3,
            show: false,
            model: 'products',
            emptyBag: emptyBag
        }
    },
    mounted() {
        if (!this.products.data) {
            this.fetch();
        }
    },
    computed: {
        ...mapGetters(["products", "isLoading", "page", 'selected_category', 'term', 'orderProducts', 'selectedValuesToFilter']),
        page: {
            set(val) {
                window.scrollTo(0,0);
                this.$store.state.page = val;
            },
            get() {
                return this.$store.state.page;
            },
        },
        getTotal: function () {
            return this.products.total;
        },
    },
    watch: {
        selected_category() {
            this.fetch()
        },
        term() {
            this.fetch()
        },
        orderProducts(){
            this.fetch()
        },
        selectedValuesToFilter(){
            this.fetch()
        }
    },
    methods: {
        async fetch() {
            await this.$store.dispatch("fetchProductsPublic", {
                model: this.model,
                page: this.page,
                category: this.selected_category.id,
                term: this.term,
                order: this.orderProducts,
                valuesFilter: this.selectedValuesToFilter,
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

    }
}
</script>
