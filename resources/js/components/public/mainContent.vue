<template>
    <a-layout>
        <sider-layout />
          <a-layout-content :style="{ padding: '0 24px', maxWidth:'1400px', margin: 'auto'}">
            <a-row type="flex" justify="center" v-if="!show">
            <a-spin style="padding:5px;" size="large" />
            </a-row>
            <fade-transition :duration="800">
                <a-row type="flex" justify="center" v-if="show">
                    <router-link :to="{name: 'publicProductIndex'}">
                        <home-product-card/>
                    </router-link>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                </a-row>
            </fade-transition>

        </a-layout-content>
    </a-layout>
</template>
<script>
import {FadeTransition} from 'vue2-transitions'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
    components: {
        FadeTransition,
        Loading
    },
    data() {
        return {
            opacity: 0.3,
            show: true
        }
    },
    mounted() {
        setTimeout(() => {
            this.show = true
        }, 2000)
    }
}
</script>
