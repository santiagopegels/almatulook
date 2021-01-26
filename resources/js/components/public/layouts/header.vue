<template>
    <section style="margin-top: 10px;">
        <a-row type="flex" justify="space-between" align="middle">
            <a-col :xs="{span: 12, order:1}"
                   :sm="{span: 12, order:1}"
                   :md="{span: 1, order:1}"
                   :lg="{span: 1, order:1}"
                   :xxl="{span: 1, order:1}">
                <router-link :to="{ name: 'home'}">
                    <img style="margin-left: 15px;" :src="logo" height="60px"/>
                </router-link>
            </a-col>
            <a-col :xs="{span: 16, order:3, offset: 4}"
                   :sm="{span: 16, order:3}"
                   :md="{span: 8, order:2}"
                   :lg="{span: 8, order:2}"
                   :xxl="{span: 8, order:2, pull:1}">
                <a-input-search placeholder="Buscar Producto"
                                size="large"
                                enter-button
                                allow-clear
                                @search="filterProducts(productSearchTerm)"
                                v-model="productSearchTerm"
                />
            </a-col>
            <a-col :xs="{span: 9, order:2}"
                   :sm="{span: 5, order:2}"
                   :md="{span: 4, order:3}"
                   :lg="{span: 3, order:3}"
                   :xxl="{span: 2, order:3}">
                <a-row type="flex" justify="space-around" align="middle" style="margin-right: 15px;">
                    <a-badge :count="bagProducts.length"
                             :number-style="{
                                backgroundColor: '#554B52',
                                color: 'white',
                              }">
                        <a-icon type="shopping" class="header-icon" @click="toggleCartSidebar"/>
                    </a-badge>
                    <div v-if="!userLogged.isAuthenticated">
                        <a href="/login" title="Iniciar Sesión">
                            <a-avatar style="backgroundColor:grey" icon="user"></a-avatar>
                        </a>
                    </div>
                    <div v-else>
                        <a-dropdown>
                            <a-menu slot="overlay">
                                <a-menu-item key="1">
                                    <router-link to="/profile">
                                        <a-icon type="form"/>
                                        Mis Datos
                                    </router-link>
                                </a-menu-item>
                                <a-menu-item key="2">
                                    <a href="/logout" title="Cerrar Sesión" @click="logout()">
                                        <a-icon type="logout"/>
                                        Cerrar Sesión
                                    </a>
                                </a-menu-item>
                            </a-menu>
                            <a-avatar style="backgroundColor:#9E7B1A" icon="user"></a-avatar>
                        </a-dropdown>
                    </div>
                </a-row>
            </a-col>
        </a-row>
        <a-divider style="margin-top: 10px; margin-bottom: 0px;" type="horizontal"/>
    </section>
</template>
<script>
import logo from '../../../../../public/img/logo/logo.png'
import {mapGetters} from 'vuex'

export default {
    data: function () {
        return {
            logo: logo,
            productSearchTerm: ''
        };
    },
    computed: {
        ...mapGetters(['showCartSideBar', 'bagProducts', 'userLogged']),
    },
    methods: {
        async toggleCartSidebar() {
            this.$store.commit('TOGGLE_SHOW_CART_SIDEBAR')
        },
        async filterProducts(term) {
            this.$store.commit('SET_PAGE', 1)
            this.$store.commit('SET_TERM', term)
        },
        logout(){
            this.$store.commit('SET_USER_LOGGED')
        }
    }
}
</script>
