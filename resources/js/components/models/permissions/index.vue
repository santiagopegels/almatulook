<template>
	<div class="row">
		<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
			<div class="card card-accent-primary">
				<div class="card-header">
					<i class="icon-list"></i>
					{{title}}
				</div>
				<div class="card-body">
					<permissions-list />
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
			<permissions-form />
			<permissions-module />
		</div>
	</div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
	props: {
		title: {
			type: String,
			required: true,
		},
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
