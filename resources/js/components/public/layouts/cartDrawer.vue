<template>
    <div>
        <a-drawer
            :width="width"
            placement="right"
            :closable="false"
            :visible="showCartSideBar"
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

export default {
    data() {
        return {
            visible: false,
            width: 450,
            windowWidth: window.innerWidth,
        };
    },
    mounted() {
        this.$nextTick(() => {
            if (this.windowWidth < 450) {
                this.width = 320
            }
            window.addEventListener('resize', this.onResize);
        })
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize);
    },
    watch: {
        windowWidth(newWidth) {
            if (this.showCartSideBar) {
                if (newWidth < 450) {
                    this.width = 320
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
        onResize() {
            this.windowWidth = window.innerWidth
        },
        showDrawer() {
            this.visible = true;
        },
        onClose() {
            this.$store.commit('TOGGLE_SHOW_CART_SIDEBAR')
        },
    },
};
</script>
