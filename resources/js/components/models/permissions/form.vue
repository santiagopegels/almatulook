<template>
<div v-if="hasId" :class="{'card card-accent-warning':hasId, 'card card-accent-primary':!hasId}">
    <div class="card-header">
        <i :class="{'icon-settings':hasId, 'icon-plus':!hasId}"></i>
        {{getTitle}}
        <span class="float-right">
            <span v-if="hasId" class="badge badge-warning">
                ID
                <strong>{{selected_permission.id}}</strong>
            </span>
            <span v-if="hasId" class="ml-1">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="cancelSelectedPermission()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </span>
        </span>
    </div>
    <div class="card-body">
        <form method="POST" @submit="handleSubmit" accept-charset="UTF-8">

            <div class="form-group d-none">
                <input type="hidden" v-model="selected_permission.name" id="name" name="name" v-lowercase v-hyphenate class="form-control" readonly :class="{ 'is-invalid': submitted && $v.selected_permission.name.$error }" />
            </div>

            <div class="form-group">
                <label for="name">Nombre del permiso</label>
                <input type="text" v-model="selected_permission.display_name" v-capitalize id="display_name" name="display_name" class="form-control" :class="{ 'is-invalid': submitted && $v.selected_permission.display_name.$error }" @input="changeDisplayName" />
                <div v-if="submitted && !$v.selected_permission.display_name.required" class="invalid-feedback">El nombre del permiso es requerido.</div>
            </div>

            <div class="form-group">
                <label for="name">Descripción</label>
                <input type="text" v-model="selected_permission.description" v-capitalize id="description" name="description" class="form-control" :class="{ 'is-invalid': submitted && $v.selected_permission.description.$error }" />
                <div v-if="submitted && !$v.selected_permission.description.required" class="invalid-feedback">La descripción es requerida.</div>
            </div>

            <div class="form-group">
                <div>
                    <button type="submit" :class="{invalid:$v.$invalid, 'btn btn-warning btn-block':hasId, 'btn btn-success btn-block':!hasId}">{{buttonText}}</button>
                    <button type="button" class="btn btn-secondary btn-block" @click="cancelSelectedPermission()">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
</template>

<script>
import {
    mapGetters
} from "vuex";
import {
    required,
    minLength,
    integer,
} from "vuelidate/lib/validators";
export default {
    props: {},
    data: function () {
        return {
            submitted: false,
            model: 'permissions',
            model_name: 'permiso'
        };
    },
    validations() {
        if (this.hasSelectedId()) {
            return {
                selected_permission: {
                    id: {
                        required,
                        integer
                    },
                    name: {
                        required,
                        minLength: minLength(2)
                    },
                    display_name: {
                        required,
                        minLength: minLength(2)
                    },
                    description: {
                        minLength: minLength(2)
                    },
                },
            };
        } else {
            return {
                selected_permission: {
                    name: {
                        required,
                        minLength: minLength(2)
                    },
                    display_name: {
                        required,
                        minLength: minLength(2)
                    },
                    description: {
                        minLength: minLength(2)
                    },
                },
            };
        }
    },

    created() {},
    mounted() {},
    computed: {
        ...mapGetters(["isLoading", "selected_permission", "page"]),
        hasId() {
            return Boolean(this.hasSelectedId());
        },
        getTitle() {
            return this.hasSelectedId() ?
                "Editar permiso" :
                "Crear nuevo permiso";
        },

        buttonText() {
            return this.hasSelectedId() ?
                "Actualizar permiso" :
                "Crear permiso";
        },
    },
    methods: {
        hasSelectedId() {
            if (!Boolean(this.selected_permission)) return false;
            return Boolean(this.selected_permission.id > 0);
        },

        changeDisplayName(event) {
            this.selected_permission.name = this.hyphenate(event.target.value);
        },

        hyphenateName() {
            this.selected_permission.name = this.hyphenate(
                this.selected_permission.display_name
            );
        },

        handleSubmit(e) {
            e.preventDefault();
            this.submitted = true;
            this.$v.$touch();
            if (this.$v.$invalid) return;

            if (this.hasSelectedId()) {
                this.update();
            } else {
                this.store();
            }
        },
        async store() {
            await this.$store.dispatch("store", {
                model: this.model,
                data: {
                    name: this.hyphenate(this.selected_permission.name),
                    display_name: this.selected_permission.display_name,
                    description: this.selected_permission.description,
                    user_roles_permissions_selected: this.selected_permission
                        .user_roles_permissions_selected,
                }
            })
            .then(async result => {
				this.$v.$reset();
				this.$toasted.global.ToastedSuccess({ message: `El ${this.model_name} fue creado!` });
				await this.fetch();
			})
            .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },
        async update() {
            await this.$store.dispatch("update", {
                model: this.model,
                data: {
                    _method: "PUT",
                    id: this.selected_permission.id,
                    name: this.hyphenate(this.selected_permission.name),
                    display_name: this.selected_permission.display_name,
                    description: this.selected_permission.description,
                    user_roles_permissions_selected: this.selected_permission
                        .user_roles_permissions_selected,
                }
            })
            .then(async result => {
				this.$v.$reset();
				this.$toasted.global.ToastedSuccess({ message: `El ${this.model_name} fue actualizado!` });
				await this.fetch();
			})
            .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },

        async fetch() {
            await this.$store.dispatch("fetch", {
                model: this.model,
                page: this.page
            })
            .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },

        async cancelSelectedPermission() {
            this.$v.$reset();
            this.$store.commit("SET_SELECTED_PERMISSION");
        },

        hyphenate(string) {
            if (!string) return;
            return string.replace(/[^a-zA-Z0-9]/g, "_").toLowerCase();
        },
    },
};
</script>
