<template>
    <div class="row">
        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
            <new-product-form></new-product-form>
        </div>
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <new-product-form></new-product-form>
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
    mounted() {},
    computed: {
        ...mapGetters(["isLoading"]),
    },
    methods: {
    },
};
</script>
