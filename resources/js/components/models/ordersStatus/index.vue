<template>
	<div class="row justify-content-md-center">
		<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
			<div class="card card-accent-primary">
				<div class="card-header">
					<i class="icon-list"></i>
					Estados de las Ordenes
				</div>
				<div class="card-body">
					<div class="row justify-content-end mb-4">
						<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
							<!-- <roles-filters /> -->
						</div>
					</div>
					<orders-status-list />
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
			<orders-status-form />
		</div>
	</div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    components: {
        OrdersStatusList: () => import(/* webpackChunkName: "js/admin-orders-status" */ './lists.vue'),
        OrdersStatusForm: () => import(/* webpackChunkName: "js/admin-orders-status" */ './form.vue'),
    },
	data: function () {
		return {};
	},
	created() {},
	mounted() {},
	computed: {
		...mapGetters(["isLoading"]),
	},
	methods: {},
};
</script>
