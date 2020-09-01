<template>
<div class="card card-accent-primary" v-if="!selected_permission.id">
    <div class="card-header">
        <i class="icon-plus"></i>
        Crear permisos
    </div>
    <div class="card-body">
        <form method="POST" @submit="handleSubmit" accept-charset="UTF-8" id>
            <div class="form-group">
                <label for="name">Nombre del módulo</label>
                <input type="text" v-model="model.display_name" v-capitalize id="display_name" name="display_name" class="form-control" placeholder="Usuarios, Roles, Eventos, etc." :class="{ 'is-invalid': submitted && $v.model.display_name.$error }" />
                <div v-if="submitted && !$v.model.display_name.required" class="invalid-feedback">El nombre del módulo es requerido.</div>
            </div>

            <div class="form-group">
                <label for="type">Tipo de permisos</label>
                <div>
                    <div class="form-check form-check-inline mr-4 mb-2 mb-2 pointer" v-for="type in getTypes()" :key="type.key">
                        <input class="form-check-input pointer" type="checkbox" name="permissionsKeys" v-model="model.permissionsKeys" :class="{ 'is-invalid': submitted && $v.model.permissionsKeys.$error }" :id="type.key" :value="type.key" />
                        <label class="form-check-label pointer" :for="type.key">{{type.value}}</label>
                    </div>
                    <div v-if="submitted && !$v.model.permissionsKeys.required" class="invalid-feedback">Debes seleccionar al menos 1 opción.</div>
                </div>
            </div>

            <div class="form-group">
                <div>
                    <button type="submit" class="btn btn-success btn-block">Crear nuevo permiso</button>
                    <button type="reset" @click="cancelSelectedPermission()" class="btn btn-secondary btn-block">Cancelar</button>
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
    email,
    minLength,
    sameAs,
    integer,
} from "vuelidate/lib/validators";
export default {
    props: {},
    data: function () {
        return {
            submitted: false,
            model: {
                display_name: null,
                permissionsKeys: [],
            },
            model_type: 'permissions',
            model_name: 'permiso'
        };
    },
    validations() {
        return {
            model: {
                display_name: {
                    required,
                    minLength: minLength(2)
                },
                permissionsKeys: {
                    required
                },
            },
        };
    },

    created() {},
    mounted() {},
    computed: {
        ...mapGetters(["isLoading", "selected_permission", "page"]),
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault();
            this.submitted = true;
            this.$v.$touch();
            if (this.$v.$invalid) return;
            this.store();
        },
        async getData() {
            var permissions = [];
            this.model.permissionsKeys.forEach((element) => {
                permissions.push({
                    name: null,
                    display_name: this.capitalize(
                        `${element} ${this.model.display_name}`
                    ),
                    description: null,
                });
            });
            return permissions;
        },
        async store() {
            await this.$store.dispatch("store", {
				model: this.model_type,
				data: await this.getData(),
				additional_path: 'stores',
			})
			.then(async result => {
				this.$v.$reset();
				this.$toasted.global.ToastedSuccess({
					message: `El ${this.model_name} fue creado!`
				});
				this.cancelSelectedPermission();
				await this.fetch();
			})
			.catch(error => this.$toasted.global.ToastedError({
				message: error.message.message
			}));
        },

        async fetch() {
            await this.$store.dispatch("fetch", {
				model: this.model_type,
				page: this.page
			})
			.catch(error => this.$toasted.global.ToastedError({
				message: error.message.message
			}));
        },

        clearFields() {
            this.model = {
                display_name: null,
                permissionsKeys: [],
            };
        },

        async cancelSelectedPermission() {
            this.$v.$reset();
            this.clearFields();
        },

        hyphenate(string) {
            if (!string) return;
            return string.replace(/[^a-zA-Z0-9]/g, "_").toLowerCase();
        },

        capitalize(value) {
            return value.charAt(0).toUpperCase() + value.slice(1);
        },

        getTypes() {
            return [{
                    key: "crear",
                    value: "Crear",
                },
                {
                    key: "leer",
                    value: "Leer",
                },
                {
                    key: "actualizar",
                    value: "Actualizar",
                },
                {
                    key: "borrar",
                    value: "Borrar",
                },
            ];
        },
    },
};
</script>
