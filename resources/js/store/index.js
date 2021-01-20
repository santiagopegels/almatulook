import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import mutations from './mutations'
import getters from './getters'
import state from "./state";
import VuexPersistence from 'vuex-persist';

Vue.use(Vuex);

const vuexSession = new VuexPersistence({
    storage: window.sessionStorage
})

export default new Vuex.Store({
    state,
    mutations,
    getters,
    actions,
    plugins: [vuexSession.plugin]
})
