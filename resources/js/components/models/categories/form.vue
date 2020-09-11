<template>
    <div :class="{'card card-accent-warning':hasId, 'card card-accent-primary':!hasId}">
        <div class="card-header">
            <i :class="{'icon-settings':hasId, 'icon-plus':!hasId}"></i>
            {{ getTitle }}
            <span class="float-right">
                <button v-if="hasId && !selected_category.deleted_at" title="Eliminar" type="submit"
                        @click="deleteCategory(selected_category)"
                        class="btn btn-outline-danger btn-sm mr-2">
                        <i class="fa fa-trash"></i>
                </button>
            <span v-if="hasId" class="badge badge-warning">
                ID
                <strong>{{ selected_category.id }}</strong>
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
                    <input type="text" v-model="selected_category.name" v-capitalize id="name" name="name"
                           class="form-control" placeholder="Remeras, Vestidos, etc."
                           :class="{ 'is-invalid': submitted && $v.selected_category.name.$error }"/>
                    <div v-if="submitted && !$v.selected_category.name.required" class="invalid-feedback">El nombre de
                        la
                        categoría es requerido.
                    </div>
                </div>
                <categories-subcategories ref="treeview"
                                          :validate="submitted"
                                          :subcategories="this.selected_category.children">

                </categories-subcategories>
                <attributes-checkbox></attributes-checkbox>
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
            model: "categories",
            model_name: 'categoría',
            children: []
        };
    },
    validations() {
        if (this.hasSelectedId()) {
            return {
                selected_category: {
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
                selected_category: {
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
        ...mapGetters(["isLoading", "categoriesAll","selected_category", "page"]),
        hasId() {
            return Boolean(this.hasSelectedId());
        },
        getTitle() {
            return this.hasSelectedId() ?
                "Editar Categoría" :
                "Crear Categoría";
        },

        buttonText() {
            return this.hasSelectedId() ?
                "Actualizar Categoría" :
                "Crear Categoría";
        },
    },
    methods: {
        hasSelectedId() {
            if (!Boolean(this.selected_category)) return false;
            return Boolean(this.selected_category.id > 0);
        },

        async handleSubmit(e) {
            e.preventDefault();
            this.submitted = true;
            this.$v.$touch();
            if (this.$refs.treeview.$v.$invalid) return;
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
            await this.$store.dispatch("storeAll", {
                model: this.model,
                data: {
                    id: this.selected_category.id,
                    name: this.selected_category.name,
                    slug: this.hyphenate(this.selected_category.name),
                    icon: 'icon-tag',
                    children: await this.copyNameToSlug(this.selected_category.children)
                }
            })
                .then(async result => {
                    this.$v.$reset();
                    this.$emit('newRootNode', result.message)
                    this.$toasted.global.ToastedSuccess({message: `La ${this.model_name} fue creada!`});
                    await this.fetch();
                })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.response.data.errors.name}));
        },

        async update() {
            await this.$store.dispatch("update", {
                model: this.model,
                data: {
                    _method: "PUT",
                    id: this.selected_category.id,
                    name: this.selected_category.name,
                    slug: this.hyphenate(this.selected_category.name),
                    children: await this.copyNameToSlug(this.selected_category.children)
                }
            })
                .then(async result => {
                    this.$v.$reset();
                    const childrenUpdated = result.message.children
                    await this.setIdToCategoryAfterCreateOrUpdate(childrenUpdated)
                    this.$toasted.global.ToastedSuccess({message: `La ${this.model_name} fue actualizada!`});
                    await this.fetch();
                })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        async copyNameToSlug(children) {
            for (let i = 0; i < children.length; i++) {
                children[i].slug = this.hyphenate(children[i].name)
            }
            return children
        },


        async cancelSelectedObject() {
            this.submitted = false;
            this.$v.$reset();
            let children = await this.selected_category.children
            this.selected_category.children = await children.map(function (subcategory, index) {
                return subcategory.id === 0 ? index : -1;
            }).filter(function (index) {
                return index >= 0;
            }).reverse().forEach(function (index) {
                children.splice(index, 1);
            });
            return this.$store.commit("SET_SELECTED_CATEGORY");
        },

        hyphenate(string) {
            if (!string) return;
            return string.replace(/[^a-zA-Z0-9]/g, "_").toLowerCase();
        },

        clearFields() {
            this.selected_category.name = null,
                this.selected_category.slug = null
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

        async deleteCategory(model) {
            await this.$store.dispatch("delete", {
                _method: 'DELETE',
                model: this.model,
                data: model
            })
                .then(async result => {
                    this.$toasted.global.ToastedSuccess({message: `La ${this.model_name} fue eliminada!`});
                    this.$store.commit('REMOVE_CATEGORY_FROM_ALL', model)
                })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

       async setIdToCategoryAfterCreateOrUpdate(childrenUpdated){
           await this.selected_category.children.forEach((child) => {
               if (child.id === 0) {
                   childrenUpdated.forEach(childUpdated => {
                       if (childUpdated.name === child.name) {
                           child.id = childUpdated.id
                       }
                   })
               }
           })
        },

    },
};
</script>
