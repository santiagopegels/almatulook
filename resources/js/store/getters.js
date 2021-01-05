let getters = {

    isLoading: state => {
        return state.isLoading;
    },

    showCartSideBar: state => {
        return state.showCartSideBar;
    },

    showSiderDrawerLayout: state => {
        return state.showSiderDrawerLayout;
    },

    canAddProductToBag: state => {
        return state.canAddProductToBag;
    },

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

    shipCost: state => {
        return state.shipCost;
    },

    orderProducts: state => {
        return state.orderProducts;
    },

    selectedValuesToFilter: state => {
        return state.selectedValuesToFilter;
    },

    bagProducts: state => {
        return state.bagProducts;
    },

    /** MODELS */

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

    parameters: state => {
        return state.parameters;
    },

    products: state => {
        return state.products;
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

    selected_parameter: state => {
        return state.selected_parameter;
    },

    selected_product: state => {
        return state.selected_product;
    },
}

export default getters
