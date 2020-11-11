<template>
    <section style="margin-top: 12px;">
        <a-row type="flex" justify="space-between" align="middle">
            <a-col :lg="{span: 1, order:1}" :xs="{span: 12, order:1}">
                <img style="margin-left: 15px;" :src="logo" height="60px"/>
            </a-col>
            <a-col :lg="{span: 8, order:2}" :xs="{span: 16, order:3, offset: 4}">
                <a-input-search placeholder="Buscar Producto" size="large" enter-button @search="onSearch"/>
            </a-col>
            <a-col  :lg="{span: 4, order:3}" :xs="{span: 12, order:2}">
                <a-row type="flex" justify="space-around" align="middle" style="margin-right: 15px;">
                    <a-icon type="shopping-cart" class="header-icon"/>
                    <a-icon type="heart" class="header-icon"/>
                    <a-avatar style="backgroundColor:#9E7B1A" icon="user"/>
                </a-row>
            </a-col>
        </a-row>
        <a-divider type="horizontal"/>
    </section>
</template>
<script>
import logo from '../../../../../public/img/logo/logo.png'

export default {
    data: function () {
        return {
            logo: logo,
        };
    },
}
</script>
