let loading = 1200;
let timeOut = 5000;
const apiKey = 'x-api-key';

// general path
const api_admin = '/api/admin';

const path_users = '/api/key/users';
const path_users_all = '/api/admin/users_all';
const path_roles = '/api/admin/roles';
const path_roles_all = '/api/admin/roles_all';

const config = {
    headers: {
        'Content-Type': 'multipart/form-data'
    }
};

let actions = {

    // STATUS
    toggleStatus({ commit }) {
        commit('SET_STATUS');
    },

    /**
     * STORE
     */

    storeUser({ commit }, user) {
        return new Promise((resolve, reject) => {
            commit('SET_LOADING', true);
            window.axios.post(path_users, user, {}).then(async response => {
                if (response.data.success) {
                    await commit('PUSH_USER', response.data.data);
                    await commit('SET_SELECTED_USER');
                    await commit('SET_LOADING', false);
                    resolve(response.data);
                } else {
                    commit('SET_LOADING', false);
                    reject(response.data);
                }

            }).catch(error => {
                console.error('storeUser', error);
                commit('SET_LOADING', false);
                reject(response.data);
            });
        });
    },

    storeRole({ commit }, role) {
        commit('SET_LOADING', true);
        window.axios.post(path_roles, role, {}).then(async response => {
            if (response.data.success) {
                await commit('PUSH_ROLE', response.data.data);
                await commit('SET_LOADING', false);
                commit('SET_SELECTED_ROLE');
            } else {
                commit('SET_LOADING', false);
            }

        }).catch(error => {
            console.error('storeRole', error);
            commit('SET_LOADING', false);
        });

    },

    storePermission({ commit }, permission) {
        commit('SET_LOADING', true);
        window.axios.post(path_permissions, permission, {}).then(async response => {
            if (response.data.success) {
                await commit('PUSH_PERMISSION', response.data.data);
                await commit('SET_LOADING', false);
                commit('SET_SELECTED_PERMISSION');
            } else {
                commit('SET_LOADING', false);
            }

        }).catch(error => {
            console.error('storePermission', error);
            commit('SET_LOADING', false);
        });

    },

    storePermissions({ commit }, permissions) {
        commit('SET_LOADING', true);
        window.axios.post(path_permissions_stores, permissions, {}).then(async response => {
            if (response.data.success) {
                //await commit('PUSH_PERMISSION', response.data.data);
                await commit('SET_LOADING', false);
                commit('SET_SELECTED_PERMISSION');
            } else {
                commit('SET_LOADING', false);
            }

        }).catch(error => {
            console.error('storePermission', error);
            commit('SET_LOADING', false);
        });

    },

    /**
     * UPDATE
     */

    updateUser({ commit }, user) {
        return new Promise((resolve, reject) => {
            commit('SET_LOADING', true);
            const path = `${path_users}/${user.id}`;
            //console.log('path', path);
            window.axios.post(path, user, {}).then(async response => {
                if (response.data.success) {
                    await commit('REMOVE_USER', response.data.data);
                    await commit('PUSH_USER', response.data.data);
                    await commit('SET_SELECTED_USER');
                    await commit('SET_LOADING', false);
                    resolve(response.data);
                } else {
                    commit('SET_LOADING', false);
                    reject(response.data);
                }

            }).catch(error => {
                console.error('updateUser', error);
                commit('SET_LOADING', false);
                reject(response.data);
            });
        });
    },

    updateRole({ commit }, role) {
        commit('SET_LOADING', true);
        const path = `${path_roles}/${role.id}`;
        window.axios.post(path, role, {}).then(async response => {
            if (response.data.success) {
                await commit('REMOVE_ROLE', response.data.data);
                await commit('PUSH_ROLE', response.data.data);
                commit('SET_LOADING', false);
                commit('SET_SELECTED_ROLE');
            } else {
                commit('SET_LOADING', false);
            }

        }).catch(error => {
            console.error('updateRole', error);
            commit('SET_LOADING', false);
        });

    },

    updatePermission({ commit }, permission) {
        commit('SET_LOADING', true);
        const path = `${path_permissions}/${permission.id}`;
        window.axios.post(path, permission, {}).then(async response => {
            if (response.data.success) {
                await commit('REMOVE_PERMISSION', response.data.data);
                await commit('PUSH_PERMISSION', response.data.data);
                commit('SET_LOADING', false);
                commit('SET_SELECTED_PERMISSION');
            } else {
                commit('SET_LOADING', false);
            }

        }).catch(error => {
            console.error('updatePermission', error);
            commit('SET_LOADING', false);
        });

    },

    /**
     * FETCH
     */

    fetchUsers({ commit }, params) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_users;

            url = url.concat('?page=' + params.page);

            if (typeof params.term !== typeof undefined && String(params.term).length > 0) {
                url = url.concat('&term=' + params.term);
            }

            window.axios.get(url).then(async response => {
                if (response.data.success) {
                    await commit('SET_USERS', response.data.data);
                    await commit('SET_SELECTED_USER');
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchUsers', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchUsersAll({ commit }, params) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_users_all;

            window.axios.get(url).then(async response => {
                if (response.data.success) {
                    await commit('SET_USERS', response.data.data);
                    await commit('SET_SELECTED_USER');
                    await commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchUsers', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchRoles({ commit }, params) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_roles;

            if (params.page > 0) {
                url = url.concat('?page=' + params.page);
            }
            //console.log('url', url);

            window.axios.get(url).then(response => {
                if (response.data.success) {
                    commit('SET_ROLES', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchRoles', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchRolesAll({ commit }) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_roles_all;

            //console.log('url', url);

            window.axios.get(url).then(response => {
                if (response.data.success) {
                    commit('SET_ROLES', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchRolesAll', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchPermissionsAll({ commit }) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_permissions_all;

            //console.log('url', url);

            window.axios.get(url).then(response => {
                if (response.data.success) {
                    commit('SET_PERMISSIONS', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchPermissionsAll', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchPermissions({ commit }, params) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_permissions;

            if (params.page > 0) {
                url = url.concat('?page=' + params.page);
            }

            //console.log('url', url);

            window.axios.get(url).then(response => {
                if (response.data.success) {
                    commit('SET_PERMISSIONS', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchPermissions', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchTypeEvents({ commit }, params) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_type_events;

            if (params.page > 0) {
                url = url.concat('?page=' + params.page);
            }

            if (typeof params.term !== typeof undefined && String(params.term).length > 0) {
                url = url.concat('&term=' + params.term);
            }

            window.axios.get(url).then(response => {
                if (response.data.success) {
                    commit('SET_TYPE_EVENTS', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchTypeEvents', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchTypeEventsAll({ commit }, params) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_type_events_all;

            window.axios.get(url).then(response => {
                if (response.data.success) {
                    commit('SET_TYPE_EVENTS', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchTypeEvents', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchHostRoles({ commit }, params) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_host_roles;

            if (params.page > 0) {
                url = url.concat('?page=' + params.page);
            }

            if (typeof params.term !== typeof undefined && String(params.term).length > 0) {
                url = url.concat('&term=' + params.term);
            }

            window.axios.get(url).then(response => {
                if (response.data.success) {
                    commit('SET_HOST_ROLES', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchHostRoles', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchHostRolesAll({ commit }, params) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_host_roles_all;

            window.axios.get(url).then(response => {
                if (response.data.success) {
                    commit('SET_HOST_ROLES', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchHostRolesAll', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchHosts({commit}, params) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_hosts;

            if (params.page > 0) {
                url = url.concat('?page=' + params.page);
            }

            if (typeof params.term !== typeof undefined && String(params.term).length > 0) {
                url = url.concat('&term=' + params.term);
            }

            window.axios.get(url).then(response => {
                if (response.data.success) {
                    commit('SET_HOSTS', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchHosts', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchHostsAll({commit}, params) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_hosts_all;

            window.axios.get(url).then(response => {
                if (response.data.success) {
                    commit('SET_HOSTS', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchHosts', error);
                commit('SET_LOADING', false);
                reject({
                    status: false,
                    message: error
                });
            });
        });
    },

    fetchEvents({commit}, params) {
        commit('SET_LOADING', true);
        return new Promise((resolve, reject) => {
            var url = path_events;

            if (params.page > 0) {
                url = url.concat('?page=' + params.page);
            }

            if (typeof params.term !== typeof undefined && String(params.term).length > 0) {
                url = url.concat('&term=' + params.term);
            }

            window.axios.get(url).then(response => {
                if (response.data.success) {
                    commit('SET_EVENTS', response.data.data);
                    commit('SET_LOADING', false);
                    resolve({
                        status: true,
                        message: response.data.message
                    });
                } else {
                    commit('SET_LOADING', false);
                }

            }).catch(error => {
                console.error('fetchEvents', error);
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

    deleteUser({ commit }, params) {
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

    pushUserData({ commit }, user) {
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
    fetch({ commit }, params) {
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
                    await actions.removeFromData(commit, params);
                    await actions.setData(commit, { params: params, data: response.data.data });
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
    fetchAll({ commit }, params) {
        //console.log(`fetch.${params.model}`, params);
        return new Promise(async (resolve, reject) => {

            commit('SET_LOADING', true);

            params.model = params.model.concat('_all')
            console.log(params)
            var path = await actions.getEndpoint(params);

            console.log(`path.${params.model}`, path);

            window.axios.get(path).then(async response => {
                if (response.data.success) {
               //     await actions.removeFromData(commit, params);
                    await actions.setData(commit, { params: params, data: response.data.data });
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
    store({ commit }, params) {
        console.log(`store.${params.model}`, params);
        return new Promise(async(resolve, reject) => {
            commit('SET_LOADING', true);
            const path = await actions.getEndpoint(params);
           // console.log(`path.${params.model}`, path);
            console.log(params)
            window.axios.post(path, params.data, {}).then(async response => {
                if (response.data.success) {
                    await actions.removeFromData(commit, response.data.data);
                    await actions.pushData(commit, { params: params, data: response.data.data });
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
    update({ commit }, params) {
        console.log(`update.${params.model}`, params);
        return new Promise(async (resolve, reject) => {
            commit('SET_LOADING', true);
            const path = await actions.getEndpoint(params);
            console.log(`path.${params.model}`, path);
            window.axios.post(path, params.data, {}).then(async response => {
                console.log(`response.${params.model}`, response);
                if (response.data.success) {
                    await actions.removeFromData(commit, { model: params.model });
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
    delete({ commit }, params) {
        console.log(`delete.${params.model}`, params);
        return new Promise(async(resolve, reject) => {
            commit('SET_LOADING', true);
            const path = await actions.getEndpoint(params);
            console.log(`path.${params.model}`, path);
            window.axios.post(path, params, {}).then(async response => {
                console.log(`response.${params.model}`, response);
                if (response.data.success) {
                    await actions.removeFromData(commit, { model: params.model });
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
    restore({ commit }, params) {
        //console.log(`restore.${params.model}`, params);
        return new Promise(async (resolve, reject) => {
            commit('SET_LOADING', true);
            var path = await actions.getEndpoint(params);
            path = path.concat("/restore");
            console.log(`path.${params.model}`, path);
            window.axios.post(path, params.data, {}).then(async response => {
                if (response.data.success) {
                    await actions.removeFromData(commit, { model: params.model });
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
     * GET ENDPOINT
     * @param {*} params
     */
    async getEndpoint(params) {
        var path = `${api_admin}/${params.model}`;

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
    async setData(commit, content = { params, data }) {
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
                await commit('SET_SELECTED_ATTRIBUTE');
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

            default:
                break;
        }
    },

    /**
     * PUSH DATA
     * @param {*} commit
     * @param {*} params
     */
    async pushData(commit, content = { params, data }) {
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

            case 'values':
                await commit('PUSH_VALUE', content.data);
                await commit('SET_SELECTED_VALUE');
                break;

            case 'categories':
                await commit('PUSH_CATEGORY', content.data);
                await commit('SET_SELECTED_CATEGORY');
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

            default:
                break;
        }
    }
}

export default actions
