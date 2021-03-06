<template>
    <div class="table-responsive">
        <loading :opacity="opacity" loader="spinner" transition="fade" :active.sync="isLoading" :can-cancel="false"
                 :is-full-page="true" color="#20a8d8" background-color="rgba(0,0,0,0.8)"></loading>
        <table id="purchases-table" class="table table-condensed table-striped table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Total</th>
                <th scope="col">Estado</th>
                <th scope="col">Tipo de Pago</th>
                <th scope="col">N° de Pago</th>
                <th scope="col">Envío</th>
                <th scope="col">Cliente</th>
                <th scope="col" class="text-center">
                    <i class="icon-settings"></i>
                </th>
            </tr>
            </thead>
            <tbody v-if="hasPurchases">
            <tr :class="{'table-danger':model.deleted_at}" v-for="model in getPurchases" :key="model.id">
                <td scope="row">{{ model.id }}</td>
                <td>{{ model.total | currency }}</td>
                <td><span :class="{
                    'badge badge-success' : model.payment ? model.payment.status == 'approved' : false,
                    'badge badge-warning' : model.payment ? model.payment.status == 'pending' : false
                }">{{ model.payment ? model.payment.status : null }}</span></td>
                <td>{{ model.payment ? model.payment.payment_type : null }}</td>
                <td>{{ model.payment ? model.payment.payment_id : null }}</td>
                <td>{{ model.shipment ? model.shipment.name : null }}</td>
                <td>{{ model.profile ? model.profile.name : null }}
                    {{ model.profile ? model.profile.lastname : null }}
                </td>
                <td class="text-center">
                        <div>
                            <button
                                title="Show"
                                type="button"
                                @click="selectModel(model)"
                                class="btn btn-outline-success btn-sm"
                            >
                                <i class="icon-eye"></i>
                            </button>
                        </div>
                </td>
            </tr>
            </tbody>
        </table>
        <section
            v-if="hasPurchases"
            class="col-lg-12 col-sm-12 col-md-12 col-xs-12 center-block text-center d-flex justify-content-center"
        >
            <paginate
                v-model="page"
                :page-count="getLastPage"
                :page-range="5"
                :margin-pages="2"
                :click-handler="clickCallback"
                :prev-text="'&laquo;'"
                :next-text="'&raquo;'"
                :container-class="'pagination'"
                :page-class="'page-item'"
                :page-link-class="'page-link'"
                :prev-class="'page-item'"
                :next-class="'page-item'"
                :prev-link-class="'page-link'"
                :next-link-class="'page-link'"
                :active-class="'active'"
            ></paginate>
        </section>
    </div>
</template>

<script>
import {
    mapGetters
} from "vuex";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import {orderBy} from 'lodash'

export default {
    components: {
        Loading,
    },
    props: {},
    data: function () {
        return {
            opacity: 0.3,
            model: "purchases",
            model_name: 'orden de compra',
            isHovering: false
        };
    },
    mounted() {
        this.fetch();
    },
    computed: {
        ...mapGetters(["purchases", "isLoading", "page", "term"]),
        page: {
            set(val) {
                this.$store.state.page = val;
            },
            get() {
                return this.$store.state.page;
            },
        },
        hasPurchases() {
            return Boolean(this.purchases.data);
        },
        getPurchases() {
            return this.purchases.data;
        },
        getLastPage: function () {
            return this.purchases.last_page;
        },
    },
    methods: {

        async fetch() {
            await this.$store.dispatch("fetchPurchasesOrders", {
                model: this.model,
                page: this.page,
                term: this.term
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        /**
         * Event on click paging callback
         */
        async clickCallback(pageNum) {
            await this.$store.commit("SET_PAGE", pageNum);
            await this.fetch();
        },

        async selectModel(model) {
            await this.$store.commit("SET_SELECTED_PURCHASE", model);
        },
    },
};
</script>
