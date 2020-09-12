<template>
<div class="table-responsive">
    <loading :opacity="opacity" loader="spinner" transition="fade" :active.sync="isLoading" :can-cancel="false" :is-full-page="true" color="#20a8d8" background-color="rgba(0,0,0,0.8)"></loading>
    <table id="parameters-table" class="table table-condensed table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Parámetro</th>
                <th scope="col">Valor</th>
                <th scope="col" class="text-center">
                    <i class="icon-settings"></i>
                </th>
            </tr>
        </thead>
        <tbody v-if="hasParameters">
            <tr :class="{'table-danger':model.deleted_at}" v-for="model in getParameters" :key="model.id">
                <td scope="row">{{model.id}}</td>
                <td>{{model.parameter}}</td>
                <td>{{model.value}}</td>
                <td class="text-center">
                    <form method="POST" @submit="handleSubmitDelete($event, model)" accept-charset="UTF-8">
                        <button type="button" title="Editar" :disabled="model.deleted_at" @click="selectedParameter(model)" class="btn btn-outline-warning btn-sm">
                            <i class="fa fa-edit"></i>
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
    <section v-if="hasParameters" class="col-lg-12 col-sm-12 col-md-12 col-xs-12 center-block text-center d-flex justify-content-center">
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
            model: 'parameters',
            model_name: 'parámetro'
        };
    },
    created() {},
    mounted() {
        this.fetch();
    },
    computed: {
        ...mapGetters(["parameters", "isLoading", "selected_parameter", "page"]),
        page: {
            set(val) {
                this.$store.state.page = val;
            },
            get() {
                return this.$store.state.page;
            },
        },
        hasParameters() {
            return Boolean(this.parameters.data);
        },
        getParameters() {
            return this.orderedParameters();
        },
        getLastPage: function () {
            return this.parameters.last_page;
        },
        getTotal: function () {
            return this.parameters.total;
        },
    },
    components: {
        Loading,
    },
    methods: {

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

        orderedParameters: function () {
            return _.orderBy(this.parameters.data, "id");
        },

        selectedParameter(model) {
            this.$store.commit("SET_SELECTED_PARAMETER", {
                id: model.id,
                parameter: model.parameter,
                value: model.value,
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
