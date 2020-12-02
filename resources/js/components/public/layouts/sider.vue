<template>
    <div>
        <a-affix :offset-top="top">
            <a-layout-sider v-if="showSiderLayoutFilter" class="layout-sider" :width="siderWidth">
                <sider-menu-layout/>
            </a-layout-sider>
        </a-affix>
        <a-menu mode="horizontal" style="text-align: center" v-if="showFilterHeaderMenu">
            <a-menu-item key="filter" @click="toggleSiderFilter()">
                <a-icon type="control"/>
                Filtros
            </a-menu-item>
            <a-divider type="vertical"/>
            <a-menu-item key="order">
                <a-icon type="swap"/>
                <a-select size="large" default-value="relevantes" style="width: 100%">
                    <a-select-option value="relevantes">
                        Más relevantes
                    </a-select-option>
                    <a-select-option value="vendidos">
                        Más vendidos
                    </a-select-option>
                    <a-select-option value="lanzamientos">
                        Lanzamientos
                    </a-select-option>
                    <a-select-option value="bajos">
                        Precio más bajos
                    </a-select-option>
                    <a-select-option value="altos">
                        Precio más altos
                    </a-select-option>
                </a-select>
            </a-menu-item>
        </a-menu>
        <a-drawer
            v-if="showSiderFilterDrawer"
            width="320"
            placement="left"
            :closable="false"
            :visible="this.showSiderLayout"
            @close="onClose"
        >
            <sider-menu-layout/>
        </a-drawer>
    </div>
</template>
<script>
import innerWidth from "../../generals/innerWidth";
import SiderMenu from "./siderMenu";
import {mapGetters} from 'vuex'

export default {
    components: {SiderMenu},
    mixins: [innerWidth],
    data() {
        return {
            siderWidth: 285,
            showSiderLayoutFilter: true,
            showSiderFilterDrawer: false,
            showFilterHeaderMenu: false
        }
    },
    mounted() {
        this.$nextTick(() => {
            if (this.windowWidth <= 768) {
                this.siderWidth = 210
            }
            if (this.windowWidth <= 540) {
                this.siderWidth = 145
            }
            if (this.windowWidth <= 400) {
                this.showSiderLayoutFilter = false
                this.showSiderFilterDrawer = true
                this.showFilterHeaderMenu = true
            }
        })
    },
    computed: {
        ...mapGetters(["showSiderLayout"]),
    },
    watch: {
        windowWidth(newWidth) {
            if (newWidth <= 768) {
                if (newWidth <= 540) {
                    if (this.windowWidth <= 400) {
                        this.showSiderLayoutFilter = false
                        this.showSiderFilterDrawer = true
                        this.showFilterHeaderMenu = true
                    } else {
                        this.showSiderLayoutFilter = true
                        this.showSiderFilterDrawer = false
                        this.showFilterHeaderMenu = false
                        this.siderWidth = 145
                    }
                } else {
                    this.siderWidth = 210
                }
            } else {
                this.siderWidth = 285
            }
        }
    },
    methods: {
        toggleSiderFilter() {
            this.$store.commit('TOGGLE_SHOW_SIDEBAR_LAYOUT');
        },
        onClose() {
            this.$store.commit('TOGGLE_SHOW_SIDEBAR_LAYOUT')
        },
    }
}
</script>
