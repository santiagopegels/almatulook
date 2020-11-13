<template>
    <div>
        <header-layout />
        <cart-drawer />
        <button v-on:click="show = !show">
            Toggle
        </button>
        <fade-transition>
            <p key="asd" v-if="show">hola</p>
        </fade-transition>
        <a-row type="flex" justify="center">
        <home-product-card />
        </a-row>

    </div>
</template>
<script>
import {FadeTransition} from 'vue2-transitions'
export default {
    components: {
        FadeTransition
    },
    data(){
        return {
            show: true
        }
    },
props:['login']
}
</script>
<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0
}
</style>
