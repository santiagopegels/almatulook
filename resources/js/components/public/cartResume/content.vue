<template>
    <a-row style="padding-top: 20px;" type="flex" justify="center">
        <a-col :xs="{span: 22}"
               :sm="{span: 22}"
               :md="{span: 11, offset: 1}"
               :lg="{span: 12, offset: 1}"
               :xxl="{span: 11, offset: 1}">
            <a-row type="flex" align="middle">
                <h1 style="padding: 4px;">Mi Carrito</h1>
                <h3 style="padding: 6px">6 Productos</h3>
            </a-row>
            <cart-resume-product-row/>
            <cart-resume-product-row/>

        </a-col>
        <a-col style="margin-top: 65px"
               :xs="{span: 24}"
               :sm="{span: 12}"
               :md="{span: 9, offset: 1}"
               :lg="{span: 8, offset: 2}"
               :xxl="{span: 9, offset: 3}">
            <a-button style="margin-bottom: 10px" type="primary" size="large" block>Comprar</a-button>
            <summary-purchase/>
        </a-col>
    </a-row>
</template>
