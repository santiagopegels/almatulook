const timeout = 20000;

let mutations = {

    /**
     * SET
     */
    SET_STATUS(state) {
        state.status = !state.status;
    },

    SET_RESULTS(state, results = []) {
        state.results = results;
    },

    SET_TERM(state, term = []) {
        state.term = term;
    },

    SET_PAGE(state, page) {
        state.page = page;
    },

    SET_LOADING(state, isLoading) {
        state.isLoading = isLoading;
    },

    SET_USERS(state, users) {
        state.users = users;
    },

    SET_ROLES(state, roles) {
        state.roles = roles;
    },

    SET_PERMISSIONS(state, permissions) {
        state.permissions = permissions;
    },

    SET_ATTRIBUTES(state, attributes) {
        state.attributes = attributes;
    },

    SET_VALUES(state, values) {
        state.values = values;
    },

    SET_VALUES_ALL(state, valuesAll) {
        state.valuesAll = valuesAll;
    },

    SET_ATTRIBUTES_ALL(state, attributesAll) {
        state.attributesAll = attributesAll;
    },

    /**
     * SET SELECTED
     */

    SET_SELECTED_USER(
        state, selected_user = {
            id: null,
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            rolesIds: []
        }
    ) {
        state.selected_user = selected_user;
    },

    SET_SELECTED_ROLE(
        state, selected_role = {
            id: null,
            name: "",
            display_name: "",
            description: "",
            permissionsIds: []
        }
    ) {
        state.selected_role = selected_role;
    },

    SET_SELECTED_PERMISSION(
        state, selected_permission = {
            id: null,
            name: "",
            display_name: "",
            description: ""
        }
    ) {
        state.selected_permission = selected_permission;
    },

    SET_SELECTED_ATTRIBUTE(
        state, selected_attribute = {
            id: null,
            name: "",
            slug: "",
            valuesIds: []
        }
    ) {
        state.selected_attribute = selected_attribute;
    },

    SET_SELECTED_VALUE(
        state, selected_value = {
            id: null,
            name: "",
            slug: "",
            attributesIds: []
        }
    ) {
        state.selected_value = selected_value;
    },

    /**
     * PUSH
     */

    PUSH_USER(state, user) {
        state.users.data.push(user);
    },

    PUSH_ROLE(state, role) {
        state.roles.data.push(role);
    },

    PUSH_PERMISSION(state, permission) {
        state.permissions.data.push(permission);
    },

    PUSH_ATTRIBUTE(state, attribute) {
        state.attributes.data.push(attribute);
    },

    PUSH_VALUE(state, value) {
        state.values.data.push(value);
    },

    /**
     * REMOVE
     */

    REMOVE_USER(state, user) {
        try {
            let index = state.users.data.findIndex(item => item.id === user.id);
            if (index < 0) return;
            state.users.data.splice(index, 1);

        } catch (error) {
            console.error('REMOVE_USER.error', error);
        }
    },

    REMOVE_ROLE(state, role) {
        try {
            let index = state.roles.data.findIndex(item => item.id === role.id);
            if (index < 0) return;
            state.roles.data.splice(index, 1);

        } catch (error) {
            console.error('REMOVE_ROLE.error', error);
        }
    },

    REMOVE_PERMISSION(state, permission) {
        try {
            let index = state.permissions.data.findIndex(item => item.id === permission.id);
            if (index < 0) return;
            state.permissions.data.splice(index, 1);

        } catch (error) {
            console.error('REMOVE_PERMISSION.error', error);
        }
    },

    REMOVE_ATTRIBUTE(state, attribute) {
        try {
            let index = state.attributes.data.findIndex(item => item.id === attribute.id);
            if (index < 0) return;
            state.attributes.data.splice(index, 1);

        } catch (error) {
            console.error('REMOVE_ATTRIBUTE.error', error);
        }
    },

    REMOVE_VALUE(state, value) {
        try {
            let index = state.values.data.findIndex(item => item.id === value.id);
            if (index < 0) return;
            state.values.data.splice(index, 1);

        } catch (error) {
            console.error('REMOVE_VALUE.error', error);
        }
    },
}

export default mutations
