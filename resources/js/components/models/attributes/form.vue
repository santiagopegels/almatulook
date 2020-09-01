<template>
    <div :class="{'card card-accent-warning':hasId, 'card card-accent-primary':!hasId}">
        <div class="card-header">
            <i :class="{'icon-settings':hasId, 'icon-plus':!hasId}"></i>
            {{ getTitle }}
            <span class="float-right">
            <span v-if="hasId" class="badge badge-warning">
                ID
                <strong>{{ selected_attribute.id }}</strong>
            </span>
            <span v-if="hasId" class="ml-1">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        @click="cancelSelectedObject()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </span>
        </span>
        </div>
        <div class="card-body">
            <form method="POST" @submit="handleSubmit" accept-charset="UTF-8">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" v-model="selected_attribute.name" v-capitalize id="name" name="name"
                           class="form-control" placeholder="Talle, Color etc."
                           :class="{ 'is-invalid': submitted && $v.selected_attribute.name.$error }"/>
                    <div v-if="submitted && !$v.selected_attribute.name.required" class="invalid-feedback">El nombre del
                        módulo es requerido.
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <button type="submit"
                                :class="{invalid:$v.$invalid, 'btn btn-warning btn-block':hasId, 'btn btn-success btn-block':!hasId}">
                            {{ buttonText }}
                        </button>
                        <button type="button" class="btn btn-secondary btn-block" @click="cancelSelectedObject()">
                            Cancelar
                        </button>
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
    integer,
} from "vuelidate/lib/validators";

export default {
    props: {},
    data: function () {
        return {
            submitted: false,
            model: "attributes",
            model_name: 'atributo'
        };
    },
    validations() {
        if (this.hasSelectedId()) {
            return {
                selected_attribute: {
                    id: {
                        required,
                        integer
                    },
                    name: {
                        required
                    },
                },
            };
        } else {
            return {
                selected_attribute: {
                    name: {
                        required
                    },
                },
            };
        }
    },

    created() {
    },
    mounted() {
    },
    computed: {
        ...mapGetters(["isLoading", "selected_attribute", "page"]),
        hasId() {
            return Boolean(this.hasSelectedId());
        },
        getTitle() {
            return this.hasSelectedId() ?
                "Editar Atributo" :
                "Crear Atributo";
        },

        buttonText() {
            return this.hasSelectedId() ?
                "Actualizar Atributo" :
                "Crear Atributo";
        },
    },
    methods: {
        hasSelectedId() {
            if (!Boolean(this.selected_attribute)) return false;
            return Boolean(this.selected_attribute.id > 0);
        },

        async handleSubmit(e) {
            e.preventDefault();
            this.submitted = true;
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            if (this.hasSelectedId()) {
                await this.update();
            } else {
                await this.store();
            }
        },
        async store() {
            await this.$store.dispatch("store", {
                model: this.model,
                data: {
                    name: this.selected_attribute.name,
                    slug: this.hyphenate(this.selected_attribute.name)
                }
            })
                .then(async result => {
                    this.$v.$reset();
                    this.$toasted.global.ToastedSuccess({message: `La ${this.model_name} fue creada!`});
                    await this.fetch();
                })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        async update() {
            await this.$store.dispatch("update", {
                model: this.model,
                data: {
                    _method: "PUT",
                    id: this.selected_attribute.id,
                    name: this.selected_attribute.name,
                    slug: this.hyphenate(this.selected_attribute.name)
                }
            })
                .then(async result => {
                    this.$v.$reset();
                    this.$toasted.global.ToastedSuccess({message: `La ${this.model_name} fue actualizada!`});
                    await this.fetch();
                })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        cancelSelectedObject() {
            this.$v.$reset();
            return this.$store.commit("SET_SELECTED_ATTRIBUTE");
        },

        capitalize(value) {
            return value.charAt(0).toUpperCase() + value.slice(1);
        },

        hyphenate(string) {
            if (!string) return;
            return string.replace(/[^a-zA-Z0-9]/g, "_").toLowerCase();
        },

        clearFields() {
            this.selected_attribute.name = null,
                this.selected_attribute.slug = null
        },

        async fetch() {
            await this.$store.dispatch("fetch", {
                model: this.model,
                page: this.page
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
    },
};
</script>
