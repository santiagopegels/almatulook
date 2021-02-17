let loading = 1200;
let timeOut = 5000;
const apiKey = 'x-api-key';

// general path
const api_admin = '/api/admin';
const api_public = '/api';

const path_users = '/api/key/users';

const config = {
    headers: {
        'Content-Type': 'multipart/form-data'
    }
};

let actions = {

    // STATUS
    toggleStatus({commit}) {
        commit('SET_STATUS');
    },

    /**
     * SPECIFIC FETCH
     */
    fetchProductsWithStock({commit}, params) {
        //console.log(`fetch.${params.model}`, params);
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);

            var path = await actions.getEndpoint(params);

            path = path.concat('?page=' + (Number(params.page) > 0 ? Number(params.page) : 1));
            path = path.concat('&withAvailableStock=true');

            if (typeof params.term !== typeof undefined && String(params.term).length > 0) {
                path = path.concat('&term=' + params.term);
            }

            console.log(`path.${params.model}`, path);

            window.axios.get(path).then(async response => {
                if (response.data.success) {
                    console.log(response.data)
                    await actions.removeFromData(commit, params);
                    await actions.setData(commit, {params: params, data: response.data.data});
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`fetch.${params.model}`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    /**
     * DELETE
     */

    deleteUser({commit}, params) {
        //console.log('deleteUser.params', params);
        return new Promise((resolve, reject) => {
            commit('SET_LOADING', true);
            const path = `${path_users}/${params.user.id}`;
            // console.log('path', path);
            window.axios.post(path, params, {}).then(async response => {
                if (response.data.success) {
                    await commit('REMOVE_USER', params.user);
                    await commit('SET_SELECTED_USER');
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error('deleteUser', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    deleteStock({commit}, params) {
        console.log(`delete.product.stock`, params);
        return new Promise(async (resolve, reject) => {
            commit('SET_LOADING', true);
            const path = `${api_admin}/product/${params.product_id}/deleteStock`

            window.axios.post(path, params, {}).then(async response => {
                console.log(`response.${params.model}`, response);
                if (response.data.success) {
                    await actions.removeFromData(commit, {model: params.model});
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`delete.${params.model}`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    pushUserData({commit}, user) {
        console.log('pushUserData', user);
        return new Promise(async (resolve, reject) => {
            commit('SET_LOADING', true);

            try {
                await commit('SET_WIZARD_USER_DATA', user);
                commit('SET_LOADING', false);
                resolve();
            } catch (error) {
                commit('SET_LOADING', false);
                reject(error);
            }
        });
    },



    /**
     *  ***** NEW ACTIONS ******
     * ESTOS METODOS REEMPLAZAN A LOS QUE ESTAN ARRIBA :)
     */

    /**
     * FETCH DATA
     * model: ej: users, roles, etc (required)
     * page: ej: number for paginate (optional)
     * term: ej: any string for search (optional)
     * @param {*} params
     */
    fetch({commit}, params) {
        //console.log(`fetch.${params.model}`, params);
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);

            var path = await actions.getEndpoint(params);

            path = path.concat('?page=' + (Number(params.page) > 0 ? Number(params.page) : 1));

            if (typeof params.term !== typeof undefined && String(params.term).length > 0) {
                path = path.concat('&term=' + params.term);
            }

            console.log(`path.${params.model}`, path);

            window.axios.get(path).then(async response => {
                if (response.data.success) {
                    console.log(response.data)
                    await actions.removeFromData(commit, params);
                    await actions.setData(commit, {params: params, data: response.data.data});
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`fetch.${params.model}`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    /**
     * FETCH ALL DATA
     * model: ej: users, roles, etc (required)
     * without page
     * @param {*} params
     */
    fetchAll({commit}, params) {
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);

            params.model = params.model.concat('_all')

            var path = await actions.getEndpoint(params);

            console.log(`path.${params.model}`, path);

            window.axios.get(path).then(async response => {
                console.log(response)
                if (response.data.success) {
                    //     await actions.removeFromData(commit, params);
                    await actions.setData(commit, {params: params, data: response.data.data});
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`fetch.${params.model}`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    /**
     * STORE DATA
     * model: ej: users, roles, etc
     * data: ej: object {name: 'Jhon Doe', ...}
     * @param {*} params
     */
    store({commit}, params) {
        return new Promise(async (resolve, reject) => {
            commit('SET_LOADING', true);
            const path = await actions.getEndpoint(params);

            window.axios.post(path, params.data, {}).then(async response => {
                if (response.data.success) {
                    await actions.pushData(commit, {params: params, data: response.data.data});
                    await actions.removeFromData(commit, response.data.data);
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    /**
     * STORE DATA ALL ARRAY
     * model: ej: users, roles, etc
     * data: ej: object {name: 'Jhon Doe', ...}
     * @param {*} params
     */
    storeAll({commit}, params) {
        return new Promise(async (resolve, reject) => {
            commit('SET_LOADING', true);
            const path = await actions.getEndpoint(params);

            window.axios.post(path, params.data, {}).then(async response => {
                if (response.data.success) {
                    params.model = await params.model.concat('_all')
                    await actions.removeFromData(commit, response.data.data);
                    await actions.pushData(commit, {params: params, data: response.data.data});
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },
    /**
     * UPDATE DATA
     * model: ej: users, roles, etc
     * data: ej: object {ID: 1, name: 'Jhon Doe', ...}
     * @param {*} params
     */
    update({commit}, params) {
        console.log(`update.${params.model}`, params);
        return new Promise(async (resolve, reject) => {
            commit('SET_LOADING', true);
            const path = await actions.getEndpoint(params);
            console.log(`path.${params.model}`, path);
            window.axios.post(path, params.data, {}).then(async response => {
                console.log(`response.${params.model}`, response);
                if (response.data.success) {
                    await actions.removeFromData(commit, {model: params.model});
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`update.${params.model}`, JSON.stringify(error));
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    /**
     * DELETE DATA
     * model: ej: users, roles, etc
     * data: ej: object { id: 1, name: 'Jhon Doe', ...}
     * @param {*} params
     */
    delete({commit}, params) {
        console.log(`delete.${params.model}`, params);
        return new Promise(async (resolve, reject) => {
            commit('SET_LOADING', true);
            const path = await actions.getEndpoint(params);
            console.log(`path.${params.model}`, path);
            window.axios.post(path, params, {}).then(async response => {
                console.log(`response.${params.model}`, response);
                if (response.data.success) {
                    await actions.removeFromData(commit, {model: params.model});
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`delete.${params.model}`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    /**
     * RESTORE DATA
     * model: ej: users, roles, etc
     * id: ej: 1
     * @param {*} params
     */
    restore({commit}, params) {
        //console.log(`restore.${params.model}`, params);
        return new Promise(async (resolve, reject) => {
            commit('SET_LOADING', true);
            var path = await actions.getEndpoint(params);
            path = path.concat("/restore");
            console.log(`path.${params.model}`, path);
            window.axios.post(path, params.data, {}).then(async response => {
                if (response.data.success) {
                    await actions.removeFromData(commit, {model: params.model});
                    await commit('SET_LOADING', false);
                    resolve({
                        status: false,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`restore.${params.model}`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error.message.message
                });
            });
        });
    },

    /**
     * PUBLIC ACTIONS
     */

    updateProfileUser({commit}, params) {
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);

            var path = await actions.getPublicEndpoint(params);

            console.log(`path.${params.model}`, path);

            window.axios.post(path, params.data).then(async response => {
                if (response.data.success) {
                    console.log(response.data.message)
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                let errorMsg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0]
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: errorMsg
                });
            });
        })
    },

    pushProductToBag({commit}, payload) {

        delete payload['attributes']
        payload.quantity = 1

        return new Promise(async (resolve, reject) => {

            window.axios.post('/api/products/add/product/bag', payload, {}).then(async response => {
                if (response.data.success) {
                    await commit('PUSH_BAG_PRODUCT', payload)
                    await commit('TOGGLE_SHOW_CART_SIDEBAR')
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`pushProductToBag`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    removeProductToBag({commit}, payload) {

        delete payload['attributes']

        return new Promise(async (resolve, reject) => {

            window.axios.post('/api/products/remove/product/bag', payload, {}).then(async response => {
                if (response.data.success) {
                    await commit('REMOVE_BAG_PRODUCT', payload)
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`pushProductToBag`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    removeAllProductsToBag({commit}, payload) {

        return new Promise(async (resolve, reject) => {

            window.axios.post('/api/products/remove/all/product/bag', payload, {}).then(async response => {
                if (response.data.success) {
                    await commit('REMOVE_BAG_PRODUCT', [])
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`pushProductToBag`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    generatePaymentId({commit}, payload) {

        return new Promise(async (resolve, reject) => {

            window.axios.post('/api/generate/payment', payload, {}).then(async response => {
                if (response.data.success) {
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`generatePaymentID`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    storePurchase({commit}, params) {
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);

            window.axios.post('api/purchase', params).then(response => {
                if (response.data.data) {
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    resolve({
                        status: true,
                        message: null
                    });
                }
            }).catch(error => {
                console.log(`generatePurchase`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    storePayment({commit}, params) {
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);

            window.axios.post('api/payment', params).then(response => {
                if (response.data.data) {
                    commit('SET_LOADING', false);
                    commit('SET_BAG_PRODUCTS', []);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    resolve({
                        status: true,
                        message: null
                    });
                }
            }).catch(error => {
                console.log(`storePayment`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    /**
     * FETCH ALL DATA
     * model: ej: users, roles, etc (required)
     * without page
     * @param {*} params
     */
    fetchAllPublic({commit}, params) {
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);

            params.model = params.model.concat('_all')

            var path = await actions.getPublicEndpoint(params);

            console.log(`path.${params.model}`, path);

            window.axios.get(path).then(async response => {
                console.log(response)
                if (response.data.success) {
                    //     await actions.removeFromData(commit, params);
                    await actions.setData(commit, {params: params, data: response.data.data});
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`fetch.${params.model}`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchProductsPublic({commit}, params) {
        //console.log(`fetch.${params.model}`, params);
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);

            var path = await actions.getPublicEndpoint(params);

            path = path.concat('?page=' + (Number(params.page) > 0 ? Number(params.page) : 1));

            if (typeof params.term !== typeof undefined && String(params.term).length > 0) {
                path = path.concat('&term=' + params.term);
            }

            if (typeof params.category !== typeof undefined && params.category) {
                path = path.concat('&category=' + params.category);
            }

            if (typeof params.order !== typeof undefined && params.order) {
                path = path.concat('&order=' + params.order);
            }

            if (typeof params.valuesFilter !== typeof undefined && params.valuesFilter && params.valuesFilter.length) {
                path = path.concat('&attributesFilter=' + params.valuesFilter);
            }

            console.log(`path.${params.model}`, path);

            window.axios.get(path).then(async response => {
                if (response.data.success) {
                    console.log(response.data)
                    await actions.removeFromData(commit, params);
                    await actions.setData(commit, {params: params, data: response.data.data});
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    commit('SET_LOADING', false);
                    reject({
                        status: false,
                        message: response.data.message
                    });
                }

            }).catch(error => {
                console.error(`fetch.${params.model}`, error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchUserLogged({commit}, params) {
        //console.log(`fetch.${params.model}`, params);
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);

            var path = await actions.getPublicEndpoint({model: 'user_logged'});

            console.log(`path.user_logged`, path);

            window.axios.get(path).then(response => {
                if (response.data.data) {
                    commit('SET_USER_LOGGED', {
                        id: response.data.data,
                        isAuthenticated: true
                    });
                }
            })
        });
    },

    fetchUserProfile({commit}, params) {
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);

            var path = await actions.getPublicEndpoint(params);

            console.log(`path.${params.model}`, path);

            window.axios.get(path).then(response => {
                if (response.data.data) {
                    commit('SET_USER_PROFILE', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    resolve({
                        status: true,
                        message: null
                    });
                }
            })
        });
    },

    fetchUserBag({commit}) {
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);
            let params = {
                model: 'products',
                additional_path: 'bag'
            }

            let path = await actions.getPublicEndpoint(params);

            console.log(`path.${params.model}`, path);

            window.axios.get(path).then(async response => {
                if (response.data.data) {
                    await commit('SET_BAG_PRODUCTS', response.data.data);
                    await commit('TOGGLE_CHECK_BAG_SESSION');
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.data
                    });
                } else {
                    resolve({
                        status: true,
                        message: null
                    });
                }
            })
        });
    },

    /**
     * GET ENDPOINT
     * @param {*} params
     */
    async getEndpoint(params) {
        let path = `${api_admin}/${params.model}`;

        if (params.data && params.data.id) {
            path = path.concat(`/${params.data.id}`);
        }

        if (params.additional_path) {
            path = path.concat(`/${params.additional_path}`);
        }

        return path;
    },

    /**
     * GET PUBLIC ENDPOINT
     * @param {*} params
     */
    async getPublicEndpoint(params) {
        let path = `${api_public}/${params.model}`;

        if (params.data && params.data.id) {
            path = path.concat(`/${params.data.id}`);
        }

        if (params.additional_path) {
            path = path.concat(`/${params.additional_path}`);
        }

        return path;
    },
    /**
     * SET DATA
     * @param {*} commit
     * @param {*} params
     */
    async setData(commit, content = {params, data}) {
        console.log(content)
        switch (content.params.model) {

            case 'users':
                await commit('SET_USERS', content.data);
                await commit('SET_SELECTED_USER');
                break;

            case 'roles':
                await commit('SET_ROLES', content.data);
                await commit('SET_SELECTED_ROLE');
                break;

            case 'permissions':
                await commit('SET_PERMISSIONS', content.data);
                await commit('SET_SELECTED_PERMISSION');
                break;

            case 'attributes':
                await commit('SET_ATTRIBUTES', content.data);
                await commit('SET_SELECTED_ATTRIBUTE');
                break;

            case 'attributes_all':
                await commit('SET_ATTRIBUTES_ALL', content.data);
                break;

            case 'values':
                await commit('SET_VALUES', content.data);
                await commit('SET_SELECTED_VALUE');
                break;

            case 'values_all':
                await commit('SET_VALUES_ALL', content.data);
                await commit('SET_SELECTED_VALUE');
                break;

            case 'categories':
                await commit('SET_CATEGORIES', content.data);
                await commit('SET_SELECTED_CATEGORY');
                break;

            case 'categories_all':
                await commit('SET_CATEGORIES_ALL', content.data);
                break;

            case 'parameters':
                await commit('SET_PARAMETERS', content.data);
                await commit('SET_SELECTED_PARAMETER');
                break;

            case 'products':
                await commit('SET_PRODUCTS', content.data);
                await commit('SET_SELECTED_PRODUCT');
                break;

            case 'shipment_types':
                await commit('SET_SHIPMENT_TYPES', content.data);
                await commit('SET_SELECTED_SHIPMENT_TYPE');
                break;

            case 'shipment_types_all':
                await commit('SET_SHIPMENT_TYPES', content.data);
                await commit('SET_SELECTED_SHIPMENT_TYPE');
                break;

            case 'status_orders':
                await commit('SET_ORDER_STATUS', content.data);
                await commit('SET_SELECTED_ORDER_STATUS');
                break;

            default:
                break;
        }
    },

    /**
     * PUSH DATA
     * @param {*} commit
     * @param {*} params
     */
    async pushData(commit, content = {params, data}) {
        switch (content.params.model) {

            case 'users':
                await commit('PUSH_USER', content.data);
                await commit('SET_SELECTED_USER');
                break;

            case 'roles':
                await commit('PUSH_ROLE', content.data);
                await commit('SET_SELECTED_ROLE');
                break;

            case 'permissions':
                await commit('PUSH_PERMISSION', content.data);
                await commit('SET_SELECTED_PERMISSION');
                break;

            case 'attributes':
                await commit('PUSH_ATTRIBUTE', content.data);
                await commit('SET_SELECTED_ATTRIBUTE');
                break;

            case 'attributes_all':
                await commit('PUSH_ATTRIBUTES_ALL', content.data);
                await commit('SET_SELECTED_ATTRIBUTE');
                break;

            case 'values':
                await commit('PUSH_VALUE', content.data);
                await commit('SET_SELECTED_VALUE');
                break;

            case 'categories':
                await commit('PUSH_CATEGORY', content.data);
                await commit('SET_SELECTED_CATEGORY');
                break;

            case 'categories_all':
                await commit('PUSH_CATEGORY_ALL', content.data);
                await commit('SET_SELECTED_CATEGORY');
                break;

            case 'parameters':
                await commit('PUSH_PARAMETER', content.data);
                await commit('SET_SELECTED_PARAMETER');
                break;

            case 'products':
                await commit('PUSH_PRODUCT', content.data);
                break;

            case 'shipment_types':
                await commit('PUSH_SHIPMENT_TYPE', content.data);
                break;

            case 'status_orders':
                await commit('PUSH_ORDER_STATUS', content.data);
                break;

            default:
                break;
        }
    },

    /**
     * REMOVE DATA
     * @param {*} commit
     * @param {*} params
     */
    async removeFromData(commit, model) {
        //console.log(`removeFromData.${params.model}`, params);
        switch (model) {
            case 'users':
                await commit('SET_SELECTED_USER');
                break;

            case 'roles':
                await commit('SET_SELECTED_ROLE');
                break;

            case 'permissions':
                await commit('SET_SELECTED_PERMISSION');
                break;

            case 'attributes':
                await commit('SET_SELECTED_ATTRIBUTE');
                break;

            case 'values':
                await commit('SET_SELECTED_VALUE');
                break;

            case 'categories':
                await commit('SET_SELECTED_CATEGORY');
                break;

            case 'parameters':
                await commit('SET_SELECTED_PARAMETER');
                break;

            case 'products':
                await commit('SET_SELECTED_PRODUCT');
                break;

            case 'shipment_types':
                await commit('SET_SELECTED_SHIPMENT_TYPE');
                break;

            case 'status_orders':
                await commit('SET_SELECTED_ORDER_STATUS');
                break;

            default:
                break;
        }
    }
}

export default actions
