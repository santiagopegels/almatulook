<template>
<div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-accent-primary">
            <div class="card-header">
                <i class="icon-list"></i>
                {{title}}
            </div>
            <div class="card-body">
                <div class="row justify-content-end mb-4">
                    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                        <attributes-filters />
                    </div>
                </div>
                <attributes-list />
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <attributes-form />
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
