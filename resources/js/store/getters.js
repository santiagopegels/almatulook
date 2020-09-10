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

    generalObject: state => {
        return state.generalObject;
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

    values: state => {
        return state.values;
    },

    valuesAll: state => {
        return state.valuesAll;
    },

    attributesAll: state => {
        return state.attributesAll;
    },

    categories: state => {
        return state.categories;
    },

    categoriesAll: state => {
        return state.categoriesAll;
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

    selected_value: state => {
        return state.selected_value;
    },

    selected_category: state => {
        return state.selected_category;
    },
}

export default getters
