<template>
    <div>
        <div style="display: flex; justify-content: left">
            <a-button type="default" @click="prevStep()">
                <a-icon type="left"/>
            </a-button>
        </div>
        <a-icon type="credit-card" class="header-icon"/>
        <h1>Realizar Pago</h1>
        <img style="background: grey;width: 200px; height: 200px">
        <p>Escaneá el QR y pagá tu compra con MercadoPago</p>
        <a-button type="primary" block size="large">
            Pagar con Tarjeta
        </a-button>
    </div>
</template>

<script>
export default {
    methods: {
        handleSubmit(e) {
            e.preventDefault();
            this.form.validateFields((err, values) => {
                if (!err) {
                    console.log('Received values of form: ', values);
                }
            });
        },
        prevStep(){
            this.$emit('prev-step')
        }
    },
};
</script>
