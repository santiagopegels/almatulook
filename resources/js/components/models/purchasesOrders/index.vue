<template>
    <div>
        <div class="row" v-if="!selected_purchase.id">
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
                                <purchases-orders-filter/>
                            </div>
                        </div>
                        <purchases-orders-list/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-else>
            <div class="col-sm-12 col-xs-12">
                <purchase-products-list />
            </div>
            <div class="col-sm-4 col-xs-4">
                <purchase-info />
            </div>
            <div class="col-sm-4 col-xs-4">
                <payment-info />
            </div>
            <div class="col-sm-4 col-xs-4">
                <customer-info />
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
        PurchasesOrdersFilter: () => import(/* webpackChunkName: "js/admin-purchases-orders" */ './filters.vue'),
        PurchaseInfo: () => import(/* webpackChunkName: "js/admin-purchases-orders" */ './purchaseInfo.vue'),
        PaymentInfo: () => import(/* webpackChunkName: "js/admin-purchases-orders" */ './paymentInfo.vue'),
        CustomerInfo: () => import(/* webpackChunkName: "js/admin-purchases-orders" */ './customerInfo.vue'),
        PurchaseProductsList: () => import(/* webpackChunkName: "js/admin-purchases-orders" */ './purchaseProductsList.vue'),
    },
    computed: {
        ...mapGetters(["isLoading", 'selected_purchase']),
    },
};
</script>
