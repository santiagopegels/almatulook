<template>
    <div>
        <sider-fixed v-if="this.showSiderFixed" />
        <sider-drawer v-if="this.showSiderDrawer"/>
    </div>
</template>
<script>
import innerWidth from "../../generals/innerWidth";
export default {
    mixins: [innerWidth],
    data() {
        return {
            showSiderFixed: true,
            showSiderDrawer: false,
        }
    },
    mounted() {
        this.$nextTick(() => {
            if (this.windowWidth <= 400) {
                this.showSiderFixed = false
                this.showSiderDrawer = true
            }
        })
    },
    watch: {
        windowWidth(newWidth) {
            if (newWidth <= 400) {
                this.showSiderFixed = false
                this.showSiderDrawer = true
            } else {
                this.showSiderFixed = true
                this.showSiderDrawer = false
            }
        }
    },
}
</script>
