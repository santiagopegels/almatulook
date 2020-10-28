<template>
<div class="row">
    <div :class="{'col-lg-9 col-md-9':selected_product.id, 'col-lg-12 col-md-12':!selected_product.id}" class="col-sm-12 col-xs-12">
        <div class="card card-accent-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="align-item-center">
                <i class="icon-list"></i>
                {{title}}
                </div>
                <div class="align-item-center">
                    <form method="GET" :action="this.newProductRoute">
                    <button type="submit" class="btn btn-brand btn-success">
                        <i class="fa fa-plus"></i><span>Nuevo Producto</span>
                    </button>
                    </form>
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
    <div v-show='selected_product.id' class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
        <products-card></products-card>
    </div>
</div>
</template>

<script>
import {
    mapGetters
} from "vuex";
import Form from "./form";
export default {
    components: {Form},
    props: {
        title: {
            type: String,
            required: true,
        },
        newProductRoute: {
            type: String,
            required: true,
        },
    },
    data: function () {
        return {};
    },
    created() {},
    mounted() {
    },
    computed: {
        ...mapGetters(["isLoading", 'selected_product']),
    },
    methods: {
	},
};
</script>
