<template>
    <section style="margin-top: 10px">
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
                <a-input-search placeholder="Buscar Producto" size="large" enter-button/>
            </a-col>
            <a-col :xs="{span: 12, order:2}"
                   :sm="{span: 7, order:2}"
                   :md="{span: 4, order:3}"
                   :lg="{span: 4, order:3}"
                   :xxl="{span: 3, order:3}">
                <a-row type="flex" justify="space-around" align="middle" style="margin-right: 15px;">
                    <a-badge count="3"
                             :number-style="{
                                backgroundColor: '#554B52',
                                color: 'white',
                              }">
                    <a-icon type="shopping-cart" class="header-icon" @click="toggleCartSidebar"/>
                    </a-badge>
                    <a-icon type="crown" class="header-icon"/>
                    <a href="/login">
                    <a-avatar style="backgroundColor:#9E7B1A" icon="user"></a-avatar>
                    </a>
                </a-row>
            </a-col>
        </a-row>
        <a-divider  style="margin-top: 10px; margin-bottom: 0px;" type="horizontal"/>
    </section>
</template>
<script>
import logo from '../../../../../public/img/logo/logo.png'
import {mapGetters} from 'vuex'
export default {
    data: function () {
        return {
            logo: logo,
        };
    },
    computed:{
        ...mapGetters(['showCartSideBar']),
    },
    methods: {
        async toggleCartSidebar(){
            this.$store.commit('TOGGLE_SHOW_CART_SIDEBAR')
        }
    }
}
</script>
