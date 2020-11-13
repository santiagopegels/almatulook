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
                <a-row type="flex" justify="space-between">
                    <a-row>
                        <a-icon type="close-square" class="cart-drawer-icon" @click="onClose"/>
                    </a-row>
                    <a-row type="flex">
                        <a-space :size="20">
                            <a-icon type="crown" class="cart-drawer-icon"/>
                            <a-avatar style="backgroundColor:#9E7B1A" icon="user"/>
                        </a-space>
                    </a-row>
                </a-row>
                <br>
                <a-row>
                    <h2 class="cart-drawer-title">Mi Carrito</h2>
                </a-row>
            </template>
            <p>Some contents...</p>
            <p>Some contents...</p>
            <p>Some contents...</p>
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
