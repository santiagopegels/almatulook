<template>
    <a-layout>
        <sider-layout/>
        <a-layout-content :style="{ padding: '0 24px', maxWidth:'1400px', margin: 'auto'}">
            <a-row type="flex" justify="center" v-if="isLoading">
                <a-spin style="padding:5px;" size="large"/>
            </a-row>
            <fade-transition :duration="800" group v-if="!isLoading">
                <a-row key="productList" type="flex" justify="center" >
                        <home-product-card v-for="product in this.products.data" :key="product.id"
                                           :price="product.price"
                                           :name="product.name"
                                           :images="product.images"
                                           @click.native="pushShowProductRoute(product)"
                        />
                </a-row>
                <a-pagination key="pagination" style="text-align: center; margin-top:15px;" v-model="page" :total="getTotal" show-less-items @change="fetch"/>
            </fade-transition>
        </a-layout-content>
    </a-layout>
</template>
<script>
import {FadeTransition} from 'vue2-transitions'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import {mapGetters} from "vuex";

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
        }
    },
    mounted() {
        if (!this.products.data) {
            this.fetch();
        }
    },
    computed: {
        ...mapGetters(["products", "isLoading", "page", 'selected_category']),
        page: {
            set(val) {
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
      selected_category(){
         this.fetch()
      }
    },
    methods: {
        async fetch() {
            await this.$store.dispatch("fetchProductsPublic", {
                model: this.model,
                page: this.page,
                category: this.selected_category.id

            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
        async pushShowProductRoute(model){
            await this.$store.commit("SET_SELECTED_PRODUCT", {
                id: model.id,
                name: model.name,
                price: Number(model.price),
                images: model.images,
                attributes: model.attributes,
            });
            await this.$router.push({name: 'publicProductIndex'})
        },
    }
}
</script>
