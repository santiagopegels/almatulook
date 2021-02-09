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
		<table id="orderStatus-table" class="table table-condensed table-striped table-hover">
			<thead class="thead-dark">
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Estado</th>
					<th scope="col">Orden</th>
                    <th scope="col">Borra Orden de Compra</th>
                    <th scope="col" class="text-center">
						<i class="icon-settings"></i>
					</th>
				</tr>
			</thead>
			<tbody v-if="hasOrdersStatus">
				<tr :class="{'table-danger':model.deleted_at}" v-for="model in getOrdersStatus" :key="model.id">
					<td scope="row">{{model.id}}</td>
					<td>{{model.status}}</td>
					<td>{{model.order}}</td>
                    <td>{{model.can_delete_order ? 'Si' : 'No'}}</td>
                    <td class="text-center">
						<form method="POST" @submit="handleSubmitDelete($event, model)" accept-charset="UTF-8">
							<div>
								<button
									title="Editar"
									:disabled="model.deleted_at"
									type="button"
									@click="selectedOrderStatus(model)"
									class="btn btn-outline-warning btn-sm"
								>
									<i class="icon-note"></i>
								</button>
								<button
									v-if="!model.deleted_at"
									title="Eliminar"
									type="submit"
									onclick="return confirm('¿Estás seguro de que quieres eliminar este elemento?')"
									class="btn btn-outline-danger btn-sm"
								>
									<i class="icon-trash"></i>
								</button>
								<button
									v-else
									title="Restaurar"
									type="button"
									class="btn btn-success btn-sm"
									@click="restore(model)"
								>
									<i class="icon-refresh"></i>
								</button>
							</div>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
		<section
			v-if="hasOrdersStatus"
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
import {orderBy} from 'lodash'
export default {
	props: {},
	data: function () {
		return {
			opacity: 0.3,
			model: "status_orders",
            model_name: 'estado'
		};
	},
	created() {},
	mounted() {
		this.fetch();
	},
	computed: {
		...mapGetters([
			"orderStatus",
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
		hasOrdersStatus() {
			return Boolean(this.orderStatus.data);
		},
		getOrdersStatus() {
			return this.orderedOrderStatus();
		},
		getLastPage: function () {
			return this.orderStatus.last_page;
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

		orderedOrderStatus: function () {
			return orderBy(this.orderStatus.data, "id");
		},

		async selectedOrderStatus(model) {
			await this.$store.commit("SET_SELECTED_ORDER_STATUS", {
				id: model.id,
				status: model.status,
				order: model.order,
                can_delete_order: model.can_delete_order,
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
