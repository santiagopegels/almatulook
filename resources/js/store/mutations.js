const timeout = 20000;

let mutations = {

    /**
     * SET
     */
    SET_STATUS(state) {
        state.status = !state.status;
    },

    SET_LOGIN_FROM_PURCHASE_VIEW(state, isFromPurchaseView) {
        state.loginFromPurchaseView = isFromPurchaseView;
    },

    TOGGLE_SHOW_CART_SIDEBAR(state) {
        state.showCartSideBar = !state.showCartSideBar;
    },

    TOGGLE_CHECK_BAG_SESSION(state) {
        state.isCheckedBagSession = !state.isCheckedBagSession;
    },

    TOGGLE_SHOW_SIDEBAR_DRAWER_LAYOUT(state) {
        state.showSiderDrawerLayout = !state.showSiderDrawerLayout;
    },

    SET_RESULTS(state, results = []) {
        state.results = results;
    },

    SET_CAN_ADD_PRODUCT_TO_BAG(state, canAddProductToBag) {
        state.canAddProductToBag = canAddProductToBag;
    },

    SET_GENERAL_OBJECT(state, generalObject = []) {
        state.generalObject = generalObject;
    },

    SET_TERM(state, term = '') {
        state.term = term;
    },

    SET_ORDER_PRODUCTS(state, orderProducts) {
        state.orderProducts = orderProducts;
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

    SET_CATEGORIES(state, categories) {
        state.categories = categories;
    },

    SET_CATEGORIES_ALL(state, categoriesAll) {
        state.categoriesAll = categoriesAll;
    },

    SET_PARAMETERS(state, parameters) {
        state.parameters = parameters;
    },

    SET_PRODUCTS(state, products) {
        state.products = products;
    },

    SET_BAG_PRODUCTS(state, products) {
        state.bagProducts = products;
    },

    SET_SHIPMENT_TYPES(state, shipmentTypes) {
        state.shipmentTypes = shipmentTypes;
    },

    SET_ORDER_STATUS(state, orderStatus) {
        state.orderStatus = orderStatus;
    },

    SET_USER_LOGGED(state, payload = {
        id: null,
        isAuthenticated: false
    }) {
        state.userLogged = payload
    },

    SET_PURCHASE_USER_EMAIL(state, email) {
        state.purchaseInfo.data.user.email = email;
    },

    SET_SHIP_COST(state, cost) {
        state.shipCost = cost;
    },

    SET_USER_PROFILE(state, payload) {
        state.purchaseInfo.isGuest = false
        state.purchaseInfo.data.profile.personalInfo.name = payload.name
        state.purchaseInfo.data.profile.personalInfo.lastName = payload.lastname
        state.purchaseInfo.data.profile.contact.cellphone = Number(payload.cellphone)
        state.purchaseInfo.data.profile.contact.address.deliveryAddress = payload.deliveryAddress
        state.purchaseInfo.data.profile.contact.address.flat = payload.flat
        state.purchaseInfo.data.profile.contact.address.city = payload.city
        state.purchaseInfo.data.profile.contact.address.province = payload.province
        state.purchaseInfo.data.profile.contact.address.cp = payload.cp
    },

    SET_MERCADO_PAGO_DATA(state, payload) {
        state.mercadoPagoData = payload;
    },

    SET_PURCHASES(state, payload) {
        state.purchases = payload
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

    SET_SELECTED_CATEGORY(
        state, selected_category = {
            id: null,
            name: "",
            slug: "",
            description: "",
            category_parent_id: null,
            children: [],
            attributesIds: [],
        }
    ) {
        state.selected_category = selected_category;
    },

    SET_SELECTED_PARAMETER(
        state, selected_parameter = {
            id: null,
            parameter: "",
            value: ""
        }
    ) {
        state.selected_parameter = selected_parameter;
    },

    SET_SELECTED_PRODUCT(
        state, selected_product = {
            id: null,
            name: "",
            price: 0,
            cost_price: 0,
            categoryId: null,
            stocks: [],
            images: []
        }
    ) {
        state.selected_product = selected_product;
    },

    SET_SELECTED_SHIPMENT_TYPE(
        state, selected_shipment_type = {
            id: null,
            name: "",
            description: "",
            cost: 0,
            addressRequired: true
        }
    ) {
        state.selected_shipment_type = selected_shipment_type;
    },

    SET_SELECTED_ORDER_STATUS(
        state, selected_order_status = {
            id: null,
            status: "",
            order: null,
            can_delete_order: false
        }
    ) {
        state.selected_order_status = selected_order_status;
    },

    SET_SELECTED_PURCHASE(
        state, selected_purchase = {
            id: null,
            shipment_cost: null,
            shipment_type_id: null,
            total: 0,
            payment: {},
            profile: {},
            shipment: {}
        }
    ) {
        state.selected_purchase = selected_purchase;
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

    PUSH_ATTRIBUTE_ALL(state, attribute) {
        state.attributesAll.push(attribute);
    },

    PUSH_VALUE(state, value) {
        state.values.data.push(value);
    },

    PUSH_CATEGORY(state, category) {
        state.categories.data.push(category);
    },

    PUSH_CATEGORY_ALL(state, category) {
        state.categoriesAll.push(category);
    },

    PUSH_PARAMETER(state, parameter) {
        state.parameters.push(parameter);
    },

    PUSH_PRODUCT(state, product) {
        state.products.data.push(product);
    },

    PUSH_STOCK_DATA_PRODUCT(state, stockData) {
        state.selected_product.stocks.push(stockData);
    },

    PUSH_BAG_PRODUCT(state, product) {
        state.bagProducts.push(product);
    },

    PUSH_SELECTED_VALUES_FILTER(state, selectedValueToFilter) {
        state.selectedValuesToFilter.push(selectedValueToFilter)
    },

    PUSH_ATTRIBUTE_SELECTED_PRODUCT(state, payload) {
        state.selected_product.attributeValueSelected[payload.attributeIndex] = payload.value
    },

    PUSH_SHIPMENT_TYPE(state, shipmentType) {
        state.shipmentTypes.data.push(shipmentType);
    },

    PUSH_ORDER_STATUS(state, orderStatus) {
        state.orderStatus.data.push(orderStatus);
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

    REMOVE_CATEGORY(state, category) {
        try {
            let index = state.categories.data.findIndex(item => item.id === category.id);
            if (index < 0) return;
            state.categories.data.splice(index, 1);

        } catch (error) {
            console.error('REMOVE_CATEGORY.error', error);
        }
    },

    REMOVE_CATEGORY_FROM_ALL(state, category) {
        try {
            let removeCategory = function findIndexById(data, id) {
                for (var i = 0; i < data.length; i++) {

                    if (data[i].id === id) {

                        let index = data.findIndex(item => item.id === id);
                        data.splice(index, 1);
                        return data[i];

                    } else if (data[i].children && data[i].children.length && typeof data[i].children === "object") {
                        findIndexById(data[i].children, id);
                    }
                }
            }

            removeCategory(state.categoriesAll, category.id)
        } catch (error) {
            console.error('REMOVE_CATEGORY.error', error);
        }
    },

    REMOVE_PARAMETER(state, parameter) {
        try {
            let index = state.parameters.data.findIndex(item => item.id === parameter.id);
            if (index < 0) return;
            state.parameters.data.splice(index, 1);

        } catch (error) {
            console.error('REMOVE_PARAMETER.error', error);
        }
    },

    REMOVE_PRODUCT(state, product) {
        try {
            let index = state.products.data.findIndex(item => item.id === product.id);
            if (index < 0) return;
            state.products.data.splice(index, 1);

        } catch (error) {
            console.error('REMOVE_PRODUCT.error', error);
        }
    },

    REMOVE_BAG_PRODUCT(state, product) {
        try {
            let index = state.bagProducts.findIndex(item => item.id === product.id);
            if (index < 0) return;
            state.bagProducts.splice(index, 1);
        } catch (error) {
            console.error('REMOVE_BAG_PRODUCT.error', error);
        }
    },

    REMOVE_SELECTED_VALUES_FILTER(state, selectedValueToFilter) {
        try {
            let index = state.selectedValuesToFilter.findIndex(item => item === selectedValueToFilter);
            if (index < 0) return;
            state.selectedValuesToFilter.splice(index, 1);
        } catch (error) {
            console.error('REMOVE_SELECTED_VALUES_FILTER.error', error);
        }
    },

    REMOVE_ALL_SELECTED_VALUES_FILTER(state) {
            state.selectedValuesToFilter = []
    },

    REMOVE_ATTRIBUTE_SELECTED_PRODUCT(state, attributeId) {
        try {
            let index = state.selected_product.attributeValueSelected.findIndex(item => item.attribute_id === attributeId);
            if (index < 0) return;
            state.selected_product.attributeValueSelected.splice(index, 1);
        } catch (error) {
            console.error('REMOVE_ATTRIBUTE_SELECTED_PRODUCT.error', error);
        }
    },
}

export default mutations
