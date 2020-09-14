<template>
    <div v-if="hasId" :class="{'card card-accent-warning':hasId, 'card card-accent-primary':!hasId}">
        <div class="card-header">
            <i :class="{'icon-settings':hasId, 'icon-plus':!hasId}"></i>
            {{ getTitle }}
            <span class="float-right">
            <span v-if="hasId" class="badge badge-warning">
                ID
                <strong>{{ selected_parameter.id }}</strong>
            </span>
            <span v-if="hasId" class="ml-1">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        @click="cancelSelectedParameter()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </span>
        </span>
        </div>
        <div class="card-body">
            <form method="POST" @submit="handleSubmit" accept-charset="UTF-8">

                <div class="form-group">
                    <label for="value">Valor</label>
                    <input type="text" v-model="selected_parameter.value" id="value" name="value" class="form-control"
                           :class="{ 'is-invalid': submitted && $v.selected_parameter.value.$error }"
                           @input="changeValue"/>
                    <div v-if="submitted && !$v.selected_parameter.value.required" class="invalid-feedback">El valor es
                        requerido.
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <button type="submit"
                                :class="{invalid:$v.$invalid, 'btn btn-warning btn-block':hasId, 'btn btn-success btn-block':!hasId}">
                            {{ buttonText }}
                        </button>
                        <button type="button" class="btn btn-secondary btn-block" @click="cancelSelectedParameter()">
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
} from "vuelidate/lib/validators";

export default {
    props: {},
    data: function () {
        return {
            submitted: false,
            model: 'parameters',
            model_name: 'parámetro'
        };
    },
    validations() {
        return {
            selected_parameter: {
                value: {
                    required,
                },
            },
        };
    },

    created() {
    },
    mounted() {
    },
    computed: {
        ...mapGetters(["isLoading", "selected_parameter", "page"]),
        hasId() {
            return Boolean(this.hasSelectedId());
        },
        getTitle() {
            return this.hasSelectedId() ?
                "Editar parámetro" :
                "Crear nuevo parámetro";
        },

        buttonText() {
            return this.hasSelectedId() ?
                "Actualizar parámetro" :
                "Crear parámetro";
        },
    },
    methods: {
        hasSelectedId() {
            if (!Boolean(this.selected_parameter)) return false;
            return Boolean(this.selected_parameter.id > 0);
        },

        handleSubmit(e) {
            e.preventDefault();
            this.submitted = true;
            this.$v.$touch();
            if (this.$v.$invalid) return;

            if (this.hasSelectedId()) {
                this.update();
            }
        },

        async update() {
            await this.$store.dispatch("update", {
                model: this.model,
                data: {
                    _method: "PUT",
                    id: this.selected_parameter.id,
                    value: this.selected_parameter.value,
                }
            })
                .then(async result => {
                    this.$v.$reset();
                    this.$toasted.global.ToastedSuccess({message: `El ${this.model_name} fue actualizado!`});
                    await this.fetch();
                })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        async fetch() {
            await this.$store.dispatch("fetch", {
                model: this.model,
                page: this.page
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        async cancelSelectedParameter() {
            this.$v.$reset();
            this.$store.commit("SET_SELECTED_PARAMETER");
        },

        hyphenate(string) {
            if (!string) return;
            return string.replace(/[^a-zA-Z0-9]/g, "_").toLowerCase();
        },
    },
};
</script>
