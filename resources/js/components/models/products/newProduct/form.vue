<template>
    <div :class="{'card card-accent-warning':hasId, 'card card-accent-primary':!hasId}">
        <div class="card-header">
            <i :class="{'icon-settings':hasId, 'icon-plus':!hasId}"></i>
            {{ getTitle }}
            <span class="float-right">
            <span v-if="hasId" class="badge badge-warning">
                ID
                <strong>{{ selected_product.id }}</strong>
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
                    <input type="text" v-model="selected_product.name" v-capitalize id="name" name="name"
                           class="form-control"
                           :class="{ 'is-invalid': submitted && $v.selected_product.name.$error }"/>
                    <div v-if="submitted && !$v.selected_product.name.required" class="invalid-feedback">El nombre es requerido.
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Precio de Venta</label>
                    <currency-input
                                    :value="selected_product.price"
                                    v-model="selected_product.price"
                                    id="price"
                                    name="price"
                                    class="form-control"
                                    :class="{ 'is-invalid': submitted && $v.selected_product.price.$error }"/>
                    <div v-if="submitted && !$v.selected_product.price.required" class="invalid-feedback">El precio es requerido.
                    </div>
                    <div v-if="submitted && !$v.selected_product.price.decimal" class="invalid-feedback">El precio debe ser númerico.
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Precio de Costo</label>
                    <currency-input
                        :value="selected_product.cost_price"
                        v-model="selected_product.cost_price"
                        id="price"
                        name="price"
                        class="form-control"
                        :class="{ 'is-invalid': submitted && $v.selected_product.cost_price.$error }"/>
                    <div v-if="submitted && !$v.selected_product.cost_price.required" class="invalid-feedback">El precio es requerido.
                    </div>
                    <div v-if="submitted && !$v.selected_product.cost_price.decimal" class="invalid-feedback">El precio debe ser númerico.
                    </div>
                </div>

                <div class="form-group">
                    <label for="category">Categoría</label>
                    <v-select
                        id="category"
                        v-model="selected_product.categoryId"
                        :options="['Canada', 'United States']"
                    ></v-select>
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
    decimal,
} from "vuelidate/lib/validators";

export default {
    props: {},
    data: function () {
        return {
            submitted: false,
            model: "values",
            model_name: 'valor'
        };
    },
    validations() {
            return {
                selected_product: {
                    name: {
                        required
                    },
                    price: {
                        required,
                        decimal
                    },
                    cost_price: {
                        required,
                        decimal
                    },
                },
            };
    },

    created() {
    },
    mounted() {
    },
    computed: {
        ...mapGetters(["isLoading", "selected_product", "page"]),
        hasId() {
            return Boolean(this.hasSelectedId());
        },
        getTitle() {
            return this.hasSelectedId() ?
                "Editar Producto" :
                "Crear Producto";
        },

        buttonText() {
            return this.hasSelectedId() ?
                "Actualizar Producto" :
                "Crear Producto";
        },
    },
    methods: {
        hasSelectedId() {
            if (!Boolean(this.selected_product)) return false;
            return Boolean(this.selected_product.id > 0);
        },

        async handleSubmit(e) {
            e.preventDefault();
            this.submitted = true;
            this.$v.$touch();
            console.log(this.selected_product.price)
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
                    name: this.selected_product.name,
                    slug: this.hyphenate(this.selected_product.name),
                    attributesIds: this.selected_product.attributesIds
                }
            })
                .then(async result => {
                    this.$v.$reset();
                    this.$toasted.global.ToastedSuccess({message: `El ${this.model_name} fue creado!`});
                    await this.fetch();
                    await this.fetchAll();
                })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.response.data.errors.name}));
        },

        async update() {
            await this.$store.dispatch("update", {
                model: this.model,
                data: {
                    _method: "PUT",
                    id: this.selected_product.id,
                    name: this.selected_product.name,
                    slug: this.hyphenate(this.selected_product.name),
                    attributesIds: this.selected_product.attributesIds
                }
            })
                .then(async result => {
                    this.$v.$reset();
                    this.$toasted.global.ToastedSuccess({message: `El ${this.model_name} fue actualizado!`});
                    await this.fetch();
                    await this.fetchAll();
                })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        cancelSelectedObject() {
            this.$v.$reset();
            return this.$store.commit("SET_SELECTED_VALUE");
        },

        hyphenate(string) {
            if (!string) return;
            return string.replace(/[^a-zA-Z0-9]/g, "_").toLowerCase();
        },

        clearFields() {
            this.selected_product.name = null,
                this.selected_product.slug = null
        },

        async fetch() {
            await this.$store.dispatch("fetch", {
                model: this.model,
                page: this.page
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        async fetchAll() {
            await this.$store.dispatch("fetchAll", {
                model: this.model,
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
    },
};
</script>
