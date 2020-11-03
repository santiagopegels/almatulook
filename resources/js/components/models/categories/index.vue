<template>
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
            <categories-treeview :newRootNode="this.newRootNode"/>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
            <categories-form @newRootNode="loadNewRootNode"/>
        </div>
    </div>
</template>

<script>
import {
    mapGetters
} from "vuex";

export default {
    props: {
    },
    data: function () {
        return {
            newRootNode: null
        };
    },
    created() {
    },
    mounted() {
    },
    computed: {
        ...mapGetters(["isLoading"]),
    },
    methods: {
        loadNewRootNode(data) {
            this.newRootNode = data
        }
    },
};
</script>
