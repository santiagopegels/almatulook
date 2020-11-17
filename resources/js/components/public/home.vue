<template>
    <div>
        <header-layout/>
        <header-menu />
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
