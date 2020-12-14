<template>
    <div>
        <cart-drawer-product v-for="product in bagProducts" :key="product.id" :product="product"/>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    computed: {
        ...mapGetters(['bagProducts'])
    },
};
</script>
