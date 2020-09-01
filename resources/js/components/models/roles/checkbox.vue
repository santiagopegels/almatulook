<template>
<div class="form-group scroll-vertical">
    <div class="form-check form-check-inline mr-4 mb-2 mb-2 pointer" v-for="model in getRoles" :key="model.id">
        <input class="form-check-input pointer" type="checkbox" v-model="rolesIds" :id="model.id" :value="model.id" />
        <label class="form-check-label pointer" :for="model.id">{{model.display_name}}</label>
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
        return {};
    },
    created() {},
    mounted() {
        this.fetchRolesAll();
    },
    computed: {
        ...mapGetters(["isLoading", "roles", "selected_user"]),
        rolesIds: {
            set(val) {
                this.$store.state.selected_user.rolesIds = val;
            },
            get() {
                return this.$store.state.selected_user.rolesIds;
            },
        },
        getRoles() {
            return this.roles;
        },
    },
    methods: {
        fetchRolesAll() {
            return this.$store.dispatch("fetchRolesAll")
                .catch(error => this.$toasted.global.ToastedError({
                    message: error.message.message
                }));
        },
    },
};
</script>
