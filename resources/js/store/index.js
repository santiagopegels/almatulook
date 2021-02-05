import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import mutations from './mutations'
import getters from './getters'
import state from "./state";
import VuexPersistence from 'vuex-persist';

Vue.use(Vuex);

const vuexSession = new VuexPersistence({
    storage: window.sessionStorage,
    reducer: (state) => ({
        userLogged: state.userLogged,
        isCheckedBagSession: state.isCheckedBagSession,
        bagProducts: state.bagProducts,
        purchaseInfo: state.purchaseInfo,
        selected_product: state.selected_product,
        selected_shipment_type: state.selected_shipment_type,
    }),
})

export default new Vuex.Store({
    state,
    mutations,
    getters,
    actions,
    plugins: [vuexSession.plugin]
})
