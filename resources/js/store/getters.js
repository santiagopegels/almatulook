let getters = {

    isLoading: state => {
        return state.isLoading;
    },

    current: state => {
        return state.current;
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

    purchaseInfo: state => {
        return state.purchaseInfo;
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

    userLogged: state => {
        return state.userLogged;
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

    shipmentTypes: state => {
        return state.shipmentTypes;
    },

    orderStatus: state => {
        return state.orderStatus;
    },

    purchases: state => {
        return state.purchases;
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

    selected_shipment_type: state => {
        return state.selected_shipment_type;
    },

    selected_order_status: state => {
        return state.selected_order_status;
    },

    selected_purchase: state => {
        return state.selected_purchase;
    },
}

export default getters
