<template>
    <div class="table-responsive">
        <table id="categories-table" class="table table-condensed table-striped table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col" class="text-center">
                    <i class="icon-settings"></i>
                </th>
            </tr>
            </thead>
            <tbody v-if="hasCategories">
            <tr :class="{'table-danger':model.deleted_at}" v-for="model in getCategories" :key="model.id">
                <td scope="row">{{model.id}}</td>
                <td>
                    <span class="badge">{{model.name}}</span>
                </td>
                <td class="text-center">
                    <form method="POST" @submit="handleSubmitDelete($event, model)" accept-charset="UTF-8">
                        <button type="button" title="Editar" :disabled="model.deleted_at" @click="selectedObject(model)" class="btn btn-outline-warning btn-sm">
                            <i class="icon-note"></i>
                        </button>
                        <button v-if="!model.deleted_at" title="Eliminar" type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar este elemento?')" class="btn btn-outline-danger btn-sm">
                            <i class="icon-trash"></i>
                        </button>
                        <button v-else title="Restaurar" type="button" class="btn btn-success btn-sm" @click="restore(model)">
                            <i class="icon-refresh"></i>
                        </button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
        <section v-if="hasCategories" class="col-lg-12 col-sm-12 col-md-12 col-xs-12 center-block text-center d-flex justify-content-center">
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
import {orderBy} from 'lodash'
export default {
    props: {},
    data: function () {
        return {
            opacity: 0.3,
            model: "categories",
            model_name: 'categoría'
        };
    },
    created() {},
    mounted() {
        this.fetch();
    },
    computed: {
        ...mapGetters(["categories", "isLoading", "page"]),
        page: {
            set(val) {
                this.$store.state.page = val;
            },
            get() {
                return this.$store.state.page;
            },
        },
        hasCategories() {
            return Boolean(this.categories.data);
        },
        getCategories() {
            return this.orderedObjects();
        },
        getLastPage: function () {
            return this.categories.last_page;
        },
        getTotal: function () {
            return this.categories.total;
        },
    },
    components: {
        Loading,
    },
    methods: {
        orderedObjects: function () {
            return orderBy(this.categories.data, "id");
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
                })
                .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },

       async selectedObject(model) {
           await this.$store.commit("SET_SELECTED_CATEGORY", {
                id: model.id,
                name: model.name,
                slug: model.slug,
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
