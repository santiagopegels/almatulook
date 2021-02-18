<template>
    <div class="col-sm-12 col-xs-12">
        <div class="card card-accent-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="align-item-center">
                    <i class="icon-list"></i>
                    Detalles de Productos
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="purchases-table" class="table table-condensed table-striped table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Código Producto</th>
                            <th scope="col">Nombre Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio de Venta</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody v-if="hasProducts">
                        <tr v-for="model in products" :key="model.id">
                            <td scope="row">{{ model.product.id }}</td>
                            <td scope="row">{{ model.product.name }}</td>
                            <td scope="row">{{ model.quantity }}</td>
                            <td scope="row">{{ model.price_purchase_moment }}</td>
                            <td scope="row">{{ model.subtotal }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {
    mapGetters
} from "vuex";
import "vue-loading-overlay/dist/vue-loading.css";
import {orderBy} from 'lodash'

export default {
    data: function () {
        return {
            opacity: 0.3,
            model: "purchase_details",
            isHovering: false
        };
    },
    mounted() {
        this.fetch();
    },
    computed: {
        ...mapGetters(["selected_purchase", "products", "isLoading"]),
        hasProducts() {
            return Boolean(this.products.length > 0);
        },
    },
    methods: {
        async fetch() {
            await this.$store.dispatch("fetch", {
                model: this.model,
                term: this.selected_purchase.id
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
    },
};
</script>
