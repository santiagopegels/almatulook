<template>
<div class="form-group">
    <label>Asignar valores</label>
    <div class="form-group scroll-vertical" v-if="hasValues">
        <div class="form-check form-check-inline mr-4 mb-2 mb-2 pointer" v-for="model in getValues" :key="model.id">
            <input class="form-check-input pointer" type="checkbox" v-model="algoIds" :id="model.id" :value="model.id" />
            <label class="form-check-label pointer" :for="model.id">{{model.name}}</label>
        </div>
    </div>
</div>
</template>

<script>
import {
    mapGetters
} from "vuex";
export default {
    props: {},
    data: function () {
        return {
        };
    },
    created() {},
    mounted() {
        this.fetchAll();
    },
    computed: {
        ...mapGetters(["isLoading", "valuesAll", "selected_attribute"]),
        algoIds: {
            set(val) {
                this.$store.state.selected_attribute.valuesIds = val;
            },
            get() {
                return this.$store.state.selected_attribute.valuesIds;
            },
        },
        hasValues() {
            return Boolean(this.valuesAll);
        },
        getValues() {
            return this.valuesAll;
        },
    },
    methods: {
        async fetchAll() {
            await this.$store.dispatch("fetchAll", {
                model: 'values',
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
    },
};
</script>
