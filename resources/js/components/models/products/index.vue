<template>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-accent-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="align-item-center">
                <i class="icon-list"></i>
                {{title}}
                </div>
                <div class="align-item-center">
                    <button type="button" class="btn btn-brand btn-success">
                        <i class="fa fa-plus"></i><span>Nuevo Producto</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-end mb-4">
                    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                        <products-filters />
                    </div>
                </div>
                <products-list />
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    mapGetters
} from "vuex";
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
    methods: {

	},
};
</script>
