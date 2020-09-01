<template>
<div :class="{'card card-accent-warning':hasId, 'card card-accent-primary':!hasId}">
    <div class="card-header">
        <i class="icon-user-follow" :class="{'icon-settings':hasId, 'icon-plus':!hasId}"></i>
        {{getTitle}}
        <span class="float-right">
            <span v-if="hasId" class="badge badge-warning">
                ID
                <strong>{{selected_user.id}}</strong>
            </span>
            <span v-if="hasId" class="ml-1">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="cancelSelectedUser()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </span>
        </span>
    </div>
    <div class="card-body">
        <form method="POST" @submit="handleSubmit" accept-charset="UTF-8">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" v-model="selected_user.name" id="name" name="name" class="form-control" placeholder="Ingrese el nombre" :class="{ 'is-invalid': submitted && $v.selected_user.name.$error }" />
                <div v-if="submitted && !$v.selected_user.name.required" class="invalid-feedback">El nombre es requerido.</div>
            </div>

            <div class="form-group">
                <label for="name">Correo electrónico</label>
                <input type="email" v-model="selected_user.email" id="email" name="email" class="form-control" placeholder="Ingrese el correo electrónico" :class="{ 'is-invalid': submitted && $v.selected_user.email.$error }" />
                <div v-if="submitted && !$v.selected_user.email.required" class="invalid-feedback">El correo electrónico es requido.</div>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" v-model="selected_user.password" id="password" name="password" autocomplete="new-password" class="form-control" placeholder="Ingrese la contraseña" :class="{ 'is-invalid': submitted && $v.selected_user.password.$error }" />
                <div v-if="submitted && !$v.selected_user.password.minLength" class="invalid-feedback">La contraseña debe tener al menos {{ $v.selected_user.password.$params.minLength.min }} caracteres.</div>

                <small class="form-text text-muted">Modificar únicamente si desea cambiar la constraseña del usuario.</small>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmación de contraseña</label>
                <input type="password" v-model="selected_user.password_confirmation" id="password_confirmation" name="password_confirmation" class="form-control" :class="{ 'is-invalid': submitted && $v.selected_user.password_confirmation.$error }" />
                <div v-if="submitted && !$v.selected_user.password_confirmation.sameAsPassword" class="invalid-feedback">Las contraseñas no coinciden.</div>
            </div>

            <div class="form-group">
              <hr/>
                <h5 class="text-center">Datos del Perfil</h5>
              <hr/>
            </div>

            <div class="form-group">
              <label for="first_name">Nombre</label>
              <input type="text" v-model="selected_user_profile.firstName" id="first_name" name="first_name" class="form-control" placeholder="Ingrese el nombre" :class="{ 'is-invalid': submitted && $v.selected_user_profile.firstName.$error }" />
              <div v-if="submitted && !$v.selected_user_profile.firstName.required" class="invalid-feedback">El nombre es requerido.</div>
            </div>

            <div class="form-group">
              <label for="name">Apellido</label>
              <input type="text" v-model="selected_user_profile.lastName" id="last_name" name="last_name" class="form-control" placeholder="Ingrese el apellido" :class="{ 'is-invalid': submitted && $v.selected_user_profile.lastName.$error }" />
              <div v-if="submitted && !$v.selected_user_profile.lastName.required" class="invalid-feedback">El apellido es requerido.</div>
            </div>

            <div class="form-group">
              <label for="name">Teléfono</label>
              <input type="text" v-model="selected_user_profile.phoneNumber" id="phone_number" name="phone_number" class="form-control" placeholder="Ingrese el teléfono" :class="{ 'is-invalid': submitted && $v.selected_user_profile.phoneNumber.$error }" />
              <div v-if="submitted && !$v.selected_user_profile.phoneNumber.required" class="invalid-feedback">El teléfono es requerido.</div>
            </div>

            <div class="form-group">
              <label for="name">Dirección</label>
              <input type="text" v-model="selected_user_profile.deliveryAddress" id="delivery_address" name="delivery_address" class="form-control" placeholder="Ingrese la dirección" :class="{ 'is-invalid': submitted && $v.selected_user_profile.deliveryAddress.$error }" />
              <div v-if="submitted && !$v.selected_user_profile.deliveryAddress.required" class="invalid-feedback">El dirección es requerida.</div>
            </div>

            <roles-checkbox />

            <div class="form-group">
                <div>
                    <button type="submit" :class="{invalid:$v.$invalid, 'btn btn-warning btn-block':hasId, 'btn btn-success btn-block':!hasId}">{{buttonText}}</button>
                    <button type="button" class="btn btn-secondary btn-block" @click="cancelSelectedUser()">Cancelar</button>
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
            model: 'users',
            model_name: 'usuario'
        };
    },
    validations() {
        if (this.hasSelectedUserId()) {
            return {
                selected_user: {
                    id: {
                        integer
                    },
                    name: {
                        required,
                        minLength: minLength(3)
                    },
                    email: {
                        required,
                        email
                    },
                    password: {
                        minLength: minLength(4)
                    },
                    password_confirmation: {
                        sameAsPassword: sameAs("password"),
                    },
                },
                selected_user_profile: {
                  firstName: {
                    required,
                    minLength: minLength(3)
                  },
                  lastName: {
                    required,
                    minLength: minLength(3)
                  },
                  phoneNumber: {
                    required
                  },
                  deliveryAddress: {
                    required
                  },
                },
            };
        } else {
            return {
                selected_user: {
                    name: {
                        required,
                        minLength: minLength(3)
                    },
                    email: {
                        required,
                        email
                    },
                    password: {
                        required,
                        minLength: minLength(4)
                    },
                    password_confirmation: {
                        required,
                        sameAsPassword: sameAs("password"),
                    },
                },
                selected_user_profile: {
                  firstName: {
                    required,
                    minLength: minLength(3)
                  },
                  lastName: {
                    required,
                    minLength: minLength(3)
                  },
                  phoneNumber: {
                    required
                  },
                  deliveryAddress: {
                    required
                  },
                },
            };
        }
    },

    created() {},
    mounted() {},
    computed: {
        ...mapGetters(["isLoading", "selected_user", "selected_user_profile", "users", "page"]),
        hasSelectedUser() {
            return Boolean(this.selected_user);
        },
        hasId() {
            return Boolean(this.hasSelectedUserId());
        },
        getTitle() {
            return this.hasSelectedUserId() ?
                "Editar usuario" :
                "Crear nuevo usuario";
        },

        buttonText() {
            return this.hasSelectedUserId() ?
                "Actualizar usuario" :
                "Crear usuario";
        },
        hasRoles() {
            return this.hasSelectedUserRoles();
        },
    },
    methods: {
        hasSelectedUserId() {
            if (!Boolean(this.selected_user)) return false;
            return Boolean(this.selected_user.id > 0);
        },
        hasSelectedUserRoles() {
            if (!Boolean(this.selected_user)) return false;
            return Boolean(this.selected_user.roles);
        },

        async handleSubmit(e) {
            e.preventDefault();
            this.submitted = true;
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            if (this.hasSelectedUserId()) {
                await this.update();
            } else {
                await this.store();
            }
        },
        async store() {
            await this.$store.dispatch("store", {
                model: this.model,
                data: {
                    name: this.selected_user.name,
                    email: this.selected_user.email,
                    password: this.selected_user.password,
                    password_confirmation: this.selected_user.password_confirmation,
                    rolesIds: this.selected_user.rolesIds,
                    profile: {
                      first_name: this.selected_user_profile.firstName,
                      last_name: this.selected_user_profile.lastName,
                      phone_number: this.selected_user_profile.phoneNumber,
                      delivery_address: this.selected_user_profile.deliveryAddress,
                    }
                }
            })
            .then(async result => {
              this.$store.commit("SET_SELECTED_USER_PROFILE");
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
                    id: this.selected_user.id,
                    name: this.selected_user.name,
                    email: this.selected_user.email,
                    password: this.selected_user.password,
                    password_confirmation: this.selected_user.password_confirmation,
                    rolesIds: this.selected_user.rolesIds,
                }
            })
            .then(async result => {
              await this.$store.dispatch("update", {
                model: 'profiles',
                data: {
                  _method: "PUT",
                  id: this.selected_user_profile.id,
                  first_name: this.selected_user_profile.firstName,
                  last_name: this.selected_user_profile.lastName,
                  phone_number: this.selected_user_profile.phoneNumber,
                  delivery_address: this.selected_user_profile.deliveryAddress,
                }
              })
			      })
             .then(async result => {
               this.$store.commit("SET_SELECTED_USER_PROFILE");
               this.$v.$reset();
               this.$toasted.global.ToastedSuccess({ message: `El ${this.model_name} fue actualizado!` });
               await this.fetch();
            })
            .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },

        async cancelSelectedUser() {
            this.$store.commit("SET_SELECTED_USER");
            this.$store.commit("SET_SELECTED_USER_PROFILE");
            this.$v.$reset();
        },

        async fetch() {
            await this.$store.dispatch("fetch", {
                model: this.model,
                page: this.page
            })
            .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },
    },
};
</script>
