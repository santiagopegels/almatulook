<template>
<div class="form-group">
    <label for="name">Asignar permisos</label>
    <div class="form-group scroll-vertical" v-if="hasPermissions">
        <div class="form-check form-check-inline mr-4 mb-2 mb-2 pointer" v-for="model in getPermissions" :key="model.id">
            <input class="form-check-input pointer" type="checkbox" v-model="permissionsIds" :id="model.id" :value="model.id" />
            <label class="form-check-label pointer" :for="model.id">{{model.display_name}}</label>
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
            model_name: 'permiso'
        };
    },
    created() {},
    mounted() {
        this.fetchPermissionsAll();
    },
    computed: {
        ...mapGetters(["isLoading", "permissions", "selected_role"]),
        permissionsIds: {
            set(val) {
                this.$store.state.selected_role.permissionsIds = val;
            },
            get() {
                return this.$store.state.selected_role.permissionsIds;
            },
        },
        hasPermissions() {
            return Boolean(this.permissions);
        },
        getPermissions() {
            return this.permissions;
        },
    },
    methods: {
        fetchPermissionsAll() {
            return this.$store.dispatch("fetchPermissionsAll")
                .catch(error => this.$toasted.global.ToastedError({
                    message: error.message.message
                }));
        },
    },
};
</script>
