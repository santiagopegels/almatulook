<template>
    <div>
        <a-menu mode="horizontal" style="text-align: center">
            <a-menu-item key="order">
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
            <a-divider type="vertical"/>
            <a-menu-item key="filter" @click="toggleSiderFilter()">
                <a-icon type="control"/>
                Filtros
            </a-menu-item>
        </a-menu>
        <a-drawer
            title="Filtros"
            width="320"
            placement="left"
            :visible="this.showSiderDrawerLayout"
            @close="onClose"
        >
            <filter-menu/>
        </a-drawer>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    computed: {
        ...mapGetters(["showSiderDrawerLayout"]),
    },
    methods: {
        toggleSiderFilter() {
            this.$store.commit('TOGGLE_SHOW_SIDEBAR_DRAWER_LAYOUT');
        },
        onClose() {
            this.$store.commit('TOGGLE_SHOW_SIDEBAR_DRAWER_LAYOUT')
        },
    }
}
</script>
