<template>
    <div>
        <a-drawer
            :width="width"
            placement="right"
            :closable="false"
            :visible="this.showCartSideBar"
            @close="onClose"
        >
            <template slot="title">
                <cart-drawer-header/>
            </template>
            <cart-drawer-content />
            <cart-drawer-footer />
        </a-drawer>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
import innerWidth from "../../generals/innerWidth";

export default {
    mixins: [innerWidth],
    data() {
        return {
            visible: false,
            width: 450,
        };
    },
    mounted() {
        this.$nextTick(() => {
            if (this.windowWidth < 450) {
                this.width = 330
            } else {
                this.width = 450
            }
        })
    },
    watch: {
        windowWidth(newWidth) {
            if (this.showCartSideBar) {
                if (newWidth < 450) {
                    this.width = 330
                } else {
                    this.width = 450
                }
            }
        }
    },
    computed: {
        ...mapGetters(["showCartSideBar"]),
    },
    methods: {
        showDrawer() {
            this.visible = true;
        },
        onClose() {
            this.$store.commit('TOGGLE_SHOW_CART_SIDEBAR')
        },
    },
};
</script>
