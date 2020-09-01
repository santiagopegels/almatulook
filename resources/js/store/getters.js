let getters = {

    isLoading: state => {
        return state.isLoading;
    },


    /** MODELS */

    status: state => {
        return state.status;
    },

    results: state => {
        return state.results;
    },

    term: state => {
        return state.term;
    },

    page: state => {
        return state.page;
    },

    users: state => {
        return state.users;
    },

    roles: state => {
        return state.roles;
    },

    permissions: state => {
        return state.permissions;
    },

    attributes: state => {
        return state.attributes;
    },

    /** SELECTED */

    selected_user: state => {
        return state.selected_user;
    },

    selected_role: state => {
        return state.selected_role;
    },

    selected_permission: state => {
        return state.selected_permission;
    },

    selected_attribute: state => {
        return state.selected_attribute;
    },
}

export default getters
