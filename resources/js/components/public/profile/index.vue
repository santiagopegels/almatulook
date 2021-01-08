<template>
    <div>
        <header-layout/>
        <header-menu/>
        <cart-drawer/>
        <a-row style="padding-top: 10px;" type="flex" justify="center">
            <h1>Mis Datos</h1>
        </a-row>
        <a-row style="padding-bottom: 10px;" type="flex" justify="center">
            <a-col :xs="{span: 22}"
                   :sm="{span: 22}"
                   :md="{span: 11}"
                   :lg="{span: 11}"
                   :xxl="{span: 11}">
                <div class="form-dashed" style="padding: 10px;">
                <summary-purchase-step-profile-form buttonText="Actualizar" />
                </div>
            </a-col>
        </a-row>
        <footer-layout/>
    </div>
</template>

<style>
.steps-content {
    margin-top: 16px;
    border: 1px dashed #e9e9e9;
    border-radius: 6px;
    background-color: #fafafa;
    min-height: 200px;
    text-align: center;
    padding: 40px;
}
</style>
