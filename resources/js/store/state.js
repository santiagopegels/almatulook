let state = {

    /**
     * Variables
     */
    status: false,

    results: [],
    term: "",

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
        category_parent_id: null
    },
}

export default state
