<template>
	<form method="POST" @submit="handleSubmit" accept-charset="UTF-8">
		<div class="input-prepend input-group">
			<input
				v-model="term"
				id="prependedInput"
				class="form-control"
				size="16"
				type="text"
				placeholder="Buscar usuario por nombre o email"
			/>
			<span class="input-group-append">
				<button type="submit" :disabled="$v.$invalid" class="btn btn-outline-primary">
					<i class="icon-magnifier"></i> Buscar
				</button>
			</span>
			<span class="input-group-append" title="Quitar filtro">
				<button
					v-if="!$v.$invalid"
					type="button"
					:disabled="$v.$invalid"
					class="btn btn-outline-primary"
					@click="clearFilter()"
				>
					<i class="icon-close"></i>
				</button>
			</span>
			<!-- <div
				v-if="submitted && !$v.term.required"
				class="invalid-feedback"
			>El término de búsqueda es requerido.</div>  :class="{ 'is-invalid': submitted && $v.term.$error }"-->
		</div>
	</form>
</template>

<script>
import { mapGetters } from "vuex";
import { required, minLength } from "vuelidate/lib/validators";
export default {
	props: {},
	data: function () {
		return {
			submitted: false,
			term: "",
		};
	},
	validations() {
		return {
			term: { required, minLength: minLength(3) },
		};
	},

	created() {},
	mounted() {},
	computed: {},
	methods: {
		async handleSubmit(e) {
			e.preventDefault();
			this.submitted = true;
			this.$v.$touch();
			if (this.$v.$invalid) {
				return;
			}
			this.fetchUsers();
		},
		clearFilter() {
			this.term = "";
			this.fetchUsers();
		},
		async fetchUsers() {
			var params = {
				page: 1,
			};
			if (this.term.length >= 3) {
				params.term = this.term;
			}
			return this.$store.dispatch("fetchUsers", params);
		},
	},
};
</script>
