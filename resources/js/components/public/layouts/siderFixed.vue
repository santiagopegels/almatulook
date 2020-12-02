<template>
    <a-affix :offset-top="5">
        <a-layout-sider class="layout-sider" :width="siderWidth">
            <filter-menu />
        </a-layout-sider>
    </a-affix>
</template>
<script>
import innerWidth from "../../generals/innerWidth";
export default {
    mixins: [innerWidth],
    data() {
        return {
            siderWidth: 285,
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
        })
    },
    watch: {
        windowWidth(newWidth) {
            if (newWidth <= 768) {
                if (newWidth <= 540) {
                    this.siderWidth = 145
                } else {
                    this.siderWidth = 210
                }
            } else {
                this.siderWidth = 285
            }
        }
    },
}
</script>
