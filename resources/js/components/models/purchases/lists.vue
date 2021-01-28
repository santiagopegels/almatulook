<template>
    <div class="table-responsive">
        <loading :opacity="opacity" loader="spinner" transition="fade" :active.sync="isLoading" :can-cancel="false"
                 :is-full-page="true" color="#20a8d8" background-color="rgba(0,0,0,0.8)"></loading>
        <table id="products-table" class="table table-condensed table-striped table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Producto</th>
                <th scope="col">Carácteristicas</th>
                <th scope="col">Stock</th>
                <th scope="col">Precio</th>
                <th scope="col" class="text-center">
                    <i class="icon-settings"></i>
                </th>
            </tr>
            </thead>
            <tbody v-if="hasProducts">
            <template v-for="product in getProducts">
                <template v-for="attributes in product.attributes">
                    <tr v-if="attributes.stock > 0"
                    >
                        <td scope="row"
                            @click="showProduct(product)"
                            @mouseover="isHovering = true"
                            @mouseout="isHovering = false"
                            :class="{'table-danger':model.deleted_at, 'hovering': isHovering}"
                        >{{ product.id }}
                        </td>
                        <td scope="row"
                            @click="showProduct(product)"
                            @mouseover="isHovering = true"
                            @mouseout="isHovering = false"
                            :class="{'table-danger':model.deleted_at, 'hovering': isHovering}"
                        >{{ product.name }}
                        </td>
                        <td scope="row"><h6 class="mb-0" v-for="attribute in attributes.attributes">
                            {{ attribute.attribute }}: <b>{{ attribute.value }}</b></h6></td>
                        <td scope="row">{{ attributes.stock }}</td>
                        <td scope="row">{{ product.price | currency }}</td>
                        <td class="text-center">
                            <button type="button" title="sell" @click="sellProduct(product, attributes)"
                                    class="btn btn-primary btn-sm">
                                VENDER
                            </button>
                        </td>
                    </tr>
                </template>
            </template>
            </tbody>
        </table>
        <section v-if="hasProducts"
                 class="col-lg-12 col-sm-12 col-md-12 col-xs-12 center-block text-center d-flex justify-content-center">
            <paginate v-model="page" :page-count="getLastPage" :page-range="5" :margin-pages="2"
                      :click-handler="clickCallback" :prev-text="'&laquo;'" :next-text="'&raquo;'"
                      :container-class="'pagination'" :page-class="'page-item'" :page-link-class="'page-link'"
                      :prev-class="'page-item'" :next-class="'page-item'" :prev-link-class="'page-link'"
                      :next-link-class="'page-link'" :active-class="'active'"></paginate>
        </section>
    </div>
</template>

<script>
import {
    mapGetters
} from "vuex";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import Swal from 'sweetalert2'
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
            model_name: 'producto',
            isHovering: false
        };
    },
    created() {
    },
    mounted() {
        this.fetch();
    },
    computed: {
        ...mapGetters(["products", "isLoading", "page"]),
        page: {
            set(val) {
                this.$store.state.page = val;
            },
            get() {
                return this.$store.state.page;
            },
        },
        hasProducts() {
            return Boolean(this.products.data);
        },
        getProducts() {
            return this.orderedObjects();
        },
        getLastPage: function () {
            return this.products.last_page;
        },
        getTotal: function () {
            return this.products.total;
        },
    },
    methods: {
        orderedObjects: function () {
            return orderBy(this.products.data, "id");
        },

        async handleSubmitDelete(e, data) {
            e.preventDefault();

            if (!data.id > 0) {
                return;
            }

            await this.delete(data);
        },

        async fetch() {
            await this.$store.dispatch("fetchProductsWithStock", {
                model: 'products',
                page: this.page
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        async getAttributesIds(products) {
            if (!products) return [];
            return products.map(function (value) {
                return value.id;
            });
        },

        /**
         * Event on click paging callback
         */
        async clickCallback(pageNum) {
            await this.$store.commit("SET_PAGE", pageNum);
            await this.fetch();
        },

        async showProduct(model) {
            await this.selectProductAndCategory(model)
        },

        async editProduct(model) {
            await this.selectProductAndCategory(model)
            await this.$router.push({name: "productForm"})
        },

        async selectProductAndCategory(model) {
            await this.$store.commit("SET_SELECTED_PRODUCT", {
                id: model.id,
                name: model.name,
                price: Number(model.price),
                cost_price: Number(model.cost_price),
                images: model.images,
                attributes: model.attributes,
                stocks: await this.getStockProduct(model)
            });
            await this.$store.commit("SET_SELECTED_CATEGORY", {
                id: model.category.id,
                name: model.category.name,
                children: model.category.children,
                attributesIds: model.category.attributesIds,
            });
        },
        async getStockProduct(product) {
            let stockArray = []
            await product.attributes.forEach(attributesArray => {
                let selectElement = {}
                attributesArray['attributes'].forEach(attribute => {
                    selectElement[attribute.attribute] = []
                    selectElement[attribute.attribute][0] = attribute.value_id
                })
                selectElement.stock = Number(attributesArray.stock)
                stockArray.push(selectElement)
            })
            return stockArray
        },
        async sellProduct(product, attributes) {
            let msg = ''
            await attributes.attributes.forEach(attribute => msg += `${attribute.attribute}: <b>${attribute.value}</b>\n`)

            //msg without last enter \n
            msg = msg.substring(0, msg.length - 2);

            await Swal.fire({
                title: "Venta De Producto",
                text: "Algo",
                html: `¿Está seguro que desea vender <b> ${product.name}</b> con las siguientes características?<pre class="mt-3"> ${msg} </pre>`,
                type: "question",
                showCancelButton: true,
                confirmButtonText:
                    'Si, vender! <i class="icon-like"></i>',
                cancelButtonText:
                    'Cancelar',
            }).then(result => {
                if(result.isConfirmed){
                    this.$store.dispatch('store', {
                        model: this.model,
                        data: {
                            products: [{
                                product_id: product.id,
                                attributes: attributes,
                                quantity: 1
                            }]
                        }
                    }).then(result => {
                        if(result){
                            this.fetch()
                        }
                    })
                }
            })
        }
    },
};
</script>
