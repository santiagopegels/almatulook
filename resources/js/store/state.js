let state = {

    /**
     * Variables
     */
    status: false,
    showCartSideBar: false,
    showSiderDrawerLayout: false,
    canAddProductToBag: false,
    userLogged: {
        isAuthenticated: false,
        id: null
    },
    current: 0,
    isCheckedBagSession: false,
    loginFromPurchaseView: false,

    results: [],
    term: "",
    orderProducts: null,
    selectedValuesToFilter: [],
    bagProducts: [],
    shipCost: 0,
    mercadoPagoData: {},

    purchaseInfo: {
        isGuest: true,
        data: {
            user: {
                email: null,
            },
            profile: {
                personalInfo: {
                    name: null,
                    lastName: null
                },
                contact: {
                    cellphone: null,
                    address: {
                        deliveryAddress: null,
                        flat: null,
                        city: null,
                        province: null,
                        cp: null
                    }
                }
            },
        },
    },

    nodels_permissions: [
        'users',
        'roles',
        'permissions'
    ],

    data_permissions: [
        'create',
        'read',
        'update',
        'delete'
    ],

    isLoading: false,
    page: 1,

    /**
     * Models
     */
    users: [],
    roles: [],
    permissions: [],
    attributes: [],
    values: [],
    valuesAll: [],
    attributesAll: [],
    categories: [],
    categoriesAll: [],
    parameters: [],
    products: [],
    shipmentTypes: [],
    orderStatus: [],
    purchases: [],

    /**
     * Selected item
     */

    selected_user: {
        id: null,
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        rolesIds: [],
    },

    selected_role: {
        id: null,
        name: "",
        display_name: "",
        description: "",
        permissionsIds: []
    },

    selected_permission: {
        id: null,
        name: "",
        display_name: "",
        description: ""
    },

    selected_attribute: {
        id: null,
        name: "",
        slug: "",
        valuesIds: [],
    },

    selected_value: {
        id: null,
        name: "",
        slug: "",
        attributesIds: [],
    },

    selected_category: {
        id: null,
        name: "",
        description: "",
        slug: "",
        category_parent_id: null,
        children: [],
        attributesIds: []
    },

    selected_parameter: {
        id: null,
        parameter: "",
        value: "",
    },

    selected_product: {
        id: null,
        name: "",
        price: 0,
        cost_price: 0,
        categoryId: null,
        stocks: [],
        attributeValueSelected: [],
        images: []
    },

    selected_shipment_type: {
        id: null,
        name: "",
        description: "",
        cost: 0,
        addressRequired: true,
    },

    selected_order_status: {
        id: null,
        status: "",
        order: null,
        can_delete_order: false
    },

    selected_purchase: {
    },
}

export default state
