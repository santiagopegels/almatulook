<template>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12" :class="{'col-lg-12':!hasId, 'col-lg-8':hasId}">
            <div class="card card-accent-primary">
                <div class="card-header">
                    <i class="icon-list"></i>
                    {{ title }}
                </div>
                <div class="card-body">
                    <div class="row justify-content-end mb-4">
                        <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                            <parameters-filters/>
                        </div>
                    </div>
                    <parameters-list/>
                </div>
            </div>
        </div>
        <transition name="fade">
            <div v-show="hasId" class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <parameters-form/>
            </div>
        </transition>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

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
    created() {
    },
    mounted() {
    },
    computed: {
        ...mapGetters(["isLoading", "selected_parameter"]),
        hasId() {
            return Boolean(this.hasSelectedId());
        },
    },
    methods: {
        hasSelectedId() {
            if (!Boolean(this.selected_parameter)) return false;
            return Boolean(this.selected_parameter.id > 0);
        },
    },
};
</script>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity .9s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
