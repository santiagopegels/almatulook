<template>
	<div class="table-responsive">
		<loading
			:opacity="opacity"
			loader="spinner"
			transition="fade"
			:active.sync="isLoading"
			:can-cancel="false"
			:is-full-page="true"
			color="#20a8d8"
			background-color="rgba(0,0,0,0.8)"
		></loading>
		<table id="shipmentTypes-table" class="table table-condensed table-striped table-hover">
			<thead class="thead-dark">
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Tipo de Envío</th>
					<th scope="col">Descripción</th>
					<th scope="col">Costo</th>
                    <th scope="col">Requiere Dirección</th>
                    <th scope="col" class="text-center">
						<i class="icon-settings"></i>
					</th>
				</tr>
			</thead>
			<tbody v-if="hasShipmentTypes">
				<tr :class="{'table-danger':model.deleted_at}" v-for="model in getShipmentTypes" :key="model.id">
					<td scope="row">{{model.id}}</td>
					<td>{{model.name}}</td>
					<td>
						<span class="badge">{{model.description}}</span>
					</td>
					<td>{{model.cost | currency}}</td>
                    <td>{{model.address_required ? 'Si' : 'No'}}</td>
                    <td class="text-center">
						<form method="POST" @submit="handleSubmitDelete($event, model)" accept-charset="UTF-8">
							<div>
								<button
									title="Editar"
									:disabled="model.deleted_at"
									type="button"
									@click="selectedShipmentType(model)"
									class="btn btn-outline-warning btn-sm"
								>
									<i class="fa fa-edit"></i>
								</button>
								<button
									v-if="!model.deleted_at"
									title="Eliminar"
									type="submit"
									onclick="return confirm('¿Estás seguro de que quieres eliminar este elemento?')"
									class="btn btn-outline-danger btn-sm"
								>
									<i class="fa fa-trash"></i>
								</button>
								<button
									v-else
									title="Restaurar"
									type="button"
									class="btn btn-success btn-sm"
									@click="restore(model)"
								>
									<i class="fa fa-refresh"></i>
								</button>
							</div>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
		<section
			v-if="hasShipmentTypes"
			class="col-lg-12 col-sm-12 col-md-12 col-xs-12 center-block text-center d-flex justify-content-center"
		>
			<paginate
				v-model="page"
				:page-count="getLastPage"
				:page-range="5"
				:margin-pages="2"
				:click-handler="clickCallback"
				:prev-text="'&laquo;'"
				:next-text="'&raquo;'"
				:container-class="'pagination'"
				:page-class="'page-item'"
				:page-link-class="'page-link'"
				:prev-class="'page-item'"
				:next-class="'page-item'"
				:prev-link-class="'page-link'"
				:next-link-class="'page-link'"
				:active-class="'active'"
			></paginate>
		</section>
	</div>
</template>

<script>
import { mapGetters } from "vuex";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
	props: {},
	data: function () {
		return {
			opacity: 0.3,
			model: "shipment_types",
            model_name: 'tipo de envío'
		};
	},
	created() {},
	mounted() {
		this.fetch();
	},
	computed: {
		...mapGetters([
			"shipmentTypes",
			"isLoading",
			"page",
		]),
		page: {
			set(val) {
				this.$store.state.page = val;
			},
			get() {
				return this.$store.state.page;
			},
		},
		hasShipmentTypes() {
			return Boolean(this.shipmentTypes.data);
		},
		getShipmentTypes() {
			return this.orderedShipmentTypes();
		},
		getLastPage: function () {
			return this.shipmentTypes.last_page;
		},
		getTotal: function () {
			return this.shipmentTypes.total;
		},
	},
	components: {
		Loading,
	},
	methods: {
		async handleSubmitDelete(e, data) {
			e.preventDefault();

			if (!data.id > 0) {
				return;
			}

			await this.delete(data);
		},

        async fetch() {
            await this.$store.dispatch("fetch", {
                model: this.model,
                page: this.page
            })
            .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },

        async delete(model) {
            await this.$store.dispatch("delete", {
                _method: 'DELETE',
                model: this.model,
                data: model
            })
            .then(async result => {
				this.$toasted.global.ToastedSuccess({ message: `El ${this.model_name} fue eliminado!` });
				await this.fetch();
			})
            .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },

        async restore(data) {
            await this.$store.dispatch("restore", {
                model: this.model,
                data: data
            })
            .then(async result => {
				this.$toasted.global.ToastedSuccess({ message: `El ${this.model_name} fue restaurado!` });
				await this.fetch();
			})
            .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },

		orderedShipmentTypes: function () {
			return _.orderBy(this.shipmentTypes.data, "id");
		},

		async selectedShipmentType(model) {
			await this.$store.commit("SET_SELECTED_SHIPMENT_TYPE", {
				id: model.id,
				name: model.name,
				description: model.description,
                cost: model.cost,
                addressRequired: model.address_required,
            });
		},

		/**
		 * Event on click paging callback
		 */
		async clickCallback(pageNum) {
			this.page = pageNum;
			await this.fetch();
		},
	},
};
</script>
