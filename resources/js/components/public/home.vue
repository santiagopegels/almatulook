<template>
    <div>
        <header-layout/>
        <cart-drawer/>
        <a-row type="flex" justify="center">
            <home-product-card/>
        </a-row>
    </div>
</template>
<script>
export default {
    props: ['login']
}
</script>
