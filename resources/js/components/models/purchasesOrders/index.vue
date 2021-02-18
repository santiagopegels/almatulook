<template>
<div class="row">
    <div class="col-sm-12 col-xs-12">
        <div class="card card-accent-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="align-item-center">
                <i class="icon-list"></i>
                Ordenes de Compra
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-end mb-4">
                    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                        <products-filters />
                    </div>
                </div>
                <purchases-orders-list />
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    mapGetters
} from "vuex";

export default {
    components: {
        PurchasesOrdersList: () => import(/* webpackChunkName: "js/admin-purchases-orders" */ './lists.vue'),
        ProductsFilters: () => import(/* webpackChunkName: "js/admin-purchases" */ '../products/filters.vue'),
    },
    computed: {
        ...mapGetters(["isLoading"]),
    },
};
</script>
