<template>
    <div :class="{'card card-accent-warning':hasId, 'card card-accent-primary':!hasId}">
        <div class="card-header">
            <i class="icon-user-follow" :class="{'icon-settings':hasId, 'icon-plus':!hasId}"></i>
            {{ getTitle }}
            <span class="float-right">
				<span v-if="hasId" class="badge badge-warning">
					ID
					<strong>{{ selected_order_status.id }}</strong>
				</span>
				<span v-if="hasId" class="ml-1">
					<button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close"
                        @click="cancelOrderStatus()"
                    >
						<span aria-hidden="true">&times;</span>
					</button>
				</span>
			</span>
        </div>
        <div class="card-body">
            <form method="POST" @submit="handleSubmit" accept-charset="UTF-8">

                <div class="form-group">
                    <label for="status">Estado</label>
                    <input
                        type="text"
                        v-model="selected_order_status.status"
                        v-capitalize
                        id="status"
                        name="status"
                        class="form-control"
                        :class="{ 'is-invalid': submitted && $v.selected_order_status.status.$error }"
                    />
                    <div
                        v-if="submitted && !$v.selected_order_status.status.required"
                        class="invalid-feedback"
                    >El nombre del estado es requerido.
                    </div>
                </div>

                <div class="form-group">
                    <label for="order">Orden</label>
                    <input
                        type="number"
                        v-model="selected_order_status.order"
                        v-capitalize
                        id="order"
                        name="order"
                        class="form-control"
                        :class="{ 'is-invalid': submitted && $v.selected_order_status.order.$error }"
                    />
                </div>

                <div class="form-check">
                    <input
                        type="checkbox"
                        v-model="selected_order_status.can_delete_order"
                        v-capitalize
                        id="deleteOrder"
                        name="deleteOrder"
                        class="form-check-input"
                        :class="{ 'is-invalid': submitted && $v.selected_order_status.can_delete_order.$error }"
                    />
                    <label for="deleteOrder">Borra orden de compra</label>
                </div>

                <div class="form-group">
                    <div>
                        <button
                            type="submit"
                            :class="{invalid:$v.$invalid, 'btn btn-warning btn-block':hasId, 'btn btn-success btn-block':!hasId}"
                        >{{ buttonText }}
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary btn-block"
                            @click="cancelOrderStatus()"
                        >Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
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
            model: 'status_orders',
            model_name: 'estado'
        };
    },
    validations() {
        if (this.hasSelectedId()) {
            return {
                selected_order_status: {
                    id: {required, integer},
                    status: {minLength: minLength(2)},
                    order: {integer},
                },
            };
        } else {
            return {
                selected_order_status: {
                    status: {minLength: minLength(2)},
                    order: {integer},
                },
            };
        }
    },

    created() {
    },
    mounted() {
    },
    computed: {
        ...mapGetters(["isLoading", "selected_order_status", "page"]),
        hasId() {
            return Boolean(this.hasSelectedId());
        },
        getTitle() {
            return this.hasSelectedId() ? "Editar estado" : "Crear nuevo estado";
        },

        buttonText() {
            return this.hasSelectedId() ? "Actualizar estado" : "Crear estado";
        },
    },
    methods: {
        hasSelectedId() {
            if (!Boolean(this.selected_order_status)) return false;
            return Boolean(this.selected_order_status.id > 0);
        },

        handleSubmit(e) {
            e.preventDefault();
            this.submitted = true;
            this.$v.$touch();
            if (this.$v.$invalid) return;

            if (this.hasSelectedId()) {
                return this.update();
            } else {
                return this.store();
            }
        },
        async store() {
            await this.$store.dispatch("store", {
                model: this.model,
                data: {
                    status: this.selected_order_status.status,
                    order: this.selected_order_status.order,
                    can_delete_order: this.selected_order_status.can_delete_order
                }
            })
                .then(async result => {
                    this.$v.$reset();
                    this.$toasted.global.ToastedSuccess({message: `El ${this.model_name} fue creado!`});
                    await this.fetch();
                })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },

        async update() {
            await this.$store.dispatch("update", {
                model: this.model,
                data: {
                    _method: "PUT",
                    id: this.selected_order_status.id,
                    status: this.selected_order_status.status,
                    order: this.selected_order_status.order,
                    can_delete_order: this.selected_order_status.can_delete_order
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

        async cancelOrderStatus() {
            this.$store.commit("SET_SELECTED_ORDER_STATUS");
            this.$v.$reset();
        },
    },
};
</script>
