<template>
    <div class="table-responsive">
        <table id="products-table" class="table table-condensed table-striped table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Producto</th>
                <th scope="col">Stock</th>
                <th scope="col">Precio de Costo</th>
                <th scope="col">Precio de Venta</th>
                <th scope="col" class="text-center">
                    <i class="icon-settings"></i>
                </th>
            </tr>
            </thead>
            <tbody v-if="hasProducts">
            <tr :class="{'table-danger':model.deleted_at}" v-for="model in getProducts" :key="model.id">
                <td scope="row">{{model.id}}</td>
                <td scope="row">{{model.name}}</td>
                <td scope="row">Stock</td>
                <td scope="row">{{model.cost_price}}</td>
                <td scope="row">{{model.price}}</td>
                <td class="text-center">
                    <form method="POST" @submit="handleSubmitDelete($event, model)" accept-charset="UTF-8">
                        <button type="button" title="Editar" :disabled="model.deleted_at" @click="selectedObject(model)" class="btn btn-outline-warning btn-sm">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button v-if="!model.deleted_at" title="Eliminar" type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar este elemento?')" class="btn btn-outline-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </button>
                        <button v-else title="Restaurar" type="button" class="btn btn-success btn-sm" @click="restore(model)">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
        <section v-if="hasProducts" class="col-lg-12 col-sm-12 col-md-12 col-xs-12 center-block text-center d-flex justify-content-center">
            <paginate v-model="page" :page-count="getLastPage" :page-range="5" :margin-pages="2" :click-handler="clickCallback" :prev-text="'&laquo;'" :next-text="'&raquo;'" :container-class="'pagination'" :page-class="'page-item'" :page-link-class="'page-link'" :prev-class="'page-item'" :next-class="'page-item'" :prev-link-class="'page-link'" :next-link-class="'page-link'" :active-class="'active'"></paginate>
        </section>
    </div>
</template>

<script>
import {
    mapGetters
} from "vuex";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
    props: {},
    data: function () {
        return {
            opacity: 0.3,
            model: "products",
            model_name: 'producto'
        };
    },
    created() {},
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
    components: {
        Loading,
    },
    methods: {
        orderedObjects: function () {
            return _.orderBy(this.products.data, "id");
        },

        async handleSubmitDelete(e, data) {
            e.preventDefault();

            if (!data.id > 0) {
                return;
            }

            await this.delete(data);
        },

        async fetch() {
            await this.$store.dispatch("fetch", {
                model: this.model,
                page: this.page
            })
                .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },

        async fetchAll() {
            await this.$store.dispatch("fetchAll", {
                model: this.model,
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        async delete(model) {
            await this.$store.dispatch("delete", {
                _method: 'DELETE',
                model: this.model,
                data: model
            })
                .then(async result => {
                    this.$toasted.global.ToastedSuccess({ message: `El ${this.model_name} fue eliminado!` });
                    await this.fetch();
                    await this.fetchAll();
                })
                .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },

        async restore(data) {
            await this.$store.dispatch("restore", {
                model: this.model,
                data: data
            })
                .then(async result => {
                    this.$toasted.global.ToastedSuccess({ message: `El ${this.model_name} fue restaurado!` });
                    await this.fetch();
                    await this.fetchAll();
                })
                .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },

       async selectedObject(model) {
           await this.$store.commit("SET_SELECTED_PRODUCT", {
                id: model.id,
                name: model.name,
                slug: model.slug,
                attributesIds: await this.getAttributesIds(model.attributes),
            });
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
    },
};
</script>
