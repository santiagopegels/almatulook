<template>
	<div :class="{'card card-accent-warning':hasId, 'card card-accent-primary':!hasId}">
		<div class="card-header">
			<i class="icon-user-follow" :class="{'icon-settings':hasId, 'icon-plus':!hasId}"></i>
			{{getTitle}}
			<span class="float-right">
				<span v-if="hasId" class="badge badge-warning">
					ID
					<strong>{{selected_role.id}}</strong>
				</span>
				<span v-if="hasId" class="ml-1">
					<button
						type="button"
						class="close"
						data-dismiss="alert"
						aria-label="Close"
						@click="cancelSelectedRole()"
					>
						<span aria-hidden="true">&times;</span>
					</button>
				</span>
			</span>
		</div>
		<div class="card-body">
			<form method="POST" @submit="handleSubmit" accept-charset="UTF-8">
				<!-- <div class="form-group" v-if="hasId">
					<label for="name">ID</label>
					<strong class="form-control-plaintext">{{selected_role.id}}</strong>
				</div>-->

				<div class="form-group">
					<!-- <label for="name">Nombre</label> -->
					<input
						type="hidden"
						v-model="selected_role.name"
						id="name"
						name="name"
						class="form-control"
						readonly
						:class="{ 'is-invalid': submitted && $v.selected_role.name.$error }"
					/>
					<!-- <div
						v-if="submitted && !$v.selected_role.name.required"
						class="invalid-feedback"
					>El nombre es requerido.</div>-->
				</div>

				<div class="form-group">
					<label for="name">Nombre del rol</label>
					<input
						type="text"
						v-model="selected_role.display_name"
						v-capitalize
						id="display_name"
						name="display_name"
						class="form-control"
						:class="{ 'is-invalid': submitted && $v.selected_role.display_name.$error }"
						@input="changeDisplayName"
					/>
					<div
						v-if="submitted && !$v.selected_role.display_name.required"
						class="invalid-feedback"
					>El nombre del rol es requerido.</div>
				</div>

				<div class="form-group">
					<label for="name">Descripción</label>
					<input
						type="text"
						v-model="selected_role.description"
						v-capitalize
						id="description"
						name="description"
						class="form-control"
						:class="{ 'is-invalid': submitted && $v.selected_role.description.$error }"
					/>
					<div
						v-if="submitted && !$v.selected_role.description.required"
						class="invalid-feedback"
					>La descripción es requerida.</div>
				</div>

				<permissions-checkbox />

				<div class="form-group">
					<div>
						<button
							type="submit"
							:class="{invalid:$v.$invalid, 'btn btn-warning btn-block':hasId, 'btn btn-success btn-block':!hasId}"
						>{{buttonText}}</button>
						<button
							type="button"
							class="btn btn-secondary btn-block"
							@click="cancelSelectedRole()"
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
	components: {
        PermissionsCheckbox: () => import(/* webpackChunkName: "js/admin-roles" */ '../permissions/checkbox.vue')
    },
	data: function () {
		return {
			submitted: false,
			model: 'roles',
			model_name: 'rol'
		};
	},
	validations() {
		if (this.hasSelectedId()) {
			return {
				selected_role: {
					id: { required, integer },
					name: { minLength: minLength(2) },
					display_name: { required, minLength: minLength(2) },
					description: { minLength: minLength(2) },
				},
			};
		} else {
			return {
				selected_role: {
					name: { minLength: minLength(2) },
					display_name: { required, minLength: minLength(2) },
					description: { minLength: minLength(2) },
				},
			};
		}
	},

	created() {},
	mounted() {},
	computed: {
		...mapGetters(["isLoading", "selected_role", "page"]),
		hasId() {
			return Boolean(this.hasSelectedId());
		},
		getTitle() {
			return this.hasSelectedId() ? "Editar rol" : "Crear nuevo rol";
		},

		buttonText() {
			return this.hasSelectedId() ? "Actualizar rol" : "Crear rol";
		},
	},
	methods: {
		hasSelectedId() {
			if (!Boolean(this.selected_role)) return false;
			return Boolean(this.selected_role.id > 0);
		},

		changeDisplayName(event) {
			//this.selected_role.name = this.hyphenate(event.target.value);
		},

		hyphenateName() {
			this.selected_role.name = this.hyphenate(
				this.selected_role.display_name
			);
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
					name: this.hyphenate(this.selected_role.display_name),
					display_name: this.selected_role.display_name,
					description: this.selected_role.description,
					permissionsIds: this.selected_role.permissionsIds,
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
					id: this.selected_role.id,
					name: this.hyphenate(this.selected_role.display_name),
					display_name: this.selected_role.display_name,
					description: this.selected_role.description,
					permissionsIds: this.selected_role.permissionsIds
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

		async cancelSelectedRole() {
			this.$store.commit("SET_SELECTED_ROLE");
			this.$v.$reset();
		},

		hyphenate(string) {
			if (!string) return;
			return string.replace(/[^a-zA-Z0-9]/g, "-").toLowerCase();
		},
	},
};
</script>
