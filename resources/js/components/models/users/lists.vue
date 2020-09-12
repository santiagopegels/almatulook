<template>
<div class="table-responsive">
    <loading :opacity="opacity" loader="spinner" transition="fade" :active.sync="isLoading" :can-cancel="false" :is-full-page="true" color="#20a8d8" background-color="rgba(0,0,0,0.8)"></loading>
    <table id="users-table" class="table table-condensed table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo electrónico</th>
                <th scope="col" class="text-center">
                    <i class="icon-settings"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr :class="{'table-danger':model.deleted_at}" v-for="model in getUsers" :key="model.id">
                <td scope="row">{{model.id}}</td>
                <td>{{model.name}}</td>
                <td>{{model.email}}</td>
                <td class="text-center">
                    <form method="POST" @submit="handleSubmitDelete($event, model)" accept-charset="UTF-8">
                        <button type="button" title="Editar" :disabled="model.deleted_at" @click="selectedUser(model)" class="btn btn-outline-warning btn-sm">
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
            <tr v-if="!isLoading && !hasUsers">
                <td colspan="4" class="text-center text-dark">No hay datos disponibles</td>
            </tr>
        </tbody>
    </table>
    <section v-if="hasUsers" class="col-lg-12 col-sm-12 col-md-12 col-xs-12 center-block text-center d-flex justify-content-center">
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
            opacity: 0.7,
            model: 'users',
            model_name: 'usuario'
        };
    },
    created() {},
    mounted() {
        this.fetch();
    },
    computed: {
        ...mapGetters(["users", "isLoading", "selected_user"]),
        page: {
            set(val) {
                this.$store.state.page = val;
            },
            get() {
                return this.$store.state.page;
            },
        },
        hasUsers() {
            return Boolean(this.users.data && this.users.data.length);
        },
        getUsers() {
            return this.orderedUsers();
        },
        getLastPage: function () {
            return this.users.last_page;
        },
        getTotal: function () {
            return this.users.total;
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

        async selectedUser(user) {
            await this.$store.commit("SET_SELECTED_USER", {
                method: "PUT",
                id: user.id,
                name: user.name,
                email: user.email,
                password: "",
                password_confirmation: "",
                rolesIds: await this.getRolesIds(user.roles),
            });
        },

        orderedUsers: function () {
            return _.orderBy(this.users.data, "id");
        },

        /**
         * Event on click paging callback
         */
        async clickCallback(pageNum) {
            this.page = pageNum;
            await this.fetch();
        },

        async getRolesIds(roles) {
            if (!roles) return [];
            return roles.map(function (role) {
                return role.id;
            });
        },
    },
};
</script>
