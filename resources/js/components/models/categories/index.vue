<template>
<div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <categories-treeview />
    </div>
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <categories-form />
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
