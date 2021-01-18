<template>
	<div :class="{'card card-accent-warning':hasId, 'card card-accent-primary':!hasId}">
		<div class="card-header">
			<i class="icon-user-follow" :class="{'icon-settings':hasId, 'icon-plus':!hasId}"></i>
			{{getTitle}}
			<span class="float-right">
				<span v-if="hasId" class="badge badge-warning">
					ID
					<strong>{{selected_shipment_type.id}}</strong>
				</span>
				<span v-if="hasId" class="ml-1">
					<button
						type="button"
						class="close"
						data-dismiss="alert"
						aria-label="Close"
						@click="cancelSelectedShipmentType()"
					>
						<span aria-hidden="true">&times;</span>
					</button>
				</span>
			</span>
		</div>
		<div class="card-body">
			<form method="POST" @submit="handleSubmit" accept-charset="UTF-8">

				<div class="form-group">
					<label for="name">Tipo de Envío</label>
					<input
						type="text"
						v-model="selected_shipment_type.name"
						v-capitalize
						id="name"
						name="name"
						class="form-control"
						:class="{ 'is-invalid': submitted && $v.selected_shipment_type.name.$error }"
					/>
					<div
						v-if="submitted && !$v.selected_shipment_type.name.required"
						class="invalid-feedback"
					>El nombre del tipo de envío es requerido.</div>
				</div>

				<div class="form-group">
					<label for="description">Descripción</label>
					<input
						type="text"
						v-model="selected_shipment_type.description"
						v-capitalize
						id="description"
						name="description"
						class="form-control"
						:class="{ 'is-invalid': submitted && $v.selected_shipment_type.description.$error }"
					/>
				</div>

                <div class="form-group">
                    <label for="cost">Costo</label>
                    <input
                        type="text"
                        v-model="selected_shipment_type.cost"
                        v-capitalize
                        id="cost"
                        name="cost"
                        class="form-control"
                        :class="{ 'is-invalid': submitted && $v.selected_shipment_type.cost.$error }"
                    />
                    <div
                        v-if="submitted && !$v.selected_shipment_type.cost.required"
                        class="invalid-feedback"
                    >El costo es requerido.</div>
                </div>

				<div class="form-group">
					<div>
						<button
							type="submit"
							:class="{invalid:$v.$invalid, 'btn btn-warning btn-block':hasId, 'btn btn-success btn-block':!hasId}"
						>{{buttonText}}</button>
						<button
							type="button"
							class="btn btn-secondary btn-block"
							@click="cancelSelectedShipmentType()"
						>Cancelar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
import { mapGetters } from "vuex";
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
			model: 'shipment_types',
			model_name: 'tipo de envío'
		};
	},
	validations() {
		if (this.hasSelectedId()) {
			return {
				selected_shipment_type: {
					id: { required, integer },
					name: { minLength: minLength(2) },
					description: { minLength: minLength(2) },
                    cost: { required },
                },
			};
		} else {
			return {
				selected_shipment_type: {
					name: { required,minLength: minLength(2) },
					description: { minLength: minLength(2) },
                    cost: { required },
                },
			};
		}
	},

	created() {},
	mounted() {},
	computed: {
		...mapGetters(["isLoading", "selected_shipment_type", "page"]),
		hasId() {
			return Boolean(this.hasSelectedId());
		},
		getTitle() {
			return this.hasSelectedId() ? "Editar tipo de envío" : "Crear nuevo tipo de envío";
		},

		buttonText() {
			return this.hasSelectedId() ? "Actualizar tipo de envío" : "Crear tipo de envío";
		},
	},
	methods: {
		hasSelectedId() {
			if (!Boolean(this.selected_shipment_type)) return false;
			return Boolean(this.selected_shipment_type.id > 0);
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
					name: this.selected_shipment_type.name,
					description: this.selected_shipment_type.description,
                    cost: this.selected_shipment_type.cost,
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
					id: this.selected_shipment_type.id,
					name: this.selected_shipment_type.name,
					description: this.selected_shipment_type.description,
                    cost: this.selected_shipment_type.cost,
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

		async cancelSelectedShipmentType() {
			this.$store.commit("SET_SELECTED_SHIPMENT_TYPE");
			this.$v.$reset();
		},
	},
};
</script>
