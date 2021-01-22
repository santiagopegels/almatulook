<template>
    <div>
        <cart-drawer-product v-if="bagProducts.length > 0" v-for="product in bagProducts" :key="product.id" :product="product"/>
        <empty  v-show="!bagProducts.length > 0"/>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import Empty from './empty.vue'
export default {
    components: {Empty},
    computed: {
        ...mapGetters(['bagProducts'])
    },
};
</script>
