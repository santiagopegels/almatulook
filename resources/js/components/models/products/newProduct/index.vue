<template>
    <div class="row">
        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
            <new-product-form></new-product-form>
        </div>
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <products-card></products-card>
        </div>
    </div>
</template>

<script>
import {
    mapGetters
} from "vuex";
export default {
    components: {
        NewProductForm: () => import(/* webpackChunkName: "js/admin-products" */ './form'),
        ProductsCard: () => import(/* webpackChunkName: "js/admin-products" */ '../card'),
    },
    props: {
    },
    data: function () {
        return {};
    },
    created() {},
    mounted() {},
    computed: {
        ...mapGetters(["isLoading"]),
    },
    methods: {
    },
};
</script>
