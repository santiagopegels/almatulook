<template>
    <div>
        <a-menu mode="horizontal" style="text-align: center">
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
