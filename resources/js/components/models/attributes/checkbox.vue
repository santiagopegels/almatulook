<template>
<div class="form-group">
    <label>Asignar a Atributos</label>
    <div class="form-group scroll-vertical" v-if="hasAttributes">
        <div class="form-check form-check-inline mr-4 mb-2 mb-2 pointer" v-for="model in getAttributes" :key="model.id">
            <input class="form-check-input pointer" type="checkbox" v-model="attributesIds" :id="model.id" :value="model.id" />
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
            model: "attributes",
        };
    },
    created() {},
    mounted() {
        this.fetchAll();
    },
    computed: {
        ...mapGetters(["isLoading", "attributesAll", "selected_value"]),
        attributesIds: {
            set(val) {
                this.$store.state.selected_value.attributesIds = val;
            },
            get() {
                return this.$store.state.selected_value.attributesIds;
            },
        },
        hasAttributes() {
            return Boolean(this.attributesAll);
        },
        getAttributes() {
            return this.attributesAll;
        },
    },
    methods: {
        async fetchAll() {
            await this.$store.dispatch("fetchAll", {
                model: this.model,
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
    },
};
</script>
