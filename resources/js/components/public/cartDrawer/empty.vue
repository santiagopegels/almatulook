<template>
    <a-row style="text-align: center">
        <h1>Su bolsa de compras está vacía</h1>
        <img width="30%" height="30%" :src="emptyBag" />
        <a-divider></a-divider>
    </a-row>
</template>
<script>
import emptyBag from '../../../../../public/img/shopping-bag.svg'
export default {
    data() {
        return {
            emptyBag: emptyBag
        }
    }
}
</script>
