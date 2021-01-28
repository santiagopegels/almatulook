<template>
    <div>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card card-accent-primary">
                    <div class="card-header">
                        <i class="icon-list"></i>
                        Atributos
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-end mb-4">
                            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                                <attributes-filters/>
                            </div>
                        </div>
                        <attributes-list/>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <attributes-form/>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card card-accent-primary">
                    <div class="card-header">
                        <i class="icon-list"></i>
                        Valores
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-end mb-4">
                            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                                <values-filters/>
                            </div>
                        </div>
                        <values-list/>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <values-form/>
            </div>
        </div>
    </div>
</template>

<script>
import {
    mapGetters
} from "vuex";

export default {
    components: {
        AttributesList: () => import(/* webpackChunkName: "js/admin-attributes" */ './lists.vue'),
        AttributesForm: () => import(/* webpackChunkName: "js/admin-attributes" */ './form.vue'),
        AttributesFilters: () => import(/* webpackChunkName: "js/admin-attributes" */ './filters.vue'),
        ValuesList: () => import(/* webpackChunkName: "js/admin-attributes" */ '../values/lists.vue'),
        ValuesForm: () => import(/* webpackChunkName: "js/admin-attributes" */ '../values/form.vue'),
        ValuesFilters: () => import(/* webpackChunkName: "js/admin-attributes" */ '../values/filters.vue')
    },
    data: function () {
        return {};
    },
    created() {
    },
    mounted() {
    },
    computed: {
        ...mapGetters(["isLoading"]),
    },
    methods: {},
};
</script>
